<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Log;

class GoDirectService
{
    public function sendOrderToGoDirect(Order $order)
    {
        Log::channel('godirect')->info('Starting SOAP order creation');

        $url = config('app.godirect_url');
        $action = config('app.godirect_action');
        $userName = config('app.godirect_username');
        $password = htmlspecialchars(config('app.godirect_password'), ENT_XML1);

        $order = Order::with('cartProduct')->find($order->id);
        $country = Country::where(['title' => $order->billing_country])->first();
        $state = State::where(['country_id' => $country->id, 'title' => $order->billing_state])->first();
        $stateCode = $state->code ?? '';

        $xml = $this->buildSoapXml($order, $country, $stateCode, $action, $url, $userName, $password);

        return $this->executeSoapRequest($url, $xml);
    }

    protected function buildSoapXml($order, $country, $stateCode, $action, $url, $userName, $password)
    {
        $paidAt = now()->toIso8601String();

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
        foreach ($order->cartProduct as $item) {
            $weight = floatval(preg_replace('/[^\d.]/', '', $item->variant_name));
            $totalPrice = number_format((float) $item->total_price, 2);
            $unitPrice = number_format((float) $item->unit_price, 2);
            $skuCode = $item->sku_code . '-' . strtoupper($item->variant_name);

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
        return $xml;
    }

    protected function executeSoapRequest($url, $xml)
    {
        $maxAttempts = 3;
        $attempt = 0;
        $success = false;
        $response = '';

        while (!$success && $attempt < $maxAttempts) {
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
                Log::channel('godirect')->info('SOAP Response success');
            }
            curl_close($ch);
        }

        if (!$success) {
            Log::error('SOAP Request Failed after retries.');
        }

        return $success;
    }
}
