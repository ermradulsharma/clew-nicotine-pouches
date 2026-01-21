<?php

namespace App\Http\Controllers;

use Stripe;
use App\Models\Order;
use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
    protected $secret_key;

    public function __construct()
    {
        $this->secret_key = config('app.stripe_secret_key');
        $this->middleware('auth');
    }

    public function doPayment(Request $request)
    {

        $stripe = new \Stripe\StripeClient($this->secret_key);

        try {

            $totalAmount = 4.99;

            $customer = $stripe->customers->create([
                'name' => 'Rashid',
                'email' => 'mrashid@syruptech.com',
            ]);


            $pgresponse = $stripe->paymentIntents->create([
                // 'confirm'=> true,
                'automatic_payment_methods' => ['enabled' => true],
                'amount' => $totalAmount * 100,
                'currency' => 'usd',
                "customer" => $customer['id'],
                'confirm' => true,
                'confirmation_token' => $request->confirmationTokenId,
                //'payment_method' => '{{PAYMENT_METHOD_ID}}',
                //'confirm' => true,
                'return_url' => 'http://127.0.0.1:7000/thankyou',
                'metadata' => ['order_id' => '1231241sd3',]
            ]);

            // dd($pgresponse);

            //return redirect()->route('thankyou');
            return response()->json([
                'client_secret' => $pgresponse['client_secret'],
                'status' => $pgresponse['status'],
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            http_response_code(400);
            //error_log($e->getError()->message);
        }
    }
}
