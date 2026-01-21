<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    protected $redirectTo = RouteServiceProvider::Admin;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Discount::query();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $query->where('title', 'like', '%' . $searchKey . '%');
        }
        $sortableFields = ['id', 'base_discount', 'incremental_discount', 'max_discount', 'created_at'];
        $sort = in_array($request->query('sort'), $sortableFields) ? $request->query('sort') : 'id';
        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';
        $all_data = $query->orderBy($sort, $direction)->paginate(50);
        return view('admin.discount.index', [
            'name' => 'Discount',
            'page' => 'View',
            'all_data' => $all_data,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.discount.add', ['name' => 'Discount', 'page' => 'Add', 'products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'base_discount' => 'required|numeric|min:0',
            'incremental_discount' => 'required|numeric|min:0',
            'max_discount' => 'required|numeric|min:0',
            'products' => 'nullable|array',
            'products.*' => 'integer|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        }
        $discountExists = Discount::where('status', 1)->exists();
        if ($discountExists) {
            return response()->json(['res' => 'failed', 'msg' => 'Active Discount Already Exists. Deactivate it first.', 'url' => '/admin/discount']);
        }
        $discount = new Discount();
        $discount->base_discount = $request->base_discount;
        $discount->incremental_discount = $request->incremental_discount;
        $discount->max_discount = $request->max_discount;
        $discount->products = ($request->products) ? json_encode($request->products) : null;
        if ($discount->save()) {
            return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => '/admin/discount']);
        }
        return response()->json(['res' => 'failed', 'msg' => 'Something went wrong, please try again later.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        $products = Product::all();
        return view('admin.discount.edit', ['name' => 'Discount', 'page' => 'Edit', 'data' => $discount, 'products' => $products]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        $validator = Validator::make($request->all(), [
            'base_discount' => 'required|numeric|min:0',
            'incremental_discount' => 'required|numeric|min:0',
            'max_discount' => 'required|numeric|min:0',
            'products' => 'nullable|array',
            'products.*' => 'integer|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        }
        $discount->base_discount = $request->base_discount;
        $discount->incremental_discount = $request->incremental_discount;
        $discount->max_discount = $request->max_discount;
        $discount->products = ($request->products) ? json_encode($request->products) : null;
        if ($discount->save()) {
            return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => '/admin/discount']);
        }
        return response()->json(['res' => 'failed', 'msg' => 'Something went wrong, please try again later.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        //
    }
}
