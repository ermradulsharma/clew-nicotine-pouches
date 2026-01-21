<?php

namespace App\Helpers;

use App\Models\CartTemp;
use App\Models\CouponTemp;
use App\Models\Label;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class Helper
{
    public static function getFeaturedImage($postId)
    {
        $thumbnailId = DB::table('wp_postmeta')->where('post_id', $postId)->where('meta_key', '_thumbnail_id')->value('meta_value');
        if (!$thumbnailId) {
            return null;
        }
        $image = DB::table('wp_posts')->where('ID', $thumbnailId)->where('post_type', 'attachment')->value('guid');
        return $image;
    }

    public static function getDesktopBanner($postId)
    {
        $bannerId = DB::table('wp_postmeta')->where('post_id', $postId)->where('meta_key', 'desktop_banner')->value('meta_value');
        if (!$bannerId) {
            return null;
        }
        $image = DB::table('wp_posts')->where('ID', $bannerId)->where('post_type', 'attachment')->value('guid');
        return $image;
    }

    public static function getMobileBanner($postId)
    {
        $bannerId = DB::table('wp_postmeta')->where('post_id', $postId)->where('meta_key', 'mobile_banner')->value('meta_value');
        if (!$bannerId) {
            return null;
        }
        $image = DB::table('wp_posts')->where('ID', $bannerId)->where('post_type', 'attachment')->value('guid');
        return $image;
    }

    public static function ageChecker($data)
    {
        $url = "https://api.agechecker.net/v1/create";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-AgeChecker-Secret: sample_secret5e9'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $response = curl_error($ch);
        }
        curl_close($ch);
        return $response;
    }

    public static function ageCheckerStatus($uuid)
    {
        $url = "https://api.agechecker.net/v1/status/{$uuid}";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-AgeChecker-Secret: qWWYIYnanacvUYgv'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return json_encode(['error' => curl_error($ch)]);
        }
        curl_close($ch);
        return $response;
    }

    public static function productMultiSlider($product_id, $variant_id, $variantSel)
    {
        $productImages = ProductImage::where('product_id', $product_id)->where('variant_id', $variant_id)->where('status', 1)->orderBy('position', 'asc')->get();
        return view('public.parts.productMultiSlider', ['product_id' => $product_id, 'variant_id' => $variant_id, 'variantSel' => $variantSel, 'productImages' => $productImages]);
    }

    public static function recently_products($product_id)
    {
        $recently_products = Cookie::get('recently_products');
        if ($recently_products) $recently_products = json_decode($recently_products, true);
        else $recently_products = [];
        if (!in_array($product_id, $recently_products)) array_push($recently_products, $product_id);
        $recently_products = json_encode($recently_products);
        Cookie::queue('recently_products', $recently_products, 120);
        return json_decode($recently_products, true);
    }

    public static function buyMoreQty($product_id, $variant_id, $qty)
    {
        if ($qty <= 4) {
            $discounts = self::discount($product_id, $variant_id, 5);
            $buyMoreQtyHtml = view('public.parts.buyMoreQty', ['qty' => 5 - $qty, 'save' => number_format($discounts["total_amount"] - $discounts["total_discount_amount"], 2)]);
        } elseif ($qty <= 9) {
            $discounts = self::discount($product_id, $variant_id, 10);
            $buyMoreQtyHtml = view('public.parts.buyMoreQty', ['qty' => 10 - $qty, 'save' => number_format($discounts["total_amount"] - $discounts["total_discount_amount"], 2)]);
        } elseif ($qty <= 14) {
            $discounts = self::discount($product_id, $variant_id, 15);
            $buyMoreQtyHtml = view('public.parts.buyMoreQty', ['qty' => 15 - $qty, 'save' => number_format($discounts["total_amount"] - $discounts["total_discount_amount"], 2)]);
        } else $buyMoreQtyHtml = '';

        return $buyMoreQtyHtml;
    }

    public static function couponCode()
    {
        $carts = CartTemp::where('session_id', session()->getId())->get();
        $couponData = CouponTemp::where('session_id', session()->getId())->orderBy('id', 'desc')->first();
        return view('public.parts.couponCode', ['carts' => $carts, 'couponDiscount' => '0.00', 'couponData' => $couponData]);
    }

    public static function couponDiscount()
    {
        $couponDiscount = 0;
        $couponData = CouponTemp::where('session_id', session()->getId())->orderBy('id', 'desc')->first();
        if ($couponData) {
            $total_discount_amount = CartTemp::where('session_id', session()->getId())->sum('total_discount_amount');
            if ($couponData->products) {
                $total_discount_amount = CartTemp::where('session_id', session()->getId())->whereIn('product_id', json_decode($couponData->products, true))->sum('total_discount_amount');
            }
            $couponDiscount = ($couponData->discount_type == 'percentage') ? (($total_discount_amount * $couponData->discount) / 100) : $total_discount_amount - $couponData->discount;
            return number_format($couponDiscount, 2);
        } else return number_format($couponDiscount, 2);
    }

    public static function couponCodeCheck()
    {
        $carts = CartTemp::where('session_id', session()->getId())->count();
        if ($carts) {
            $couponData = CouponTemp::where('session_id', session()->getId())->orderBy('id', 'desc')->first();
            if ($couponData) {
                if ($couponData->products) {
                    $productsCoupon = CartTemp::where('session_id', session()->getId())->whereIn('product_id', json_decode($couponData->products, true))->count();
                    if (!$productsCoupon) CouponTemp::where('session_id', session()->getId())->delete();
                }
            }
        } else CouponTemp::where('session_id', session()->getId())->delete();
    }

    public static function session_update($old_session_id)
    {
        CartTemp::where('session_id', $old_session_id)->update(['session_id' => session()->getId(), 'user_id' => auth()->user()->id]);
        CouponTemp::where('session_id', $old_session_id)->update(['session_id' => session()->getId()]);
    }

    public static function discount($product_id, $variant_id, $qty)
    {
        $product = Product::find($product_id);
        $variant = ProductVariant::where('product_id', $product_id)->where('id', $variant_id)->where('status', 1)->first();

        $variant_price = $variant->mrp;
        $variant_discount_price = $variant->price;
        $total_amount = number_format($variant->price * $qty, 2);
        $total_discount_amount = self::discountCalculate($variant->price, $qty, $product->base_discount, $product->incremental_discount, $product->max_discount);

        // if($product->base_discount>0)
        // {
        //     $total_discount_amount = $variant_price-(($variant_price/100)*$product->base_discount);
        //     $variant_discount_price = $total_discount_amount;

        //     if($product->incremental_discount>0 && $qty>1)
        //     {
        //         $total_discount = $product->base_discount + (($product->incremental_discount*($qty-1)));
        //         if($product->max_discount>0)
        //         {
        //             if($product->max_discount<$total_discount)
        //                 $total_discount_amount = $total_amount-(($total_amount/100)*$product->max_discount);
        //             else
        //                 $total_discount_amount = $total_amount-(($total_amount/100)*$total_discount);
        //         }
        //         else
        //             $total_discount_amount = $total_amount-(($total_amount/100)*$total_discount);
        //     }
        // }
        // else
        // {
        //     $total_discount_amount = 0;
        //     $variant_discount_price = 0;
        // }

        return ['variant_price' => $variant_price, 'variant_discount_price' => $variant_discount_price, 'total_amount' => $total_amount, 'total_discount_amount' => $total_discount_amount];
    }

    public static function discountCalculate($unitPrice, $qty, $baseDiscount, $incrementalDiscount, $maxDiscount)
    {
        $discount = self::calculateDiscount($qty, $baseDiscount, $incrementalDiscount, $maxDiscount) / 100;
        $originalPrice = $unitPrice * $qty;
        $finalPrice = $originalPrice * (1 - $discount);
        return number_format($finalPrice, 2);
    }

    public static function calculateDiscount($quantity, $baseDiscount, $incrementalDiscount, $maxDiscount)
    {
        $discountLevels = [5 => $baseDiscount, 10 => $baseDiscount + $incrementalDiscount, 15 => $baseDiscount + (2 * $incrementalDiscount)];
        foreach ($discountLevels as $level => $discount) {
            if ($quantity >= $level) $applicableDiscount = min($discount, $maxDiscount);
        }
        return $applicableDiscount ?? 0;
    }

    public static function isFeatured($product_id)
    {
        $products = Product::where('id', $product_id)->where('featured', 1)->first();
        if ($products) return true;
        else return false;
    }

    public static function label($product_id)
    {
        $product = Product::find($product_id);
        if ($product->label_id) {
            $label = Label::where('id', $product->label_id)->where('status', 1)->first();
            if ($label) return '<span class="bseller">' . $label->title . '</span>';
        }
    }

    public static function wishlistIcon($product_id)
    {
        return view('public.parts.wishlistIcon', ['product_id' => $product_id]);
    }

    public static function isWishlist($product_id)
    {
        if (Auth()->check()) {
            $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('product_id', $product_id)->first();
            if ($wishlist) return true;
            else return false;
        } else return false;
    }

    public static function page($slug)
    {
        $page = Page::where('slug', $slug)->first();
        if ($page) return $page;
        else return false;
    }

    public static function buyPackDeal()
    {
        $product = Product::where('showOnCart', 1)->where('status', 1)->first();
        if ($product) return view('public.parts.buyPackDeal', ['product' => $product]);
        else {
            $product = Product::where('status', 1)->orderBy('position', 'asc')->first();
            return view('public.parts.buyPackDeal', ['product' => $product]);
        }
    }
}
