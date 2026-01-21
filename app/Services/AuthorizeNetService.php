<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use net\authorize\api\constants\ANetEnvironment;

class AuthorizeNetService
{
    protected function auth(): AnetAPI\MerchantAuthenticationType
    {
        $auth = new AnetAPI\MerchantAuthenticationType();
        $auth->setName(config('services.authorizenet.login_id'));
        $auth->setTransactionKey(config('services.authorizenet.transaction_key'));
        return $auth;
    }

    protected function environment(): string
    {
        return config('services.authorizenet.env') === 'sandbox' ? ANetEnvironment::SANDBOX : ANetEnvironment::PRODUCTION;
    }

    /**
     * Create a new customer profile with an initial payment profile.
     */
    public function createCustomerProfile(array $data)
    {
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($data['number']);
        $creditCard->setExpirationDate($data['expiry']);
        $creditCard->setCardCode($data['cvc']);

        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);

        $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $paymentProfile->setCustomerType('individual');
        $paymentProfile->setPayment($payment);

        $profile = new AnetAPI\CustomerProfileType();
        $profile->setDescription("Profile for " . $data['email']);
        $profile->setEmail($data['email']);
        $profile->setPaymentProfiles([$paymentProfile]);

        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($this->auth());
        $request->setProfile($profile);
        $request->setClientId(null);
        $request->setValidationMode("testMode");
        $reflection = new \ReflectionClass($request);
        if ($reflection->hasProperty('clientId')) {
            $prop = $reflection->getProperty('clientId');
            $prop->setAccessible(true);
            $prop->setValue($request, null);
        }
        $controller = new AnetController\CreateCustomerProfileController($request);
        /** @var \net\authorize\api\contract\v1\CreateCustomerProfileResponse $response */
        $response = $controller->executeWithApiResponse($this->environment());
        if ($response !== null && $response->getMessages()->getResultCode() == "Ok") {
            return $response->getCustomerProfileId();
        } else {
            $messages = $response->getMessages()->getMessage();
            if ($messages[0]->getCode() == "E00039") {
                preg_match('/ID (\d+)/', $messages[0]->getText(), $matches);
                if (isset($matches[1])) {
                    return $matches[1];
                }
            }
        }
    }

    /**
     * Add a new payment method (card) to an existing customer profile.
     * 
     * @return string|null The payment profile ID or null on failure.
     */
    public function addPaymentProfileToCustomer($customerProfileId, array $cardData)
    {
        $request = new AnetAPI\GetCustomerProfileRequest();
        $request->setMerchantAuthentication($this->auth());
        $request->setCustomerProfileId($customerProfileId);
        $lastFour = substr($cardData['number'], -4);
        $controller = new AnetController\GetCustomerProfileController($request);
        /** @var GetCustomerProfileResponse $response */
        $response = $controller->executeWithApiResponse($this->environment());
        if ($response !== null && $response->getMessages()->getResultCode() === 'Ok') {
            $profile = $response->getProfile();
            if ($profile) {
                $paymentProfiles = $profile->getPaymentProfiles();

                foreach ($paymentProfiles as $profileItem) {
                    $card = $profileItem->getPayment()->getCreditCard();
                    if ($card) {
                        $cardNumber = $card->getCardNumber();
                        if ($lastFour === null || substr($cardNumber, -4) === $lastFour) {
                            return $profileItem->getCustomerPaymentProfileId();
                        }
                    }
                }
            }
        }

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardData['number']);
        $creditCard->setExpirationDate($cardData['expiry']);
        $creditCard->setCardCode($cardData['cvc']);

        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);

        $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $paymentProfile->setCustomerType('individual');
        $paymentProfile->setPayment($payment);

        $request = new AnetAPI\CreateCustomerPaymentProfileRequest();
        $request->setMerchantAuthentication($this->auth());
        $request->setCustomerProfileId($customerProfileId);
        $request->setPaymentProfile($paymentProfile);
        $request->setValidationMode("testMode");

        /** @var \net\authorize\api\contract\v1\CreateCustomerPaymentProfileResponse $createResponse */
        $controller = new AnetController\CreateCustomerPaymentProfileController($request);
        $createResponse =  $controller->executeWithApiResponse($this->environment());

        if ($createResponse !== null && $createResponse->getMessages()->getResultCode() === "Ok") {
            if (method_exists($createResponse, 'getCustomerPaymentProfileId')) {
                return $createResponse->getCustomerPaymentProfileId();
            }

            // Fallback for some SDK versions or unexpected response structures
            return $this->getPaymentProfileIdIfExists($customerProfileId, substr($cardData['number'], -4));
        } else {
            $msg = $createResponse ? $createResponse->getMessages()->getMessage()[0]->getText() : "Null response";
            throw new Exception("Failed to create payment profile: " . $msg);
        }
    }

    /**
     * Charge a customer using a saved payment profile.
     * 
     * @return \net\authorize\api\contract\v1\CreateTransactionResponse|null
     */
    public function chargeSavedProfile($customerProfileId, $paymentProfileId, $amount)
    {
        $profileToCharge = new AnetAPI\CustomerProfilePaymentType();
        $profileToCharge->setCustomerProfileId($customerProfileId);
        $profileToCharge->setPaymentProfile(
            (new AnetAPI\PaymentProfileType())->setPaymentProfileId($paymentProfileId)
        );

        $transactionRequest = new AnetAPI\TransactionRequestType();
        $transactionRequest->setTransactionType("authCaptureTransaction");
        $transactionRequest->setAmount($amount);
        $transactionRequest->setProfile($profileToCharge);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($this->auth());
        $request->setTransactionRequest($transactionRequest);

        $controller = new AnetController\CreateTransactionController($request);
        return $controller->executeWithApiResponse($this->environment());
    }

    /**
     * Refund a previous transaction.
     * Note: card number only needs last 4 digits.
     */
    public function refundTransaction($transactionId, $amount, $cardLastFour)
    {
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardLastFour);
        $creditCard->setExpirationDate("XXXX");

        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);

        $transactionRequest = new AnetAPI\TransactionRequestType();
        $transactionRequest->setTransactionType("refundTransaction");
        $transactionRequest->setRefTransId($transactionId);
        $transactionRequest->setAmount($amount);
        $transactionRequest->setPayment($payment);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($this->auth());
        $request->setTransactionRequest($transactionRequest);

        $controller = new AnetController\CreateTransactionController($request);
        return $controller->executeWithApiResponse($this->environment());
    }

    /**
     * Void a transaction before settlement.
     */
    public function voidTransaction($transactionId)
    {
        $transactionRequest = new AnetAPI\TransactionRequestType();
        $transactionRequest->setTransactionType("voidTransaction");
        $transactionRequest->setRefTransId($transactionId);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($this->auth());
        $request->setTransactionRequest($transactionRequest);

        $controller = new AnetController\CreateTransactionController($request);
        return $controller->executeWithApiResponse($this->environment());
    }

    /**
     * Get details for a specific transaction.
     */
    public function getTransactionDetails($transactionId)
    {
        $request = new AnetAPI\GetTransactionDetailsRequest();
        $request->setMerchantAuthentication($this->auth());
        $request->setTransId($transactionId);

        $controller = new AnetController\GetTransactionDetailsController($request);
        return $controller->executeWithApiResponse($this->environment());
    }

    /**
     * Delete an entire customer profile and all payment profiles.
     */
    public function deleteCustomerProfile($customerProfileId)
    {
        $request = new AnetAPI\DeleteCustomerProfileRequest();
        $request->setMerchantAuthentication($this->auth());
        $request->setCustomerProfileId($customerProfileId);

        $controller = new AnetController\DeleteCustomerProfileController($request);
        return $controller->executeWithApiResponse($this->environment());
    }

    /**
     * Delete a specific saved card for a customer.
     */
    public function deletePaymentProfile($customerProfileId, $paymentProfileId)
    {
        $request = new AnetAPI\DeleteCustomerPaymentProfileRequest();
        $request->setMerchantAuthentication($this->auth());
        $request->setCustomerProfileId($customerProfileId);
        $request->setCustomerPaymentProfileId($paymentProfileId);

        $controller = new AnetController\DeleteCustomerPaymentProfileController($request);
        return $controller->executeWithApiResponse($this->environment());
    }

    public function getCustomerProfile($customerProfileId)
    {
        $request = new AnetAPI\GetCustomerProfileRequest();
        $request->setMerchantAuthentication($this->auth());
        $request->setCustomerProfileId($customerProfileId);

        $controller = new AnetController\GetCustomerProfileController($request);
        return $controller->executeWithApiResponse($this->environment());
    }

    public function getPaymentProfileIdIfExists($customerProfileId, $lastFour = null)
    {
        $request = new AnetAPI\GetCustomerProfileRequest();
        $request->setMerchantAuthentication($this->auth());
        $request->setCustomerProfileId($customerProfileId);

        $controller = new AnetController\GetCustomerProfileController($request);
        /** @var GetCustomerProfileResponse $response */
        $response = $controller->executeWithApiResponse($this->environment());
        if ($response !== null && $response->getMessages()->getResultCode() === 'Ok') {
            $profile = $response->getProfile();
            if ($profile) {
                $paymentProfiles = $profile->getPaymentProfiles();

                foreach ($paymentProfiles as $profileItem) {
                    $card = $profileItem->getPayment()->getCreditCard();
                    if ($card) {
                        $cardNumber = $card->getCardNumber();
                        if ($lastFour === null || substr($cardNumber, -4) === $lastFour) {
                            return $profileItem->getCustomerPaymentProfileId();
                        }
                    }
                }
            }

            return null;
        } else {
            throw new Exception("Failed to retrieve customer profile: " . $response->getMessages()->getMessage()[0]->getText());
        }
    }
}
