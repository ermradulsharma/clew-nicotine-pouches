<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class SalesforceService
{
    private $accessToken;
    private $instanceUrl;
    private $client;
    private $config;

    public function __construct(array $config)
    {
        $this->client = new Client();
        $this->config = $config;
        $this->authenticate();
    }

    private function authenticate()
    {
        try {
            $response = $this->client->post($this->config['login_url'] . '/services/oauth2/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $this->config['client_id'],
                    'client_secret' => $this->config['client_secret'],
                    'username' => $this->config['username'],
                    'password' => $this->config['password'],
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            if (!isset($data['access_token'])) {
                throw new \Exception('Salesforce authentication failed: ' . json_encode($data));
            }
            $this->accessToken = $data['access_token'];
            $this->instanceUrl = $data['instance_url'];
        } catch (Exception $e) {
            Log::error('Salesforce Authentication Exception: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getInstanceUrl()
    {
        return $this->instanceUrl;
    }

    public function sendObject(string $objectType, array $data)
    {
        try {
            Log::info("Salesforce API Request: Creating {$objectType}", $data);
            $response = $this->client->post("{$this->instanceUrl}/services/data/v45.0/sobjects/{$objectType}/", [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Content-Type'  => 'application/json',
                ],
                'json' => $data,
            ]);
            $responseData = json_decode($response->getBody(), true);
            return $responseData;
        } catch (Exception $e) {
            Log::error("Salesforce API Error creating {$objectType}: " . $e->getMessage(), [
                'payload' => $data,
            ]);
            throw $e;
        }
    }

    public function sendPersonAccountData(array $data)
    {
        if (!$this->accessToken || !$this->instanceUrl) {
            throw new Exception('Not authenticated.');
        }
        try {
            $url = "{$this->instanceUrl}/services/data/v45.0/sobjects/Account/";
            $response = $this->client->post($url, [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Content-Type'  => 'application/json',
                ],
                'json' => $data,
            ]);
            $responseData = json_decode($response->getBody(), true);
            return $responseData;
        } catch (Exception $e) {
            Log::error("Failed to create PersonAccount: " . $e->getMessage());
            throw $e;
        }
    }

    public function createContact(array $data)
    {
        $existingAccountId = $this->findAccountByNameAndPhone($data['Name'], $data['Phone']);
        if ($existingAccountId) {
            return ['id' => $existingAccountId];
        }
        return $this->sendObject('Account', $data);
    }

    public function createOrder(array $data)
    {
        return $this->sendObject('Order', $data);
    }

    public function createOrderItem(array $data)
    {
        return $this->sendObject('OrderItem', $data);
    }
    public function findPricebookEntryIdByProductName($productName)
    {
        $query = "SELECT Id FROM PricebookEntry WHERE Product2.Name = '$productName' AND Pricebook2.IsStandard = true LIMIT 1";
        return $this->query($query)['records'][0] ?? null;
    }

    public function query(string $soql)
    {
        $url = "{$this->instanceUrl}/services/data/v45.0/query?q=" . urlencode($soql);
        try {
            $response = $this->client->get($url, [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Content-Type'  => 'application/json',
                ],
            ]);
            $statusCode = $response->getStatusCode();
            $body = json_decode((string) $response->getBody(), true);
            if ($statusCode >= 200 && $statusCode < 300) {
                return $body;
            }
            throw new \Exception("Salesforce query failed: " . json_encode($body));
        } catch (\Exception $e) {
            throw new \Exception("Salesforce query error: " . $e->getMessage());
        }
    }

    public function findAccountByNameAndPhone(string $name, string $phone)
    {
        $soql = "SELECT Id FROM Account WHERE Name = '$name' AND Phone = '$phone' LIMIT 1";
        $result = $this->query($soql);
        return $result['records'][0]['Id'] ?? null;
    }

    public function getOrCreatePricebookEntryId($productName, $unitPrice)
    {
        $entryId = $this->findPricebookEntryIdByProductName($productName);
        if ($entryId) {
            return $entryId;
        }
        $productId = $this->findOrCreateProduct($productName);
        $pricebookId = $this->getStandardPricebookId();

        return $this->createPricebookEntry($productId, $pricebookId, $unitPrice);
    }

    public function createPricebookEntry($productId, $pricebookId, $unitPrice)
    {
        $entry = $this->sendObject('PricebookEntry', [
            'Product2Id' => $productId,
            'Pricebook2Id' => $pricebookId,
            'UnitPrice' => $unitPrice,
            'IsActive' => true,
        ]);
        return $entry['id'] ?? null;
    }
    public function getStandardPricebookId()
    {
        $query = "SELECT Id FROM Pricebook2 WHERE IsStandard = true LIMIT 1";
        $result = $this->query($query);
        return $result['records'][0]['Id'] ?? null;
    }

    public function findOrCreateProduct($productName)
    {
        $query = "SELECT Id FROM Product2 WHERE Name = '$productName' LIMIT 1";
        $result = $this->query($query);
        if (!empty($result['records'])) {
            return $result['records'][0]['Id'];
        }
        $product = $this->sendObject('Product2', [
            'Name' => $productName,
            'IsActive' => true
        ]);

        return $product['id'] ?? null;
    }
}
