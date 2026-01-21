<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSimilar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductSimilarController extends Controller
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
    public function index(Product $product)
    {
        $products = Product::where('status', 1)->where('id', '!=', $product->id)->orderBy('id', 'desc')->get();
        $productSimilars = ProductSimilar::where('product_id', $product->id)->orderBy('id', 'desc')->pluck('similar_id')->toArray();

        $all_data = ProductSimilar::where('product_id', $product->id)->orderBy('id', 'desc')->get();

        return view('admin.product.similar.index', ['name' => 'Product similars', 'page' => 'View', 'products' => $products, 'product' => $product, 'productSimilars' => $productSimilars, 'all_data' => $all_data]);
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
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        } else {
            if ($request->similars) {
                $similars = implode(',', $request->similars);
                $oldDatas = ProductSimilar::where('product_id', $request->id)->orderBy('id', 'desc')->get();

                foreach ($oldDatas as $oldData) {
                    if (!in_array($oldData->similar_id, $request->similars))
                        ProductSimilar::where(['product_id' => $request->id, 'similar_id' => $oldData->similar_id])->delete();
                }
                foreach ($request->get('similars')  as $similar) {
                    if (!ProductSimilar::where(['product_id' => $request->id, 'similar_id' => $similar])->first()) {
                        $data = new ProductSimilar;
                        $data->product_id = $request->id;
                        $data->similar_id = $similar;
                        $data->position = ProductSimilar::where('product_id', $request->id)->max('position') + 1;
                        $data->status = 1;
                        $data->created_by = auth()->user()->id;
                        $data->save();
                    }
                }
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => '/admin/product/' . $request->id . '/similar']);
            } else {
                ProductSimilar::where(['product_id' => $request->id])->delete();
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => '/admin/product/' . $request->id . '/similar']);
            }
        }
    }

    public function position(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|numeric',
                'product_id' => 'required|numeric',
                'similar_id' => 'required|numeric',
                'position' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('admin.product.similar.index', [$request->product_id]);
        } else {
            $data = ProductSimilar::find($request->id);
            $data->position = $request->position;
            if ($data->save()) {
                $position = 0;
                $products = ProductSimilar::select('id')->where('id', '!=', $request->id)->where('product_id', $request->product_id)->where('similar_id', $request->similar_id)->orderBy('position', 'asc')->get();
                foreach ($products as $product) {
                    $position++;
                    if ($position == $request->position) $position++;
                    $dataUpdate = ProductSimilar::find($product->id);
                    $dataUpdate->position = $position;
                    $dataUpdate->save();
                }
                return redirect()->route('admin.product.similar.index', [$request->product_id]);
            } else
                return redirect()->route('admin.product.similar.index', [$request->product_id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductSimilar  $productSimilar
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductSimilar $productSimilar)
    {
        //
    }
}
