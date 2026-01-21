<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ProductVariantController extends Controller
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
    public function index(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        $variants = ProductVariant::where('product_id', $product_id)->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.product.variants.index', ['name' => 'Product variants', 'page' => 'View', 'product' => $product, 'all_data' => $variants]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($product_id)
    {
        $strengths = \App\Models\Strength::all();
        return view('admin.product.variants.addModal', ['name' => 'Product variants', 'page' => 'Add', 'product_id' => $product_id, 'strengths' => $strengths]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'strength_id' => 'required|numeric',
            // 'qty' => 'required|numeric',
            // 'mrp' => 'required|between:0,99.99',
            'price' => 'required|between:0,99.99',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048',
            // 'sale_price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $image = now()->timestamp . "-" . $request->file('image')->getClientOriginalName();
            if ($request->file('image')->storeAs('public/product', $image)) {
                $request->file('image')->storeAs('public/product/thumb', $image);
                //Resize image here
                $thumbnailpath = public_path('storage/product/thumb/' . $image);
                $img = Image::make($thumbnailpath)->resize(156, 176, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($thumbnailpath, 90);

                $data = new ProductVariant;
                $data->product_id = $request->product_id;
                $data->strength_id = $request->strength_id;
                $data->qty = 20;
                $data->mrp = $request->price;
                $data->price = $request->price;
                $data->sale_price = $request->price;
                $data->thumb = $image;
                $data->image = $image;
                $data->position = ProductVariant::where('product_id', $request->product_id)->max('position') + 1;
                $data->created_by = auth()->user()->id;
                if ($data->save()) {
                    $min_price = ProductVariant::where('product_id', $request->product_id)->min('price');
                    $product = Product::find($request->product_id);
                    $product->mrp = $min_price;
                    $product->price = $min_price;
                    $product->save();
                    return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.']);
                } else
                    return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Please select image, try later.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function edit($product_id, $id)
    {
        $strengths = \App\Models\Strength::all();
        $productVariant = ProductVariant::find($id);
        return view('admin.product.variants.editModal', ['name' => 'Product variants', 'page' => 'Edit', 'data' => $productVariant, 'strengths' => $strengths]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductVariant $productVariant)
    {
        $validator = \Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'strength_id' => 'required|numeric',
            // 'qty' => 'required|numeric',
            // 'mrp' => 'required|between:0,99.99',
            'price' => 'required|between:0,99.99',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048',
            // 'sale_price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = ProductVariant::find($request->id);
            if ($request->hasFile('image')) {
                $image = now()->timestamp . "-" . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/product', $image);
                $request->file('image')->storeAs('public/product/thumb', $image);

                //Resize image here
                $thumbnailpath = public_path('storage/product/thumb/' . $image);
                $img = Image::make($thumbnailpath)->resize(156, 176, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($thumbnailpath, 90);
            } else
                $image = $data->image;

            $data->product_id = $request->product_id;
            $data->strength_id = $request->strength_id;
            $data->qty = 20;
            $data->mrp = $request->price;
            $data->price = $request->price;
            $data->sale_price = $request->price;
            $data->thumb = $image;
            $data->image = $image;
            $data->updated_by = auth()->user()->id;
            if ($data->save()) {
                $min_price = ProductVariant::where('product_id', $request->product_id)->min('price');
                $product = Product::find($request->product_id);
                $product->mrp = $min_price;
                $product->price = $min_price;
                $product->save();
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.']);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductVariant $productVariant)
    {
        $productVariant = ProductVariant::find($productVariant->id);
        $productVariant->delete();
    }
}
