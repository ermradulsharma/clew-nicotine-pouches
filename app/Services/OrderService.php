<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Cart;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function createOrder($checkout, $carts, $couponData, $sessionId)
    {
        $couponDiscount = Helper::couponDiscount();
        $grandTotal = number_format($carts->sum('total_discount_amount') + $checkout->shipping_price + $checkout->tax - $couponDiscount, 2);

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
        $order->grand_total = $grandTotal;
        $order->order_status = 'New';
        $order->payment_status = 'Pending';
        $order->payment_mode = 'Online';

        if ($order->save()) {
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
            return $order;
        }

        return null;
    }
}
