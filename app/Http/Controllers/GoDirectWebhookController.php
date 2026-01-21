<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class GoDirectWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::channel('godirect')->info('Initial Payload', $request->all());
        if ($request->isMethod('get')) {
            return response()->json(['message' => 'GET method not allowed'], Response::HTTP_METHOD_NOT_ALLOWED);
        }
        if (str_contains($request->header('Content-Type'), 'xml')) {
            try {
                $xml = simplexml_load_string($request->getContent(), "SimpleXMLElement", LIBXML_NOCDATA);
                if (!$xml) {
                    throw new \Exception("Failed to parse XML");
                }
                $json = json_encode($xml);
                $array = json_decode($json, true);
                $request->replace($array);
            } catch (\Exception $e) {
                Log::channel('godirect')->error("Invalid XML payload", ['error' => $e->getMessage()]);
                return response()->json(['message' => 'Invalid XML format'], Response::HTTP_BAD_REQUEST);
            }
        }
        Log::channel('godirect')->info('Normalized Payload', $request->all());
        $notifications = $request->input('Notifications');
        if (!is_array($notifications)) {
            return response()->json(['message' => 'Invalid or missing Notifications array'], Response::HTTP_BAD_REQUEST);
        }
        $lastMessage = null;
        foreach ($notifications as $notification) {
            $action = $notification['Action'] ?? null;
            $wmsOrder = $notification['WMSOrder'] ?? null;
            if (!$action || !$wmsOrder) {
                Log::channel('godirect')->warning("Missing Action or WMSOrder", compact('notification'));
                continue;
            }
            $message = $this->processNotification($action, $wmsOrder);
            if ($message) {
                $lastMessage = $message;
            }
        }
        return response()->json(['message' => $lastMessage ?? 'Webhook processed', 'status' => Response::HTTP_OK], Response::HTTP_OK);
    }

    protected function processNotification(string $action, array $wmsOrder): ?string
    {
        $customerPoNo = $wmsOrder['CustomerPoNo'] ?? null;
        if (!$customerPoNo || !str_starts_with($customerPoNo, 'ORDER')) {
            Log::channel('godirect')->warning("Invalid or missing CustomerPoNo", compact('wmsOrder'));
            return 'Invalid CustomerPoNo';
        }
        $orderId = str_replace('ORDER', '', $customerPoNo);
        $order = Order::find($orderId);
        Log::channel('godirect')->info("Order Details", compact('order'));
        if (!$order) {
            Log::channel('godirect')->warning("Order not found for ID {$orderId}");
            return "Order not found for ID {$orderId}";
        }
        $status = $wmsOrder['OrderStatus'] ?? 'UNKNOWN';
        switch ($action) {
            case 'GD_ShipmentV2':
            case 'GD_ShipmentDeliveryDateV2':
                $order->order_status = $status;
                $order->save();
                Log::channel('godirect')->info("Order ID {$order->id} updated to status: {$order->order_status}");
                return "Order ID {$order->id} status updated to {$order->order_status}";
            default:
                Log::channel('godirect')->warning("Unhandled event type: {$action}");
                return null;
        }
    }
}
