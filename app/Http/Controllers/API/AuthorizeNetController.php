<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CustomerPaymentProfile;
use App\Models\Payment;
use App\Services\AuthorizeNetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthorizeNetController extends Controller
{
    protected $authorizeNet;

    public function __construct(AuthorizeNetService $authorizeNet)
    {
        $this->authorizeNet = $authorizeNet;
    }
    public function createCustomerProfile(Request $request)
    {
        /** @var \net\authorize\api\contract\v1\CreateCustomerProfileResponse $response */
        $response = $this->authorizeNet->createCustomerProfile($request->all());
        Log::info(json_decode(json_encode($response), true));
        if ($response && $response->getMessages()->getResultCode() === 'Ok') {
            $profileId = $response->getCustomerProfileId();
            Log::info(json_decode(json_encode($profileId), true));
            // Get the first payment profile ID
            $paymentProfileIdList = $response->getCustomerPaymentProfileIdList();
            $paymentProfileId = $paymentProfileIdList ? $paymentProfileIdList[0] : null;

            // ✅ Extract shipping address IDs if available
            $shippingAddressIdList = $response->getCustomerShippingAddressIdList();

            Log::info(json_decode(json_encode($shippingAddressIdList), true));
            if ($paymentProfileId) {
                \App\Models\CustomerPaymentProfile::create([
                    'user_id' => 1,
                    'customer_profile_id' => $profileId,
                    'payment_profile_id' => $paymentProfileId,
                    'card_last_four' => substr($request->number, -4),
                    'card_type' => $this->getCardType($request->number),
                    'is_default' => true,
                ]);
            }
        }

        return response()->json($response);
    }

    private function getCardType($number)
    {
        $number = preg_replace('/\D/', '', $number);

        if (preg_match('/^4[0-9]{6,}$/', $number)) return 'Visa';
        if (preg_match('/^5[1-5][0-9]{5,}$/', $number)) return 'MasterCard';
        if (preg_match('/^3[47][0-9]{5,}$/', $number)) return 'American Express';
        if (preg_match('/^6(?:011|5[0-9]{2})[0-9]{3,}$/', $number)) return 'Discover';

        return 'Unknown';
    }
    public function addPaymentProfile(Request $request, $customerProfileId)
    {
        /** @var \net\authorize\api\contract\v1\CreateCustomerProfileResponse $response */
        $response = $this->authorizeNet->addPaymentProfileToCustomer($customerProfileId, $request->all());
        if ($response && $response->getMessages()->getResultCode() === 'Ok') {

            $paymentProfileIdList = $response->getCustomerPaymentProfileIdList();
            $paymentProfileId = $paymentProfileIdList ? $paymentProfileIdList[0] : null;
            \App\Models\CustomerPaymentProfile::create([
                'user_id' => 1,
                'customer_profile_id' => $customerProfileId,
                'payment_profile_id' => $paymentProfileId,
                'card_last_four' => substr($request->number, -4),
                'card_type' => $this->getCardType($request->number),
                'is_default' => true,
            ]);
        }
        return response()->json($response);
    }

    // public function charge(Request $request)
    // {
    //     $response = $this->authorizeNet->chargeSavedProfile(
    //         $request->customerProfileId,
    //         $request->paymentProfileId,
    //         $request->amount
    //     );
    //     return response()->json($response);
    // }

    public function charge(Request $request)
    {
        $response = $this->authorizeNet->chargeSavedProfile(
            $request->customerProfileId,
            $request->paymentProfileId,
            $request->amount
        );

        /** @var \net\authorize\api\contract\v1\CreateTransactionResponse $response */

        if ($response && $response->getMessages()->getResultCode() === 'Ok') {
            $transaction = $response->getTransactionResponse();

            if ($transaction && $transaction->getResponseCode() === '1') {
                $order = \App\Models\Order::find($request->order_id);

                if (!$order) {
                    return response()->json(['error' => 'Invalid order_id'], 422);
                }

                \App\Models\Payment::create([
                    'user_id' => auth()->id() ?? 33, // fallback for testing
                    'order_id' => $order->id,
                    'amount' => $request->amount,
                    'currency' => 'USD',
                    'status' => 'successful',
                    'transaction_id' => $transaction->getTransId(),
                    'authorization_code' => $transaction->getAuthCode(),
                    'response_code' => $transaction->getResponseCode(),
                    'response_message' => optional($transaction->getMessages()[0])->getDescription() ?? 'Approved',
                    'customer_profile_id' => $request->customerProfileId,
                    'payment_profile_id' => $request->paymentProfileId,
                    'paid_at' => now(),
                ]);
            }
        }

        return response()->json($response);
    }



    public function refund(Request $request)
    {
        $response = $this->authorizeNet->refundTransaction(
            $request->transactionId,
            $request->amount,
            $request->cardLastFour
        );
        return response()->json($response);
    }

    public function void(Request $request)
    {
        $response = $this->authorizeNet->voidTransaction($request->transactionId);
        return response()->json($response);
    }

    public function getTransaction($transactionId)
    {
        $response = $this->authorizeNet->getTransactionDetails($transactionId);
        return response()->json($response);
    }

    public function deleteCustomer($customerProfileId)
    {
        $response = $this->authorizeNet->deleteCustomerProfile($customerProfileId);
        return response()->json($response);
    }

    public function deleteCard($customerProfileId, $paymentProfileId)
    {
        $response = $this->authorizeNet->deletePaymentProfile($customerProfileId, $paymentProfileId);
        return response()->json($response);
    }

    public function getCustomerProfile($customerProfileId)
    {
        try {
            /** @var GetCustomerProfileResponse $response */
            $response = $this->authorizeNet->getCustomerProfile($customerProfileId);
            if ($response != null && $response->getMessages()->getResultCode() == "Ok") {
                $profile = $response->getProfile();
                return response()->json([
                    'success' => true,
                    'profile' => [
                        'customerProfileId' => $profile->getCustomerProfileId(),
                        'description' => $profile->getDescription(),
                        'email' => $profile->getEmail(),
                        'merchantCustomerId' => $profile->getMerchantCustomerId(),
                        'paymentProfiles' => $profile->getPaymentProfiles()
                    ]
                ]);
            } else {
                $errorMessages = $response->getMessages()->getMessage();
                return response()->json([
                    'success' => false,
                    'message' => $errorMessages[0]->getText()
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function completeCode(Request $request)
    {
        $userId = 3;
        $orderId = 59;
        $amount = 50;
        $lastFourDigits = substr($request->number, -4);
        $customerProfiles = CustomerPaymentProfile::where(['user_id' => $userId])->get();
        // Log::info('customer Profiles Controller', json_decode($customerProfiles, true));
        if ($customerProfiles->isEmpty()) {
            $details = [
                "email" => $request->email,
                "number" => $request->number,
                "expiry" => $request->expiry,
                "cvc" => $request->cvc
            ];
            /** @var \net\authorize\api\contract\v1\CreateCustomerProfileResponse $response */
            $response = $this->authorizeNet->createCustomerProfile($details);
            // Log::info('response Controller', [$response]);
            if ($response && $response->getMessages()->getResultCode() === 'Ok') {
                $profileId = $response->getCustomerProfileId();
                // Log::info('profile id', print_r($profileId, ));
                $responsePaymentProfile = $this->authorizeNet->addPaymentProfileToCustomer($profileId, $details);

                // return $responsePaymentProfile->getMessages()->getResultCode();

                Log::info('responsePaymentProfile', json_decode(json_encode($responsePaymentProfile), true));
                if ($responsePaymentProfile && $responsePaymentProfile->getMessages()->getResultCode() === 'Ok') {
                    $paymentProfileIds = $response->getCustomerPaymentProfileIdList();
                    // Log::info('paymentProfileIds', print_r($paymentProfileIds));
                    Log::info('paymentProfileIds', json_decode(json_encode($paymentProfileIds), true));
                    foreach ($paymentProfileIds ?? [] as $paymentProfileId) {
                        $exists = CustomerPaymentProfile::where(['user_id' => $userId, 'customer_profile_id' => $profileId, 'payment_profile_id' => $paymentProfileId])->exists();
                        if (!$exists) {
                            CustomerPaymentProfile::create([
                                'user_id' => $userId,
                                'customer_profile_id' => $profileId,
                                'payment_profile_id' => $paymentProfileId,
                                'card_last_four' => substr($details['number'], -4),
                                'card_type' => $this->getCardType($request->number),
                                'is_default' => 0,
                            ]);
                        }
                    }
                    $paymentProfile = CustomerPaymentProfile::where(['user_id' => $userId, 'customer_profile_id' => $profileId, 'card_last_four' => $lastFourDigits])->first();
                    /** @var \net\authorize\api\contract\v1\CreateTransactionResponse $charge */
                    $charge = $this->authorizeNet->chargeSavedProfile($profileId, $paymentProfile->payment_profile_id, $amount);
                    if ($charge && $charge->getMessages()->getResultCode() === 'Ok') {
                        $transaction = $charge->getTransactionResponse();
                        if ($transaction && $transaction->getResponseCode() === '1') {
                            Payment::create([
                                'user_id' => Auth::id() ?? 33,
                                'order_id' => $orderId,
                                'amount' => $amount,
                                'currency' => 'USD',
                                'status' => 'successful',
                                'transaction_id' => $transaction->getTransId(),
                                'authorization_code' => $transaction->getAuthCode(),
                                'response_code' => $transaction->getResponseCode(),
                                'response_message' => optional($transaction->getMessages()[0])->getDescription() ?? 'Approved',
                                'customer_profile_id' => $profileId,
                                'payment_profile_id' => $paymentProfile->payment_profile_id,
                                'paid_at' => now(),
                            ]);
                        }
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $responsePaymentProfile->getMessages(),
                    ], 500);
                }
            }
        } else {
            $matchedProfile = $customerProfiles->firstWhere('card_last_four', $lastFourDigits);
            if ($matchedProfile) {
                /** @var \net\authorize\api\contract\v1\CreateTransactionResponse $charge */
                $charge = $this->authorizeNet->chargeSavedProfile($matchedProfile->customer_profile_id, $matchedProfile->payment_profile_id, $amount);
                if ($charge && $charge->getMessages()->getResultCode() === 'Ok') {
                    $transaction = $charge->getTransactionResponse();
                    if ($transaction && $transaction->getResponseCode() === '1') {
                        Payment::create([
                            'user_id' => $userId,
                            'order_id' => $orderId,
                            'amount' => $amount,
                            'currency' => 'USD',
                            'status' => 'successful',
                            'transaction_id' => $transaction->getTransId(),
                            'authorization_code' => $transaction->getAuthCode(),
                            'response_code' => $transaction->getResponseCode(),
                            'response_message' => optional($transaction->getMessages()[0])->getDescription() ?? 'Approved',
                            'customer_profile_id' => $matchedProfile->customer_profile_id,
                            'payment_profile_id' => $matchedProfile->payment_profile_id,
                            'paid_at' => now(),
                        ]);
                    }
                }
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Payment successful.'
        ], 200);
    }
}
