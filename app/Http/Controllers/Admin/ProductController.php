<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Flavour;
use App\Models\Label;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\State;
use App\Models\Strength;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $redirectTo = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Product $product)
    {
        $categories = Category::all();
        $product = (new Product)->newQuery();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $product->where(function ($query) use ($searchKey) {
                $query->where('title', 'LIKE', '%' . $searchKey . '%')->orWhere('sku_code', 'LIKE', '%' . $searchKey . '%')->orWhere('short_description', 'LIKE', '%' . $searchKey . '%')->orWhere('description', 'LIKE', '%' . $searchKey . '%')->orWhere('pageTitle', 'LIKE', '%' . $searchKey . '%')->orWhere('pageDescription', 'LIKE', '%' . $searchKey . '%')->orWhere('pageKeywords', 'LIKE', '%' . $searchKey . '%');
            });
        }
        $all_data = $product->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.product.index', ['name' => 'Product', 'page' => 'View', 'categories' => $categories, 'all_data' => $all_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $flavours = Flavour::where('status', 1)->get();
        $strengths = Strength::where('status', 1)->get();
        $labels = Label::where('status', 1)->get();
        $states = State::get();
        return view('admin.product.add', ['name' => 'Product', 'page' => 'Add', 'categories' => $categories, 'flavours' => $flavours, 'strengths' => $strengths, 'labels' => $labels, 'states' => $states]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|numeric',
            'title' => 'required|max:255',
            'flavour_id' => 'required|max:255',
            // 'tagline' => 'required',
            'sku_code' => 'required|max:255',
            // 'mrp' => 'required|between:0,99.99',
            'price' => 'required|between:0,99.99',
            'banner' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        }
        $banner = null;
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $banner = now()->timestamp . '-' . $file->getClientOriginalName();
            $file->storeAs('public/product/banner', $banner);
        }
        $data = new Product;
        $data->category_id = $request->category_id;
        $data->title = $request->title;
        $data->flavour_id = $request->flavour_id;
        $data->sku_code = $request->sku_code;
        $data->tagline = $request->tagline;
        $data->label_id = $request->label_id;
        $data->mrp = $request->price;
        $data->price = $request->price;
        $data->rating = $request->rating;
        $data->banner = $banner;
        $data->base_discount = $request->base_discount;
        $data->incremental_discount = $request->incremental_discount;
        $data->max_discount = $request->max_discount;
        $data->short_description = $request->short_description;
        $data->description = $request->description;
        $data->pageTitle = $request->pageTitle;
        $data->pageDescription = $request->pageDescription;
        $data->pageKeywords = $request->pageKeywords;
        $data->status = ($request->status) ? 1 : 0;
        $data->slug = Str::slug($request->title, '-');
        $data->position = Product::where('category_id', $request->category_id)->max('position') + 1;
        $data->created_by = auth()->user()->id;
        $data->restricted_state = implode(',', $request->restricted_state) ?? null;
        if ($data->save()) {
            foreach ($request->strengths as $strength) {
                $strengthData = new ProductVariant;
                $strengthData->product_id = $data->id;
                $strengthData->strength_id = $strength;
                $strengthData->qty = 20;
                $strengthData->mrp = $request->mrp;
                $strengthData->price = $request->price;
                $strengthData->sale_price = $request->price;
                $strengthData->position = ProductVariant::where('product_id', $data->id)->max('position') + 1;
                $strengthData->created_by = auth()->user()->id;
                $strengthData->save();
            }
            return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => '/admin/product/create']);
        } else {
            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product->load('variants');
        $categories = Category::where('status', 1)->get();
        $flavours = Flavour::where('status', 1)->get();
        $strengths = Strength::where('status', 1)->get();
        $labels = Label::where('status', 1)->get();
        $states = State::get();
        return view('admin.product.edit', ['name' => 'Product', 'page' => 'Edit', 'categories' => $categories, 'flavours' => $flavours, 'labels' => $labels, 'data' => $product, 'strengths' => $strengths, 'labels' => $labels, 'states' => $states]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|numeric',
            'title' => 'required|max:255',
            'flavour_id' => 'required|max:255',
            // 'tagline' => 'required',
            'sku_code' => 'required|max:255',
            // 'mrp' => 'required|between:0,99.99',
            // 'price' => 'required|between:0,99.99',
            'banner' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = Product::find($product->id);
            if ($request->hasFile('banner')) {
                $banner = now()->timestamp . "-" . $request->file('banner')->getClientOriginalName();
                $request->file('banner')->storeAs('public/product/banner', $banner);
            } else
                $banner = $data->banner;

            $data->category_id = $request->category_id;
            $data->title = $request->title;
            $data->flavour_id = $request->flavour_id;
            $data->sku_code = $request->sku_code;
            $data->tagline = $request->tagline;
            $data->label_id = $request->label_id;
            // $data->mrp = $request->price;
            $data->price = $request->price;
            $data->rating = $request->rating;
            $data->banner = $banner;
            $data->base_discount = $request->base_discount;
            $data->incremental_discount = $request->incremental_discount;
            $data->max_discount = $request->max_discount;
            $data->short_description = $request->short_description;
            $data->description = $request->description;
            $data->pageTitle = $request->pageTitle;
            $data->pageDescription = $request->pageDescription;
            $data->pageKeywords = $request->pageKeywords;
            $data->slug = Str::slug($request->title, '-');
            $data->updated_by = auth()->user()->id;
            $data->restricted_state = !empty($request->restricted_state) ? implode(',', $request->restricted_state) : null;
            if ($data->save()) {
                // return $request->strengths;
                // $data->variants()->delete();
                if ($request->has('strengths') && is_array($request->strengths)) {
                    foreach ($request->strengths as $strength) {
                        $variant = ProductVariant::where(['product_id' => $data->id, 'strength_id' => $strength])->first();
                        if (!$variant) {
                            $variant = new ProductVariant;
                            $variant->product_id = $data->id;
                            $variant->strength_id = $strength;
                        }
                        $variant->qty = 20;
                        $variant->mrp = $request->price;
                        $variant->price = $request->price;
                        $variant->sale_price = $request->price;
                        $variant->position = ProductVariant::where('product_id', $data->id)->max('position') + 1;
                        $variant->created_by = auth()->id();
                        $variant->save();
                    }
                }
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => route('admin.product.index')]);
            } else {
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
            }
        }
    }

    public function position(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|numeric',
                'position' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            return back()->with('error', 'Please enter position.');
        } else {
            $data = Product::find($request->id);
            $data->position = $request->position;
            if ($data->save()) {
                $position = 0;
                $all_data = Product::select('id')->where('id', '!=', $request->id)->orderBy('position', 'asc')->get();
                foreach ($all_data as $data) {
                    $position++;
                    if ($position == $request->position) $position++;
                    $dataUpdate = Product::find($data->id);
                    $dataUpdate->position = $position;
                    $dataUpdate->save();
                }
                return back()->with('success', 'Position saved successfully.');
            } else
                return back()->with('error', 'Something wrong, try later.');
        }
    }

    public function showOnCart(Request $request)
    {
        $product = Product::where('id', '<>', $request->id)->update(['showOnCart' => 0]);
        if (Product::where('id', $request->id)->update(['showOnCart' => 1]))
            return response()->json(['res' => 'success', 'msg' => 'Data updated successfully.']);
        else
            return response()->json(['res' => 'failed', 'msg' => 'Something wrong, try later.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product = Product::find($product->id);
        $product->delete();
    }
}
