<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Flavour;
use App\Models\Label;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\ProductSimilar;
use App\Models\ProductVariant;
use App\Models\Strength;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
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
        $flavours = Flavour::where('status', 1)->orderBy('position', 'asc')->get();
        $strengths = Strength::where('status', 1)->orderBy('position', 'asc')->get();
        $labels = Label::where('status', 1)->orderBy('position', 'asc')->get();
        $products = Product::where('status', 1)->orderBy('position', 'asc')->get();
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Products']
        ];
        return view('public.products', ['flavours' => $flavours, 'strengths' => $strengths, 'labels' => $labels, 'products' => $products, 'breadcrumbs' => $breadcrumbs]);
    }

    public function searchSuggestions(Request $request)
    {
        $searchResultHtml = "<div>Sorry, no matches were found.</div>";
        if ($request->filled('searchQuery')) {
            $products = (new Product)->newQuery();
            $searchKey = $request->searchQuery;

            $products->where(function ($query) use ($searchKey) {
                $query->where('title', 'LIKE', '%' . $searchKey . '%')->orWhere('tagline', 'LIKE', '%' . $searchKey . '%')->orWhere('sku_code', 'LIKE', '%' . $searchKey . '%')->orWhere('short_description', 'LIKE', '%' . $searchKey . '%')->orWhere('description', 'LIKE', '%' . $searchKey . '%')->orWhere('pageTitle', 'LIKE', '%' . $searchKey . '%')->orWhere('pageDescription', 'LIKE', '%' . $searchKey . '%')->orWhere('pageKeywords', 'LIKE', '%' . $searchKey . '%');
            });

            $products = $products->orderBy('title', 'asc')->get();
            if ($products->count())
                return view('public.parts.searchSuggestions', ['products' => $products]);
            else
                return $searchResultHtml;
        }
        return $searchResultHtml;
    }

    public function searchResults($searchKey)
    {
        $products = [];
        if ($searchKey) {
            $products = (new Product)->newQuery();
            $products->where(function ($query) use ($searchKey) {
                $query->where('title', 'LIKE', '%' . $searchKey . '%')->orWhere('tagline', 'LIKE', '%' . $searchKey . '%')->orWhere('sku_code', 'LIKE', '%' . $searchKey . '%')->orWhere('short_description', 'LIKE', '%' . $searchKey . '%')->orWhere('description', 'LIKE', '%' . $searchKey . '%')->orWhere('pageTitle', 'LIKE', '%' . $searchKey . '%')->orWhere('pageDescription', 'LIKE', '%' . $searchKey . '%')->orWhere('pageKeywords', 'LIKE', '%' . $searchKey . '%');
            });

            $products = $products->orderBy('title', 'asc')->get();
            return view('public.search', ['searchKey' => $searchKey, 'products' => $products]);
        } else
            return view('public.search', ['searchKey' => $searchKey, 'products' => $products]);
    }

    public function productFilter(Request $request)
    {
        $products = Product::with('variants')->where('status', 1);
        if ($request->filled('flavours'))
            $products->whereIn('flavour_id', $request->flavours);
        if ($request->filled('strengths')) {
            $strengths = $request->strengths;
            $products->whereHas('Variants', function ($query) use ($strengths) {
                $query->whereIn('strength_id', $strengths);
            });
        }

        switch ($request->sort_by) {
            case 'most_popular':
                $products->orderBy('position', 'asc');
                break;
            case 'newest':
                $products->orderBy('id', 'desc');
                break;
            case 'discounted':
                $products->orderBy('base_discount', 'desc');
                break;
            case 'price_low_high':
                $products->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $products->orderBy('price', 'desc');
                break;
            default:
                $products->orderBy('id', 'asc');
        }

        $productCount =  $products->count() . " Items";
        $productHtml = view('public.parts.productBox', ['products' => $products->get()])->render();
        return response()->json(['res' => 'success', 'productCount' => $productCount, 'productHtml' => $productHtml]);
    }

    public function detail($slug)
    {
        $product = Product::where('slug', $slug)->where('status', 1)->first();
        $productVariants = $product->variants()->where('status', 1)->orderBy('position', 'asc')->get();
        $productImages = $product->images()->where('status', 1)->orderBy('position', 'asc')->get();

        $productPrice = $product->variants()->where('status', 1)->orderBy('position', 'asc')->first();

        $products = Product::where('featured', 1)->where('status', 1)->orderBy('position', 'asc')->get();

        $recently_viewed_products_ids = Helper::recently_products($product->id);
        $recently_viewed_products = Product::whereIn('id', $recently_viewed_products_ids)->where('status', 1)->orderBy('position', 'asc')->get();

        $similar_products_ids = ProductSimilar::where('product_id', $product->id)->where('status', 1)->orderBy('position', 'asc')->pluck("similar_id")->toArray();
        $similar_products = Product::whereIn('id', $similar_products_ids)->where('status', 1)->get();

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Products', 'url' => route('products')],
            ['label' => $product->title],
        ];
        return view('public.productDetail', compact(
            'product',
            'productImages',
            'productVariants',
            'products',
            'similar_products',
            'recently_viewed_products',
            'breadcrumbs',
            'productPrice'
        ));
    }

    public function variant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails())
            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        else {
            $productPrice = ProductVariant::find($request->id);
            if ($productPrice)
                return response()->json(['res' => 'success', 'price' => $productPrice->sale_price]);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function reloadSlider($product_id, $variant_id)
    {
        $productImages = ProductImage::where('product_id', $product_id)->where('variant_id', $variant_id)->where('status', 1)->orderBy('position', 'asc')->get();
        $productVariants = ProductVariant::where('product_id', $product_id)->where('status', 1)->orderBy('position', 'asc')->get();
        return view('public.parts.productSlider', ['productImages' => $productImages, 'productVariants' => $productVariants])->render();
    }

    public function base_discount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'variant_id' => 'required|numeric',
            'qty' => 'required|numeric',
        ]);
        if ($validator->fails())
            return response()->json(['res' => 'error', 'msg' => 'Something went wrong, try later.']);
        else {
            $product = Product::where('id', $request->product_id)->where('status', 1)->first();
            $variant = ProductVariant::where('id', $request->variant_id)->where('status', 1)->first();

            $discounts = Helper::discount($product->id, $variant->id, $request->qty);

            $baseDiscount = view('public.parts.baseDiscount', ['variant_price' => $discounts["variant_price"], 'variant_discount_price' => $discounts["variant_discount_price"], 'total_amount' => $discounts["total_amount"], 'total_discount_amount' => $discounts["total_discount_amount"]])->render();
            $priceDropDown = view('public.parts.priceDropDown', ['product_id' => $product->id, 'variant_id' => $variant->id, 'qtySel' => $request->qty])->render();

            return response()->json(['res' => 'success', 'html' => $baseDiscount, 'priceDropDown' => $priceDropDown]);
        }
    }

    public function incremental_discount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'variant_id' => 'required|numeric',
            'qty' => 'required|numeric',
        ]);
        if ($validator->fails())
            return response()->json(['res' => 'error', 'msg' => 'Something went wrong, try later.']);
        else {
            $product = Product::where('id', $request->product_id)->where('status', 1)->first();
            $variant = ProductVariant::where('id', $request->variant_id)->where('status', 1)->first();
            $qty = $request->qty;

            $discounts = Helper::discount($product->id, $variant->id, $qty);

            $returnHTML = view('public.parts.incrementalDiscount', ['qty' => $qty, 'variant_price' => $discounts["variant_price"], 'variant_discount_price' => $discounts["variant_discount_price"], 'total_amount' => $discounts["total_amount"], 'total_discount_amount' => $discounts["total_discount_amount"]])->render();
            return response()->json(['res' => 'success', 'html' => $returnHTML]);
        }
    }

    public function itemWishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'error', 'msg' => 'Invalid product...']);
        } else {
            if (Auth::check()) {
                $product = Product::find($request->product_id);
                if ($product) {
                    $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first();
                    if ($wishlist) {
                        if ($wishlist->delete()) {
                            $items = Wishlist::where('user_id', auth()->user()->id)->count();
                            return response()->json(['res' => 'success', 'msg' => 'Item removed from wishlist successfully.', 'wishlisted' => false, 'items' => $items]);
                        } else
                            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
                    } else {
                        $wishlist = new Wishlist;
                        $wishlist->user_id = auth()->user()->id;
                        $wishlist->product_id = $product->id;
                        $wishlist->product_name = $product->title;
                        $wishlist->product_image = $product->images()->where('preferred', 1)->value('image');
                        if ($wishlist->save()) {
                            $items = Wishlist::where('user_id', auth()->user()->id)->count();
                            return response()->json(['res' => 'success', 'msg' => 'Item added to wishlist successfully.', 'wishlisted' => true, 'items' => $items]);
                        } else
                            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
                    }
                } else
                    return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
            } else {
                session(['wishlistItem' => $request->product_id]);
                return response()->json(['res' => 'error', 'msg' => 'Please login for wishlisting item.']);
            }
        }
    }

    public function productReviewSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'mobile_no' => 'required|numeric|digits:10',
            'review' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = new ProductReview();
            $data->product_id = $request->product_id;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->mobile_no = $request->mobile_no;
            $data->review = $request->review;
            if ($data->save()) {
                return response()->json(['res' => 'success', 'msg' => 'Your review has been submited successfully.']);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }
}
