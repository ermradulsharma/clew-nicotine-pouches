<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;

use Stripe;

use App\Models\Cart;
use App\Models\Order;
use App\Models\CartTemp;
use App\Models\Checkout;
use App\Models\Country;
use App\Models\CouponTemp;
use App\Models\CustomerPaymentProfile;
use App\Models\Payment;
use App\Models\State;
use App\Services\AuthorizeNetService;
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

    public function __construct(AuthorizeNetService $authorizeNet)
    {
        $this->middleware('auth');
        $this->authorizeNet = $authorizeNet;
    }
    // private $secret_key;

    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->secret_key = config('app.stripe_secret_key');
    // }

    public function index()
    {
        // return "hello";
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
        if (count($carts) > 0) {
            $checkout = Checkout::where('session_id', $sessionId)->orderBy('id', 'desc')->first();
            if ($checkout) {
                $couponData = CouponTemp::where('session_id', $sessionId)->orderBy('id', 'desc')->first();
                $couponDiscount = Helper::couponDiscount();
                $grand_total = number_format($carts->sum('total_discount_amount') + $checkout->shipping_price + $checkout->tax - $couponDiscount, 2);

                $order = new Order;
                $order->user_id = Auth::check() ? Auth::id() : $checkout->user_id;
                $order->session_id = $sessionId;
                $order->name = $checkout->name;
                $order->first_name = $checkout->first_name;
                $order->last_name = $checkout->last_name;
                $order->email = $checkout->email;
                $order->mobile = $checkout->mobile;
                $order->apartment = $checkout->apartment;
                $order->address = $checkout->address;
                $order->city = $checkout->city;
                $order->state = $checkout->state;
                $order->country = $checkout->country;
                $order->pincode = $checkout->pincode;
                $order->billing_name = $checkout->billing_name;
                $order->billing_first_name = $checkout->billing_first_name;
                $order->billing_last_name = $checkout->billing_last_name;
                $order->billing_mobile = $checkout->billing_mobile;
                $order->billing_apartment = $checkout->billing_apartment;
                $order->billing_address = $checkout->billing_address;
                $order->billing_city = $checkout->billing_city;
                $order->billing_state = $checkout->billing_state;
                $order->billing_country = $checkout->billing_country;
                $order->billing_pincode = $checkout->billing_pincode;
                $order->sub_total = $carts->sum('total_price');
                $order->total = $carts->sum('total_discount_amount');
                $order->shipping_method = $checkout->shipping_method;
                $order->shipping_total = $checkout->shipping_price;
                $order->tax = $checkout->tax;
                $order->coupon_code = $couponData->coupon_code ?? null;
                $order->coupon_discount = $couponData->discount ?? null;
                $order->coupon_amount = $couponDiscount;
                $order->grand_total = $grand_total;
                $order->order_status = 'New';
                $order->payment_status = 'Pending';
                $order->payment_mode = 'Online';
                if ($order->save()) {
                    session(['order_id' => $order->id]);
                    foreach ($carts as $item) {
                        $cart = new Cart;
                        $cart->user_id = $order->user_id;
                        $cart->session_id = $sessionId;
                        $cart->order_id = $order->id;
                        $cart->category_id = $item->category_id;
                        $cart->category_name = $item->category_name;
                        $cart->product_id = $item->product_id;
                        $cart->product_name = $item->product_name;
                        $cart->sku_code = $item->sku_code;
                        $cart->product_image = $item->product_image;
                        $cart->variant_id = $item->variant_id;
                        $cart->variant_name = $item->variant_name;
                        $cart->variant_qty = $item->variant_qty;
                        $cart->unit_mrp = $item->unit_mrp;
                        $cart->unit_price = $item->unit_price;
                        $cart->qty = $item->qty;
                        $cart->base_discount = $item->base_discount;
                        $cart->incremental_discount = $item->incremental_discount;
                        $cart->max_discount = $item->max_discount;
                        $cart->total_discount_amount = $item->total_discount_amount;
                        $cart->total_price = $item->total_price;
                        $cart->status = 'New';
                        $cart->product_status = 'New';
                        $cart->save();
                    }

                    // Send to Salesforce
                    try {
                        $salesforce = new SalesforceService(config('salesforce'));
                        $contact = $salesforce->createContact([
                            'Name' => $checkout->first_name . ' ' . $checkout->last_name,
                            'Phone' => $checkout->mobile,
                            'BillingStreet' => $checkout->address,
                            'BillingCity' => $checkout->city,
                            'BillingState' => $checkout->state,
                            'BillingPostalCode' => $checkout->pincode,
                            'BillingCountry' => $checkout->country,
                        ]);
                        // Log::info('Salesforce Contact Created', $contact);
                        $contactId = $contact['id'] ?? null;

                        if ($contactId) {
                            $sfOrder = $salesforce->createOrder([
                                'AccountId' => $contactId,
                                'EffectiveDate' => now()->toDateString(),
                                'Status' => 'Draft',
                                'Pricebook2Id'  => $salesforce->getStandardPricebookId(),
                                'Description' => 'Website Order #' . $order->id,
                            ]);
                            // Log::info('Salesforce Order Created', $sfOrder);
                            $sfOrderId = $sfOrder['id'] ?? null;
                            if ($sfOrderId) {
                                foreach ($carts as $item) {
                                    $productName = $item->product_name;
                                    $pricebookEntry = $salesforce->findPricebookEntryIdByProductName($productName);
                                    $pricebookEntryId = $pricebookEntry['Id'] ?? null;
                                    if (!$pricebookEntryId) {
                                        $pricebookEntryId = $salesforce->getOrCreatePricebookEntryId($item->product_name, $item->unit_price);
                                        // Log::info("PricebookEntryId for product: $pricebookEntryId");
                                    }
                                    $orderItem = $salesforce->createOrderItem([
                                        'OrderId' => $sfOrderId,
                                        'Quantity' => $item->qty,
                                        'UnitPrice' => $item->unit_price,
                                        'PricebookEntryId' => $pricebookEntryId,
                                        'Description' => $item->product_name,
                                    ]);
                                    // Log::info('Salesforce Order Item Created', $orderItem);
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error('Salesforce sync failed: ' . $e->getMessage());
                    }

                    // try {
                    //     $salesforce = new SalesforceService(config('salesforce'));

                    //     $uniqueId = 'shg' . $order->id . rand(100, 999); // Example of generating a unique ID

                    //     $personData = [
                    //         'FirstName' => $checkout->first_name,
                    //         'LastName'  => $checkout->last_name,
                    //         'Phone'     => $checkout->mobile,
                    //         'Email'     => $checkout->email,
                    //         'eCommerce Customer Unique ID' => $uniqueId,
                    //         'SalesOrder' => [
                    //             'Websiteorder'     => 'WOR' . $order->id,
                    //             'Tracking Number'  => 'TRK' . $order->id,
                    //             'Status'           => 'Order Confirmation',
                    //             'OrderstartDate'   => now()->format('m/d/Y'),
                    //             'Abandoned Cart'   => 'FALSE',
                    //             'BillingAddress'   => $checkout->billing_address,
                    //             'ShippingAddress'  => $checkout->address,
                    //             'DiscountCode'     => $order->coupon_code ?? '',
                    //             'Subtotal'         => $order->sub_total,
                    //             'Taxes'            => $order->tax,
                    //             'Discount'         => $order->coupon_discount ?? 0,
                    //             'Shipping'         => $order->shipping_total,
                    //             'Total'            => $order->grand_total,
                    //             'PersonAccount ID / eCommerce Customer Unique ID' => $uniqueId,
                    //         ],
                    //         'Product' => [
                    //             [
                    //                 'UniqueSKUNo' => $carts->first()->sku_code ?? '',
                    //             ],
                    //         ]
                    //     ];

                    //     $sfResponse = $salesforce->sendPersonAccountData($personData);
                    //     Log::info("Sent PersonAccount + Order to Salesforce", $sfResponse);
                    // } catch (\Exception $e) {
                    //     Log::error('Salesforce sync failed: ' . $e->getMessage());
                    // }


                    try {
                        $lastFourDigits = substr($request->cardNumber, -4);
                        $customerProfiles = CustomerPaymentProfile::where(['user_id' => $order->user_id])->get();
                        $matchedProfile = $customerProfiles->firstWhere('card_last_four', $lastFourDigits);
                        if (!$customerProfiles || !$matchedProfile) {
                            $date_expiry = \DateTime::createFromFormat('m / Y', $request->expiry);
                            $formatted_expiry = $date_expiry->format('Y-m');
                            $details = [
                                "email" => $checkout->email,
                                "number" => str_replace(' ', '', $request->cardNumber),
                                "expiry" => $formatted_expiry,
                                "cvc" => $request->cvc
                            ];
                            /** @var \net\authorize\api\contract\v1\CreateCustomerProfileResponse $response */
                            $profileId = $this->authorizeNet->createCustomerProfile($details);
                            if ($profileId) {
                                $responsePaymentProfile = $this->authorizeNet->addPaymentProfileToCustomer($profileId, $details);
                                if ($responsePaymentProfile) {
                                    /** @var \net\authorize\api\contract\v1\CreateTransactionResponse $charge */
                                    $charge = $this->authorizeNet->chargeSavedProfile($profileId, $responsePaymentProfile, $grand_total);
                                    if (!$charge || $charge->getMessages()->getResultCode() !== 'Ok') {
                                        return response()->json([
                                            'success' => false,
                                            'message' => $charge->getMessages(),
                                            'code' => $charge->getMessages()->getResultCode(),
                                        ], 400);
                                    }
                                    if ($charge && $charge->getMessages()->getResultCode() === 'Ok') {
                                        $transaction = $charge->getTransactionResponse();

                                        if ($transaction && $transaction->getResponseCode() === '1') {
                                            Payment::create([
                                                'user_id' => Auth::id() ?? 33,
                                                'order_id' => $order->id,
                                                'amount' => $grand_total,
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

                                            $order = Order::find($order->id);
                                            $order->pg_id = $transaction->getTransId();
                                            $order->pg_amount = $grand_total;
                                            $order->pg_status = 'successful';
                                            $order->payment_status = 'Paid';
                                            $order->transaction_id = $transaction->getTransId();
                                            $order->total_paid = $request->amount;
                                            $order->payment_date = now();
                                            $order->save();
                                        }
                                    }
                                }
                            }
                        }

                        Log::channel('godirect')->info('Starting SOAP order creation');
                        $sandbox = config('app.godirect_sandbox');
                        $url = config('app.godirect_url');
                        $action = config('app.godirect_action');
                        $userName = config('app.godirect_username');
                        // $password = config('app.godirect_password');
                        $password = htmlspecialchars(config('app.godirect_password'), ENT_XML1);
                        $paidAt = now()->toIso8601String();
                        $orderLineNo = 1;
                        Log::channel('godirect')->info('Fetching order and related data', ['order_id' => $order->id]);
                        $order = Order::with('cartProduct')->find($order->id);
                        $country = Country::where(['title' => $order->billing_country])->first();
                        $state = State::where(['country_id' => $country->id, 'title' => $order->billing_state])->first();
                        $stateCode = $state->code;
                        Log::channel('godirect')->info('Order fetched', ['country_code' => $order]);
                        Log::channel('godirect')->info('Country and state fetched', ['country_code' => $country->code, 'state_code' => $stateCode]);
                        $xml = <<<XML
                        <s:Envelope xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                                    xmlns:tns="http://tempuri.org/" xmlns:s="http://www.w3.org/2003/05/soap-envelope"
                                    xmlns:d4p1="http://schemas.datacontract.org/2004/07/Nop.Plugin.GoDirectSolutions.WebService.WebSrevices.CreateOrderService"
                                    xmlns:a="http://www.w3.org/2005/08/addressing"
                                    xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://tempuri.org/">
                                    <s:Header>
                                        <a:Action>{$action}</a:Action>
                                        <a:To>{$url}</a:To>
                                        <a:MessageID>urn:uuid:123e4567-e89b-12d3-a456-426614174000</a:MessageID>
                                        <a:ReplyTo>
                                            <a:Address>http://www.w3.org/2005/08/addressing/anonymous</a:Address>
                                        </a:ReplyTo>
                                    </s:Header>
                                    <s:Body>
                                        <CreateOrder xmlns="http://tempuri.org/">
                                            <order xmlns:d4p1="http://schemas.datacontract.org/2004/07/Nop.Plugin.GoDirectSolutions.WebService.WebSrevices.CreateOrderService"
                                                    xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
                                                    <d4p1:AffiliateId>{$order->id}</d4p1:AffiliateId>
                                                    <d4p1:BillingAddress>
                                                        <d4p1:Address1>{$order->billing_address}</d4p1:Address1>
                                                        <d4p1:City>{$order->billing_city}</d4p1:City>
                                                        <d4p1:Company>{$order->billing_name}</d4p1:Company>
                                                        <d4p1:Country>{$country->code}</d4p1:Country>
                                                        <d4p1:Email>{$order->email}</d4p1:Email>
                                                        <d4p1:FirstName>{$order->billing_first_name}</d4p1:FirstName>
                                                        <d4p1:LastName>{$order->billing_last_name}</d4p1:LastName>
                                                        <d4p1:PhoneNumber>{$order->billing_mobile}</d4p1:PhoneNumber>
                                                        <d4p1:PostalCode>{$order->billing_pincode}</d4p1:PostalCode>
                                                        <d4p1:StateProvince>{$stateCode}</d4p1:StateProvince>
                                                    </d4p1:BillingAddress>
                                                    <d4p1:CurrencyCode>USD</d4p1:CurrencyCode>
                                                    <d4p1:ExternalOrderReference>ORDER{$order->id}</d4p1:ExternalOrderReference>
                                                    <d4p1:Id>{$order->id}</d4p1:Id>
                                                    <d4p1:LineItems>
                        XML;
                        $orderLineNo = 1;
                        Log::channel('godirect')->debug("Cart Items for Order #{$order->id}", $order->cartProduct->toArray());
                        foreach ($order->cartProduct as $item) {
                            Log::channel('godirect')->debug("Cart Items Details for Order #{$item->id}", $item->toArray());
                            $weight = floatval(preg_replace('/[^\d.]/', '', $item->variant_name));
                            $totalPrice = number_format((float) $item->total_price, 2);
                            $unitPrice = number_format((float) $item->unit_price, 2);
                            Log::channel('godirect')->debug('Adding line item to XML', [
                                'sku' => $item->sku_code,
                                'variant_id' => $item->variant_id,
                                'variant_name' => $item->variant_name,
                                'weight' => $weight,
                                'total_price' => $totalPrice,
                                'unit_price' => $unitPrice,
                                'quantity' => $item->qty
                            ]);
                            $skuCode = $item->sku_code . '-' . strtoupper($item->variant_name);
                            Log::channel('godirect')->info("SKU Code {$skuCode}");
                            $xml .= <<<ITEM
                                        <d4p1:WSLineItem>
                                            <d4p1:CasePack>{$skuCode}</d4p1:CasePack>
                                            <d4p1:DCPI>{$item->variant_id}</d4p1:DCPI>
                                            <d4p1:DiscountAmountExclTax>{$item->total_discount_amount}</d4p1:DiscountAmountExclTax>
                                            <d4p1:DiscountAmountInclTax>{$item->total_discount_amount}</d4p1:DiscountAmountInclTax>
                                            <d4p1:ExternalReference>{$skuCode}</d4p1:ExternalReference>
                                            <d4p1:ItemWeight>{$weight}</d4p1:ItemWeight>
                                            <d4p1:OrderLineNo>{$orderLineNo}</d4p1:OrderLineNo>
                                            <d4p1:PriceInclTax>{$totalPrice}</d4p1:PriceInclTax>
                                            <d4p1:PriceExclTax>{$totalPrice}</d4p1:PriceExclTax>
                                            <d4p1:Quantity>{$item->qty}</d4p1:Quantity>
                                            <d4p1:UnitPriceExclTax>{$unitPrice}</d4p1:UnitPriceExclTax>
                                            <d4p1:UnitPriceInclTax>{$unitPrice}</d4p1:UnitPriceInclTax>
                                            <d4p1:UPCNumber>{$skuCode}</d4p1:UPCNumber>
                                        </d4p1:WSLineItem>
                                    ITEM;
                            $orderLineNo++;
                        }
                        $paidAt = now()->toIso8601String();

                        $xml .= <<<XML
                                                        </d4p1:LineItems>
                                                            <d4p1:OrderDiscount>{$order->coupon_amount}</d4p1:OrderDiscount>
                                                            <d4p1:OrderTotal>{$order->grand_total}</d4p1:OrderTotal>
                                                            <d4p1:PaidDateUtc>{$paidAt}</d4p1:PaidDateUtc>
                                                            <d4p1:PaymentMethod>{$order->shipping_method}</d4p1:PaymentMethod>
                                                            <d4p1:PaymentNotRequired>false</d4p1:PaymentNotRequired>
                                                            <d4p1:PaymentStatus>{$order->pg_status}</d4p1:PaymentStatus>
                                                            <d4p1:ShippingAddress i:nil="true" />
                                                            <d4p1:ShippingAddressSameAsBilling>true</d4p1:ShippingAddressSameAsBilling>
                                                            <d4p1:ShippingStatus i:nil="true" />
                                                            <d4p1:ShippingMethod i:nil="true" />
                                                            <d4p1:OrderType i:nil="true" />
                                                    </order>
                                                    <userName>{$userName}</userName>
                                                    <userPassword>{$password}</userPassword>
                                                    <options xmlns:d4p1="http://schemas.datacontract.org/2004/07/Nop.Plugin.GoDirectSolutions.WebService.WebSrevices.CreateOrderService">
                                                        <d4p1:SendEmailToBillingEmail>false</d4p1:SendEmailToBillingEmail>
                                                        <d4p1:SendEmailToShippingEmail>false</d4p1:SendEmailToShippingEmail>
                                                    </options>
                                                </CreateOrder>
                                            </s:Body>
                                        </s:Envelope>
                                    XML;

                        $maxAttempts = 3;
                        $attempt = 0;
                        $success = false;
                        $response = '';
                        Log::channel('godirect')->info('SOAP XML constructed');
                        while (!$success && $attempt < $maxAttempts) {
                            Log::channel('godirect')->info("SOAP attempt #$attempt");
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                'Content-Type: application/soap+xml; charset=utf-8',
                                'Content-Length: ' . strlen($xml)
                            ]);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

                            $response = curl_exec($ch);
                            $error = curl_error($ch);

                            if ($error) {
                                Log::channel('godirect')->warning("SOAP Attempt #{$attempt} Failed: " . $error);
                                $attempt++;
                                sleep(pow(2, $attempt));
                            } else {
                                $success = true;
                                Log::channel('godirect')->info('SOAP Response:', ['response' => $response]);
                            }
                            curl_close($ch);
                        }
                        if (!$success) {
                            Log::error('SOAP Request Failed after retries.');
                        }
                        CartTemp::where('session_id', $sessionId)->delete();
                        Checkout::where('session_id', $sessionId)->delete();
                        CouponTemp::where('session_id', $sessionId)->delete();
                        Log::channel('godirect')->info('SOAP order creation completed');
                        return response()->json(['client_secret' => "", 'status' => 200, "messages" => "success"]);
                    } catch (\Exception $e) {
                        Log::error('Error fetching customer payment profiles: ' . $e->getMessage());
                        return response()->json([
                            'success' => false,
                            'message' => 'An error occurred while fetching payment profiles.'
                        ], 500);
                    }


                    // try {
                    //     $stripe = new \Stripe\StripeClient($this->secret_key);
                    //     $customer = $stripe->customers->create([
                    //         'name' => $checkout->first_name,
                    //         'email' => $checkout->email,
                    //     ]);
                    //     $pgresponse = $stripe->paymentIntents->create([
                    //         'automatic_payment_methods' => ['enabled' => true],
                    //         'amount' => intval($grand_total * 100),
                    //         'currency' => 'usd',
                    //         "customer" => $customer['id'],
                    //         'confirm' => true,
                    //         'confirmation_token' => $request->confirmationTokenId,
                    //         'return_url' => route('orderPlaced'),
                    //         'metadata' => ['order_id' => $order->id,]
                    //     ]);

                    //     $status = $pgresponse['status'];
                    //     if ($status === 'succeeded') {
                    //         $order = Order::find($order->id);
                    //         $order->pg_id = $pgresponse['id'];
                    //         $order->pg_amount = $pgresponse['amount_received'];
                    //         $order->pg_status = $pgresponse['status'];
                    //         $order->payment_status = 'Paid';
                    //         if ($order->save()) {
                    //             $sandbox = config('app.godirect_sandbox');
                    //             $url = config('app.godirect_url');
                    //             $action = config('app.godirect_action');
                    //             $userName = config('app.godirect_username');
                    //             // $password = config('app.godirect_password');
                    //             $password = htmlspecialchars(config('app.godirect_password'), ENT_XML1);
                    //             $paidAt = now()->toIso8601String();
                    //             $orderLineNo = 1;

                    //             $order = Order::with('cartProduct')->find($order->id);
                    //             $country = Country::where(['title' => $order->billing_country])->first();
                    //             $state = State::where(['country_id' => $country->id, 'title' => $order->billing_state])->first();
                    //             $stateCode = $state->code;
                    //             $xml = <<<XML
                    //             <s:Envelope xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    //                         xmlns:tns="http://tempuri.org/" xmlns:s="http://www.w3.org/2003/05/soap-envelope"
                    //                         xmlns:d4p1="http://schemas.datacontract.org/2004/07/Nop.Plugin.GoDirectSolutions.WebService.WebSrevices.CreateOrderService"
                    //                         xmlns:a="http://www.w3.org/2005/08/addressing"
                    //                         xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://tempuri.org/">
                    //                         <s:Header>
                    //                             <a:Action>{$action}</a:Action>
                    //                             <a:To>{$url}</a:To>
                    //                             <a:MessageID>urn:uuid:123e4567-e89b-12d3-a456-426614174000</a:MessageID>
                    //                             <a:ReplyTo>
                    //                                 <a:Address>http://www.w3.org/2005/08/addressing/anonymous</a:Address>
                    //                             </a:ReplyTo>
                    //                         </s:Header>
                    //                         <s:Body>
                    //                             <CreateOrder xmlns="http://tempuri.org/">
                    //                                 <order xmlns:d4p1="http://schemas.datacontract.org/2004/07/Nop.Plugin.GoDirectSolutions.WebService.WebSrevices.CreateOrderService"
                    //                                         xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
                    //                                         <d4p1:AffiliateId>{$order->id}</d4p1:AffiliateId>
                    //                                         <d4p1:BillingAddress>
                    //                                             <d4p1:Address1>{$order->billing_address}</d4p1:Address1>
                    //                                             <d4p1:City>{$order->billing_city}</d4p1:City>
                    //                                             <d4p1:Company>{$order->billing_name}</d4p1:Company>
                    //                                             <d4p1:Country>{$country->code}</d4p1:Country>
                    //                                             <d4p1:Email>{$order->email}</d4p1:Email>
                    //                                             <d4p1:FirstName>{$order->billing_first_name}</d4p1:FirstName>
                    //                                             <d4p1:LastName>{$order->billing_last_name}</d4p1:LastName>
                    //                                             <d4p1:PhoneNumber>{$order->billing_mobile}</d4p1:PhoneNumber>
                    //                                             <d4p1:PostalCode>{$order->billing_pincode}</d4p1:PostalCode>
                    //                                             <d4p1:StateProvince>{$stateCode}</d4p1:StateProvince>
                    //                                         </d4p1:BillingAddress>
                    //                                         <d4p1:CurrencyCode>USD</d4p1:CurrencyCode>
                    //                                         <d4p1:ExternalOrderReference>ORDER{$order->id}</d4p1:ExternalOrderReference>
                    //                                         <d4p1:Id>{$order->id}</d4p1:Id>
                    //                                         <d4p1:LineItems>
                    //             XML;
                    //             $orderLineNo = 1;
                    //             foreach ($order->cartProduct as $item) {
                    //                 $weight = floatval(preg_replace('/[^\d.]/', '', $item->variant_name));
                    //                 $totalPrice = number_format((float) $item->total_price, 2);
                    //                 $unitPrice = number_format((float) $item->unit_price, 2);
                    //                 $xml .= <<<ITEM
                    //                             <d4p1:WSLineItem>
                    //                                 <d4p1:CasePack>{$item->sku_code}</d4p1:CasePack>
                    //                                 <d4p1:DCPI>{$item->variant_id}</d4p1:DCPI>
                    //                                 <d4p1:DiscountAmountExclTax>{$item->total_discount_amount}</d4p1:DiscountAmountExclTax>
                    //                                 <d4p1:DiscountAmountInclTax>{$item->total_discount_amount}</d4p1:DiscountAmountInclTax>
                    //                                 <d4p1:ExternalReference>{$item->sku_code}</d4p1:ExternalReference>
                    //                                 <d4p1:ItemWeight>{$weight}</d4p1:ItemWeight>
                    //                                 <d4p1:OrderLineNo>{$orderLineNo}</d4p1:OrderLineNo>
                    //                                 <d4p1:PriceInclTax>{$totalPrice}</d4p1:PriceInclTax>
                    //                                 <d4p1:PriceExclTax>{$totalPrice}</d4p1:PriceExclTax>
                    //                                 <d4p1:Quantity>{$item->qty}</d4p1:Quantity>
                    //                                 <d4p1:UnitPriceExclTax>{$unitPrice}</d4p1:UnitPriceExclTax>
                    //                                 <d4p1:UnitPriceInclTax>{$unitPrice}</d4p1:UnitPriceInclTax>
                    //                                 <d4p1:UPCNumber>{$item->sku_code}</d4p1:UPCNumber>
                    //                             </d4p1:WSLineItem>
                    //                         ITEM;
                    //                 $orderLineNo++;
                    //             }
                    //             $paidAt = now()->toIso8601String();
                    //             $xml .= <<<XML
                    //                                             </d4p1:LineItems>
                    //                                                 <d4p1:OrderDiscount>{$order->coupon_amount}</d4p1:OrderDiscount>
                    //                                                 <d4p1:OrderTotal>{$order->grand_total}</d4p1:OrderTotal>
                    //                                                 <d4p1:PaidDateUtc>{$paidAt}</d4p1:PaidDateUtc>
                    //                                                 <d4p1:PaymentMethod>{$order->shipping_method}</d4p1:PaymentMethod>
                    //                                                 <d4p1:PaymentNotRequired>false</d4p1:PaymentNotRequired>
                    //                                                 <d4p1:PaymentStatus>{$order->pg_status}</d4p1:PaymentStatus>
                    //                                                 <d4p1:ShippingAddress i:nil="true" />
                    //                                                 <d4p1:ShippingAddressSameAsBilling>true</d4p1:ShippingAddressSameAsBilling>
                    //                                                 <d4p1:ShippingStatus i:nil="true" />
                    //                                                 <d4p1:ShippingMethod i:nil="true" />
                    //                                                 <d4p1:OrderType i:nil="true" />
                    //                                         </order>
                    //                                         <userName>{$userName}</userName>
                    //                                         <userPassword>{$password}</userPassword>
                    //                                         <options xmlns:d4p1="http://schemas.datacontract.org/2004/07/Nop.Plugin.GoDirectSolutions.WebService.WebSrevices.CreateOrderService">
                    //                                             <d4p1:SendEmailToBillingEmail>false</d4p1:SendEmailToBillingEmail>
                    //                                             <d4p1:SendEmailToShippingEmail>false</d4p1:SendEmailToShippingEmail>
                    //                                         </options>
                    //                                     </CreateOrder>
                    //                                 </s:Body>
                    //                             </s:Envelope>
                    //                         XML;

                    //             $maxAttempts = 3;
                    //             $attempt = 0;
                    //             $success = false;
                    //             $response = '';

                    //             while (!$success && $attempt < $maxAttempts) {
                    //                 $ch = curl_init($url);
                    //                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    //                 curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    //                     'Content-Type: application/soap+xml; charset=utf-8',
                    //                     'Content-Length: ' . strlen($xml)
                    //                 ]);
                    //                 curl_setopt($ch, CURLOPT_POST, true);
                    //                 curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

                    //                 $response = curl_exec($ch);
                    //                 $error = curl_error($ch);

                    //                 if ($error) {
                    //                     Log::warning("SOAP Attempt #{$attempt} Failed: " . $error);
                    //                     $attempt++;
                    //                     sleep(pow(2, $attempt));
                    //                 } else {
                    //                     $success = true;
                    //                     Log::info('SOAP Response:', ['response' => $response]);
                    //                 }
                    //                 curl_close($ch);
                    //             }
                    //             if (!$success) {
                    //                 Log::error('SOAP Request Failed after retries.');
                    //             }
                    //             CartTemp::where('session_id', $sessionId)->delete();
                    //             Checkout::where('session_id', $sessionId)->delete();
                    //             CouponTemp::where('session_id', $sessionId)->delete();
                    //         }
                    //     }
                    //     return response()->json(['client_secret' => $pgresponse['client_secret'], 'status' => $pgresponse['status'],]);
                    // } catch (\Stripe\Exception\ApiErrorException $e) {
                    //     http_response_code(400);
                    //     return response()->json(['status' => 'failed',]);
                    // }
                }
            } else {
                return response()->json(['res' => 'error', 'msg' => 'Please add shipping address.', 'url' => route('checkout')]);
            }
        } else {
            return response()->json(['res' => 'error', 'msg' => 'Please add products in your cart.', 'url' => route('cart')]);
        }
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
