<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ProductImageController extends Controller
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
        $images = ProductImage::where('product_id', $product_id)->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.product.images.index', ['name' => 'Product Images', 'page' => 'View', 'product' => $product, 'all_data' => $images]);
    }

    public function create($product_id)
    {
        $variants = ProductVariant::where('product_id', $product_id)->orderBy('position', 'asc')->get();
        return view('admin.product.images.addModal', ['name' => 'Product Images', 'page' => 'Add', 'product_id' => $product_id, 'variants' => $variants]);
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
            'product_id' => 'required|numeric',
            'title' => 'required|max:255',
            'variant_id' => 'required|numeric',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $image = now()->timestamp . "-" . $request->file('image')->getClientOriginalName();
            if ($request->file('image')->storeAs('public/product/multishots', $image)) {
                $request->file('image')->storeAs('public/product/multishots/thumb', $image);
                $thumbnailpath = public_path('storage/product/multishots/thumb/' . $image);
                $img = Image::make($thumbnailpath)->resize(156, 176, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($thumbnailpath, 90);
                $data = new ProductImage;
                $data->product_id = $request->product_id;
                $data->title = $request->title;
                $data->strength_id = ProductVariant::where('id', $request->variant_id)->value('strength_id');
                $data->variant_id = $request->variant_id;
                $data->thumb = $image;
                $data->image = $image;
                $data->position = ProductImage::where('product_id', $request->product_id)->max('position') + 1;
                $data->preferred = (ProductImage::where('product_id', $request->product_id)->sum('preferred')) ? 0 : 1;
                $data->created_by = auth()->user()->id;
                if ($data->save())
                    return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.']);
                else
                    return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Please select image, try later.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function edit($product_id, $id)
    {
        $productImage = ProductImage::find($id);
        $variants = ProductVariant::where('product_id', $product_id)->orderBy('position', 'asc')->get();
        return view('admin.product.images.editModal', ['name' => 'Product Images', 'page' => 'Edit', 'data' => $productImage, 'variants' => $variants]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductImage $productImage)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'title' => 'required|max:255',
            'variant_id' => 'required|numeric',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = ProductImage::find($request->id);
            if ($request->hasFile('image')) {
                $image = now()->timestamp . "-" . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/product/multishots', $image);
                $request->file('image')->storeAs('public/product/multishots/thumb', $image);
                //Resize image here
                $thumbnailpath = public_path('storage/product/multishots/thumb/' . $image);
                $img = Image::make($thumbnailpath)->resize(156, 176, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($thumbnailpath, 90);
            } else
                $image = $data->image;

            $data->title = $request->title;
            $data->strength_id = ProductVariant::where('id', $request->variant_id)->value('strength_id');
            $data->variant_id = $request->variant_id;
            $data->thumb = $image;
            $data->image = $image;
            $data->updated_by = auth()->user()->id;
            if ($data->save())
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.']);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductImage $productImage)
    {
        $productImage = ProductImage::find($productImage->id);
        $productImage->delete();
    }
}
