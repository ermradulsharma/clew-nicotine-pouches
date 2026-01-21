<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;

use Session;
use App\Models\Cart;
use App\Models\CartTemp;
use App\Models\Checkout;
use App\Models\Country;
use App\Models\Product;
use App\Models\State;
use App\Models\User;
use App\Models\UserAddress;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sessionId = session()->getId();
        $carts = CartTemp::where('session_id', $sessionId)->get();
        if ($carts->isEmpty()) {
            return redirect()->route('cart');
        }
        $checkout = Checkout::where('session_id', $sessionId)->orderBy('id', 'desc')->first();
        $checkout_id = $checkout ? $checkout->id : "";
        if (!$checkout) {
            $checkout = UserAddress::where('user_id', Auth::id())->where('preferred', 1)->first();
        }
        $countries = Country::orderBy('title', 'asc')->get();
        $states = [];
        if ($checkout && isset($checkout->country_id)) {
            $states = State::where('country_id', $checkout->country_id)->orderBy('title', 'asc')->get();
        }
        $couponDiscount = Helper::couponDiscount();
        return view('public.checkout', ['carts' => $carts, 'couponDiscount' => $couponDiscount, 'countries' => $countries, 'states' => $states, 'checkout_id' => $checkout_id, 'checkout' => $checkout]);
    }

    public function store(Request $request)
    {
        // return session()->getId();
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required',
            'apartment' => 'required',
            'country' => 'required|max:255',
            'state' => 'required|max:255',
            'city' => 'required|max:255',
            'pincode' => 'required|numeric',
            'mobile' => 'required|numeric|digits:10',
            'dob' => 'required|date',
            'billing_first_name' => 'exclude_if:samebilling,1|max:255',
            'billing_last_name' => 'exclude_if:samebilling,1|max:255',
            'billing_address' => 'exclude_if:samebilling,1',
            'billing_apartment' => 'exclude_if:samebilling,1',
            'billing_country' => 'exclude_if:samebilling,1|max:255',
            'billing_state' => 'exclude_if:samebilling,1|max:255',
            'billing_city' => 'exclude_if:samebilling,1|max:255',
            'billing_pincode' => 'exclude_if:samebilling,1|numeric',
            'billing_mobile' => 'exclude_if:samebilling,1|numeric|digits:10',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        }
        /* $ageCheckerData = [
            "key" => "NFWinwircKadRISA9SzkZ5aIaGCPU4n6",
            "secret" => "qWWYIYnanacvUYgv",
            "data" => [
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "address" => $request->address,
                "city" => $request->city,
                "state" => \App\Models\State::where('id', $request->state)->value('code'),
                "zip" => $request->pincode,
                "country" => \App\Models\Country::where('id', $request->country)->value('code'),
                "dob_day" => 20,
                "dob_month" => 12,
                "dob_year" => 1989
            ],
            "options" => [
                "min_age" => 21
            ]
        ];
        $ageChecker = Helper::ageChecker($ageCheckerData);
        $ageCheckerData = json_decode($ageChecker);
        if ($ageCheckerData->status != "accepted") {
            switch ($ageCheckerData->status) {
                case 'denied':
                    $response = response()->json(['res' => 'denied', 'msg' => 'The verification request was denied. The customer may be underage or submitted an invalid ID (blurry, wrong name, etc.)']);
                    break;
                case 'signature':
                    $response = response()->json(['res' => 'denied', 'msg' => 'An e-signature is required from the customer.']);
                    break;
                case 'photo_id':
                    $response = response()->json(['res' => 'denied', 'msg' => 'A photo ID is required, the customer has not yet uploaded it.']);
                    break;
                case 'phone_validation':
                    $response = response()->json(['res' => 'denied', 'msg' => 'Customer must validate their mobile phone number via SMS code.']);
                    break;
                case 'pending':
                    $response = response()->json(['res' => 'denied', 'msg' => 'A photo ID was uploaded and is awaiting manual approval.']);
                    break;
                default:
                    $response = response()->json(['res' => 'denied', 'msg' => 'An error occurred which prevented your request from being fulfilled. Typically due to missing or invalid data.']);
            }
            return $response;
        } */
        $billingState = $request->state;
        $cartProducts = CartTemp::where('session_id', session()->getId())->get();
        $restrictedProducts = [];
        foreach ($cartProducts as $cartProducts) {
            $product = Product::find($cartProducts->product_id);
            if (empty($product->restricted_state)) {
                continue;
            }
            $restrictedStates = explode(',', $product->restricted_state);
            if (in_array($billingState, $restrictedStates)) {
                $restrictedProducts[] = [
                    'id' => $product->id,
                    'name' => $product->title ?? 'Unnamed Product',
                ];
            }
        }
        if (!empty($restrictedProducts)) {
            $names = collect($restrictedProducts)->pluck('name')->implode(', ');
            return response()->json([
                'res' => 'error',
                'msg' => 'The following products are restricted in the selected state: ' . $names,
                'restricted_products' => $restrictedProducts,
            ]);
        }

        if ($request->filled('id')) $data = \App\Models\Checkout::find($request->id);
        else $data = new \App\Models\Checkout;

        $data->user_id = auth()->user()->id;
        $data->session_id = session()->getId();
        $data->email = auth()->user()->email;
        $data->name = $request->first_name . " " . $request->last_name;
        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->mobile = $request->mobile;
        $data->dob = $request->dob;
        $data->address = $request->address;
        $data->apartment = $request->apartment;
        $data->pincode = $request->pincode;
        $data->city = $request->city;
        $data->state_id = $request->state;
        $data->state = \App\Models\State::where('id', $request->state)->value('title');;
        $data->country_id = $request->country;
        $data->country = \App\Models\Country::where('id', $request->country)->value('title');
        $data->samebilling = $request->samebilling ? 1 : 0;
        // $data->age_status = ($ageCheckerData->status) ? $ageCheckerData->status : null;
        // $data->age_uuid = ($ageCheckerData->uuid) ? $ageCheckerData->uuid : null;
        // $data->age_checker_res = $ageChecker;

        if ($request->samebilling) {
            $data->billing_name = $request->first_name . " " . $request->last_name;
            $data->billing_first_name = $request->first_name;
            $data->billing_last_name = $request->last_name;
            $data->billing_mobile = $request->mobile;
            $data->billing_address = $request->address;
            $data->billing_apartment = $request->apartment;
            $data->billing_pincode = $request->pincode;
            $data->billing_city = $request->city;
            $data->billing_state_id = $request->state;
            $data->billing_state = \App\Models\State::where('id', $request->state)->value('title');
            $data->billing_country_id = $request->country;
            $data->billing_country = \App\Models\Country::where('id', $request->country)->value('title');
        } else {
            $data->billing_name = $request->billing_first_name . " " . $request->billing_last_name;
            $data->billing_first_name = $request->billing_first_name;
            $data->billing_last_name = $request->billing_last_name;
            $data->billing_mobile = $request->billing_mobile;
            $data->billing_address = $request->billing_address;
            $data->billing_apartment = $request->billing_apartment;
            $data->billing_pincode = $request->billing_pincode;
            $data->billing_city = $request->billing_city;
            $data->billing_state_id = $request->billing_state;
            $data->billing_state = \App\Models\State::where('id', $request->billing_state)->value('title');
            $data->billing_country_id = $request->billing_country;
            $data->billing_country = \App\Models\Country::where('id', $request->billing_country)->value('title');
        }
        if ($data->save())
            return response()->json(['res' => 'success', 'msg' => 'Your details submited successfully.']);
        else
            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
    }

    public function shippingMethod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_method' => 'required|string|in:standard,usps_mail,ups_ground,ups_air',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'error', 'msg' => 'Choose a valid shipping method.']);
        }
        $data = Checkout::where('session_id', session()->getId())->orderBy('id', 'desc')->first();
        if (!$data) {
            return response()->json(['res' => 'error', 'msg' => 'Please add your shipping details first.']);
        }
        $shippingPrices = ['standard'   => 0.00, 'usps_mail'  => 13.05, 'ups_ground' => 15.09, 'ups_air'    => 14.95];
        $data->shipping_method = $request->shipping_method;
        $data->shipping_price = $shippingPrices[$request->shipping_method] ?? 0.00;
        if ($data->save()) {
            $carts = CartTemp::where('session_id', session()->getId())->get();
            $couponDiscount = Helper::couponDiscount();
            $priceHtml = view('public.parts.priceSection', ['carts' => $carts, 'shipping_price' => $data->shipping_price, 'couponDiscount' => $couponDiscount])->render();
            return response()->json(['res' => 'success', 'msg' => 'Your shipping method was saved successfully.', 'priceHtml' => $priceHtml]);
        }
    }

    public function ageVerificationWebhook(Request $request): JsonResponse
    {
        Log::info('Age verification webhook triggered.', $request->all());
        return response()->json(['allowVerification' => true], 200);
    }
}
