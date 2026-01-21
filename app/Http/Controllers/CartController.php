<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;

use Session;
use App\Models\Cart;
use App\Models\CartTemp;
use App\Models\Coupon;
use App\Models\CouponTemp;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $similar_products = [];
        $carts = CartTemp::where('session_id', session()->getId())->get();
        if ($carts) {
            $product_ids = $carts->pluck('product_id')->toArray();
            $similar_products_ids = \App\Models\ProductSimilar::whereIn('product_id', $product_ids)->where('status', 1)->orderBy('position', 'asc')->pluck("similar_id")->toArray();
            $similar_products = \App\Models\Product::whereIn('id', $similar_products_ids)->where('status', 1)->get();
        }

        $couponData = CouponTemp::where('session_id', session()->getId())->orderBy('id', 'desc')->first();
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Products', 'url' => route('products')],
            ['label' => 'Cart'],
        ];
        return view('public.cart', ['similar_products' => $similar_products, 'carts' => $carts, 'couponData' => $couponData, 'couponDiscount' => '0.00', 'breadcrumbs' => $breadcrumbs]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'variant' => 'required|numeric',
            'qty' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'error', 'msg' => 'Product can not be found']);
        } else {
            $variant_id = $request->variant;
            $product = Product::find($request->product_id);
            $productVariant = ProductVariant::find($request->variant);
            if ($product) {
                $cartTemp = CartTemp::where('session_id', session()->getId())->where('product_id', $product->id)->where('variant_id', $productVariant->id)->first();
                if ($cartTemp) {
                    if ($cartTemp->qty + $request->qty > 100) return response()->json(['res' => 'error', 'msg' => 'You can buy max 100 quantities.']);
                    $qty = $cartTemp->qty + $request->qty;
                    $total_price = $productVariant->price * $qty;
                    $discounts = Helper::discount($product->id, $productVariant->id, $qty);
                } else {
                    $qty = $request->qty;
                    $total_price = $productVariant->price * $qty;
                    $discounts = Helper::discount($product->id, $productVariant->id, $qty);
                    $cartTemp = new CartTemp;
                }
                $cartTemp->session_id = session()->getId();
                $cartTemp->user_id = (Auth::check()) ? auth()->user()->id : null;
                $cartTemp->category_id = $product->category_id;
                $cartTemp->category_name = $product->category->title;
                $cartTemp->product_id = $product->id;
                $cartTemp->product_name = $product->title;
                $cartTemp->product_image = $productVariant->thumb;
                $cartTemp->sku_code = $product->sku_code;
                $cartTemp->variant_id = $productVariant->id;
                $cartTemp->variant_name = $productVariant->strength->title;
                $cartTemp->variant_qty = $productVariant->qty;
                $cartTemp->unit_mrp = $productVariant->mrp;
                $cartTemp->unit_price = $productVariant->price;
                $cartTemp->qty = $qty;
                $cartTemp->base_discount = $product->base_discount;
                $cartTemp->incremental_discount = $product->incremental_discount;
                $cartTemp->max_discount = $product->max_discount;
                $cartTemp->total_discount_amount = ($discounts['total_discount_amount']) ? $discounts['total_discount_amount'] : $discounts['total_amount'];
                $cartTemp->total_price = $discounts['total_amount'];
                if ($cartTemp->save()) {
                    $items = CartTemp::where('session_id', session()->getId())->count();
                    $itemHtml = ($items) ? '<span>' . $items . '</span>' : '';
                    $qtyBoxHtml = view('public.parts.qtySection', ['cart' => $cartTemp])->render();
                    return response()->json(['res' => 'success', 'msg' => 'Item added to cart successfully.', 'items' => $itemHtml, 'qtyBox' => $qtyBoxHtml]);
                } else
                    return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function couponCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'couponCode' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'error', 'msg' => 'Please enter Coupon code']);
        } else {
            $couponData = Coupon::where('code', base64_encode($request->couponCode))->where('status', 1)->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->whereColumn('units', '>', 'used')->first();
            if ($couponData) {
                $couponApplied = CouponTemp::where('session_id', session()->getId())->where('coupon_code', $request->couponCode)->first();
                if ($couponApplied) {
                    if ($couponApplied->delete())
                        return response()->json(['res' => 'success', 'msg' => 'Coupon code removed successfully.']);
                    else
                        return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
                } else {
                    if ($couponData->usage_limit == 1) {
                        if (Auth()->check()) {
                            $order = Order::where('user_id', Auth()->user()->id)->where('coupon_code', $request->couponCode)->where('payment_status', 'Paid')->first();
                            if ($order) return response()->json(['res' => 'error', 'msg' => 'Coupon code already used.']);
                        } else
                            return response()->json(['res' => 'error', 'msg' => 'Login to apply this Coupon code.']);
                    }
                    if ($couponData->products) {
                        $productsCoupon = \App\Models\CartTemp::where('session_id', session()->getId())->whereIn('product_id', json_decode($couponData->products, true))->count();
                        if (!$productsCoupon) return response()->json(['res' => 'error', 'msg' => 'Coupon code can be applied to selected products.']);
                    }

                    $couponTemp = new CouponTemp;
                    $couponTemp->session_id = session()->getId();
                    $couponTemp->coupon_id = $couponData->id;
                    $couponTemp->coupon_code = $request->couponCode;
                    $couponTemp->discount_type = $couponData->discount_type;
                    $couponTemp->discount = $couponData->discount;
                    $couponTemp->products = $couponData->products;
                    if ($couponTemp->save())
                        return response()->json(['res' => 'success', 'msg' => 'Coupon code applied successfully.']);
                    else
                        return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
                }
            } else
                return response()->json(['res' => 'error', 'msg' => 'Invalid/Used coupon code.']);
        }
    }

    public function emptyCart(Request $request)
    {
        CartTemp::where('session_id', session()->getId())->delete();
        CouponTemp::where('session_id', session()->getId())->delete();
        return response()->json(['res' => 'success', 'msg' => 'Cart cleared successfully.', 'items' => '']);
    }

    public function itemDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails())
            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        else {
            $cartTemp = CartTemp::where('id', $request->id)->where('session_id', session()->getId())->first();
            if ($cartTemp->delete()) {
                $items = CartTemp::where('session_id', session()->getId())->get()->count();
                $itemHtml = ($items) ? '<span>' . $items . '</span>' : '';
                Helper::couponCodeCheck();
                return response()->json(['res' => 'success', 'msg' => 'Item removed from cart successfully.', 'items' => $itemHtml]);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function itemIncrease(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails())
            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        else {
            $cartData = CartTemp::where('id', $request->id)->where('session_id', session()->getId())->first();
            if ($cartData) {
                if ($cartData->qty >= 100) return response()->json(['res' => 'error', 'msg' => 'You can buy max 10 quantities.']);

                if ($cartData->product) {
                    $qty = $cartData->qty + 1;

                    $discounts = Helper::discount($cartData->product_id, $cartData->variant_id, $qty);
                    $cartTemp = CartTemp::find($cartData->id);
                    $cartTemp->qty = $qty;
                    $cartTemp->total_discount_amount = ($discounts['total_discount_amount']) ? $discounts['total_discount_amount'] : $discounts['total_amount'];
                    $cartTemp->total_price = $discounts['total_amount'];
                    if ($cartTemp->save())
                        return response()->json(['res' => 'success', 'msg' => 'Item quantity updated successfully.', 'qty' => $qty]);
                    else
                        return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
                } else
                    return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function itemDecrease(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails())
            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        else {
            $cartData = CartTemp::where('id', $request->id)->where('session_id', session()->getId())->first();
            if ($cartData) {
                if ($cartData->product) {
                    $qty = $cartData->qty - 1;
                    $discounts = Helper::discount($cartData->product_id, $cartData->variant_id, $qty);
                    if ($qty) {
                        $cartTemp = CartTemp::find($cartData->id);
                        $cartTemp->qty = $qty;
                        $cartTemp->total_discount_amount = ($discounts['total_discount_amount']) ? $discounts['total_discount_amount'] : $discounts['total_amount'];
                        $cartTemp->total_price = $discounts['total_amount'];
                        if ($cartTemp->save())
                            return response()->json(['res' => 'success', 'msg' => 'Item quantity updated successfully.', 'qty' => $qty]);
                        else
                            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
                    } else
                        return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
                } else
                    return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function reloadCart()
    {
        $carts = CartTemp::where('session_id', session()->getId())->get();
        $couponData = CouponTemp::where('session_id', session()->getId())->orderBy('id', 'desc')->first();
        return view('public.parts.cartSection', ['carts' => $carts, 'couponData' => $couponData, 'couponDiscount' => '0.00']);
    }
}
