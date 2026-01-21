<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartTemp;
use App\Models\Checkout;
use App\Models\Country;
use App\Models\CouponTemp;
use App\Models\CustomerPaymentProfile;
use App\Models\Order;
use App\Models\Payment;
use App\Models\State;
use App\Services\AuthorizeNetService;
use App\Services\GoDirectService;
use App\Services\OrderService;
use App\Services\SalesforceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $authorizeNet;
    protected $orderService;
    protected $goDirectService;

    public function __construct(
        AuthorizeNetService $authorizeNet,
        OrderService $orderService,
        GoDirectService $goDirectService
    ) {
        $this->middleware('auth');
        $this->authorizeNet = $authorizeNet;
        $this->orderService = $orderService;
        $this->goDirectService = $goDirectService;
    }

    public function index()
    {
        $sessionId = session()->getId();
        $carts = CartTemp::where('session_id', $sessionId)->get();
        $checkout = Checkout::where('session_id', $sessionId)->first();
        $shipping_price = $checkout ? $checkout->shipping_price : 0;
        $couponDiscount = Helper::couponDiscount();
        return view('public.parts.authorizePaymentSection', ['carts' => $carts, 'shipping_price' => $shipping_price, 'couponDiscount' => $couponDiscount])->render();
    }

    public function store(Request $request)
    {
        $sessionId = session()->getId();
        $carts = CartTemp::where('session_id', $sessionId)->get();
        if ($carts->isEmpty()) {
            return response()->json(['message' => 'Cart is empty.'], 400);
        }

        $checkout = Checkout::where('session_id', $sessionId)->orderBy('id', 'desc')->first();
        if (!$checkout) {
            return response()->json(['res' => 'error', 'msg' => 'Please add shipping address.', 'url' => route('checkout')]);
        }

        $couponData = CouponTemp::where('session_id', $sessionId)->orderBy('id', 'desc')->first();
        $order = $this->orderService->createOrder($checkout, $carts, $couponData, $sessionId);

        if (!$order) {
            return response()->json(['res' => 'error', 'msg' => 'Failed to create order.'], 500);
        }

        session(['order_id' => $order->id]);

        // Salesforce Sync
        try {
            $salesforce = new SalesforceService(config('salesforce'));
            $this->syncWithSalesforce($salesforce, $order, $checkout, $carts);
        } catch (\Exception $e) {
            Log::error('Salesforce sync failed: ' . $e->getMessage());
        }

        // Payment Processing
        try {
            $paymentResult = $this->processPayment($request, $order, $checkout);
            if (!$paymentResult['success']) {
                return response()->json($paymentResult, 400);
            }
        } catch (\Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }

        // GoDirect Sync
        $this->goDirectService->sendOrderToGoDirect($order);

        // Cleanup
        CartTemp::where('session_id', $sessionId)->delete();
        Checkout::where('session_id', $sessionId)->delete();
        CouponTemp::where('session_id', $sessionId)->delete();

        return response()->json(['client_secret' => "", 'status' => 200, "messages" => "success"]);
    }

    protected function syncWithSalesforce($salesforce, $order, $checkout, $carts)
    {
        $contact = $salesforce->createContact([
            'Name' => $checkout->first_name . ' ' . $checkout->last_name,
            'Phone' => $checkout->mobile,
            'BillingStreet' => $checkout->address,
            'BillingCity' => $checkout->city,
            'BillingState' => $checkout->state,
            'BillingPostalCode' => $checkout->pincode,
            'BillingCountry' => $checkout->country,
        ]);
        $contactId = $contact['id'] ?? null;

        if ($contactId) {
            $sfOrder = $salesforce->createOrder([
                'AccountId' => $contactId,
                'EffectiveDate' => now()->toDateString(),
                'Status' => 'Draft',
                'Pricebook2Id'  => $salesforce->getStandardPricebookId(),
                'Description' => 'Website Order #' . $order->id,
            ]);
            $sfOrderId = $sfOrder['id'] ?? null;
            if ($sfOrderId) {
                foreach ($carts as $item) {
                    $pricebookEntry = $salesforce->findPricebookEntryIdByProductName($item->product_name);
                    $pricebookEntryId = $pricebookEntry['Id'] ?? $salesforce->getOrCreatePricebookEntryId($item->product_name, $item->unit_price);

                    $salesforce->createOrderItem([
                        'OrderId' => $sfOrderId,
                        'Quantity' => $item->qty,
                        'UnitPrice' => $item->unit_price,
                        'PricebookEntryId' => $pricebookEntryId,
                        'Description' => $item->product_name,
                    ]);
                }
            }
        }
    }

    protected function processPayment($request, $order, $checkout)
    {
        $lastFourDigits = substr($request->cardNumber, -4);
        $customerProfiles = CustomerPaymentProfile::where(['user_id' => $order->user_id])->get();
        $matchedProfile = $customerProfiles->firstWhere('card_last_four', $lastFourDigits);

        $profileId = null;
        $paymentProfileId = null;

        if (!$customerProfiles || !$matchedProfile) {
            $date_expiry = \DateTime::createFromFormat('m / Y', $request->expiry);
            if (!$date_expiry) {
                return ['success' => false, 'message' => 'Invalid expiry date format.'];
            }
            $formatted_expiry = $date_expiry->format('Y-m');
            $details = [
                "email" => $checkout->email,
                "number" => str_replace(' ', '', $request->cardNumber),
                "expiry" => $formatted_expiry,
                "cvc" => $request->cvc
            ];

            $profileId = $this->authorizeNet->createCustomerProfile($details);
            if ($profileId) {
                $paymentProfileId = $this->authorizeNet->addPaymentProfileToCustomer($profileId, $details);
                if ($paymentProfileId && is_string($paymentProfileId)) {
                    // Successfully created/retrieved profile IDs
                } else {
                    return ['success' => false, 'message' => 'Failed to create payment profile.'];
                }
            } else {
                return ['success' => false, 'message' => 'Failed to create customer profile.'];
            }
        } else {
            $profileId = $matchedProfile->customer_profile_id;
            $paymentProfileId = $matchedProfile->payment_profile_id;
        }

        if ($profileId && $paymentProfileId) {
            $charge = $this->authorizeNet->chargeSavedProfile($profileId, $paymentProfileId, $order->grand_total);

            if (!$charge || $charge->getMessages()->getResultCode() !== 'Ok') {
                return [
                    'success' => false,
                    'message' => $charge ? $charge->getMessages()->getMessage()[0]->getText() : 'Payment failed',
                    'code' => $charge ? $charge->getMessages()->getResultCode() : 'Error',
                ];
            }

            if (method_exists($charge, 'getTransactionResponse')) {
                $transaction = $charge->getTransactionResponse();
                if ($transaction && $transaction->getResponseCode() === '1') {
                    $this->recordPayment($order, $transaction, $profileId, $paymentProfileId);
                    return ['success' => true];
                }
            }
        }

        return ['success' => false, 'message' => 'Payment failed or profile not found.'];
    }

    protected function recordPayment($order, $transaction, $profileId, $responsePaymentProfile)
    {
        Payment::create([
            'user_id' => Auth::id() ?? 33,
            'order_id' => $order->id,
            'amount' => $order->grand_total,
            'currency' => 'USD',
            'status' => 'successful',
            'transaction_id' => $transaction->getTransId(),
            'authorization_code' => $transaction->getAuthCode(),
            'response_code' => $transaction->getResponseCode(),
            'response_message' => optional($transaction->getMessages()[0])->getDescription() ?? 'Approved',
            'customer_profile_id' => $profileId,
            'payment_profile_id' => $responsePaymentProfile,
            'paid_at' => now(),
        ]);

        $order->update([
            'pg_id' => $transaction->getTransId(),
            'pg_amount' => $order->grand_total,
            'pg_status' => 'successful',
            'payment_status' => 'Paid',
            'transaction_id' => $transaction->getTransId(),
            'total_paid' => $order->grand_total,
            'payment_date' => now(),
        ]);
    }

    public function orderPlaced()
    {
        $orderId = session('order_id');
        $userId = auth()->id();
        if (!$orderId || !$userId) {
            return redirect()->route('home')->with('error', 'Invalid order session.');
        }
        // $order = Order::where(['id' => $orderId, 'user_id' => $userId, 'payment_status' => 'Paid'])->first();
        $order = Order::where(['id' => $orderId, 'user_id' => $userId])->first();
        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }
        $carts = Cart::where(['order_id' => $order->id, 'user_id' => $userId])->get();
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Products', 'url' => route('products')],
            ['label' => 'Order'],
        ];
        return view('public.orderPlaced', compact('order', 'carts', 'breadcrumbs'));
    }

    public function orderCancelled()
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Products', 'url' => route('products')],
            ['label' => 'Cancel Order'],
        ];
        return view('public.orderCancelled', compact('breadcrumbs'));
    }
}
