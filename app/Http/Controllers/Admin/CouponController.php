<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Product;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Coupon $coupon) 
    {
        //dd($request->all());
        $coupon = (new Coupon)->newQuery();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $coupon->where('title', 'LIKE', '%' . $searchKey . '%');
        }

        $all_data = $coupon->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.coupon.index', ['name' => 'Coupon', 'page' => 'View', 'all_data' => $all_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = \App\Models\Product::all();
        return view('admin.coupon.add', ['name' => 'Coupon', 'page' => 'Add', 'products' => $products]);
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
            'title' => 'required|max:255',
            'code' => 'required|max:255',
            'discount' => 'required|numeric',
            'units' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            if (Coupon::where('code', base64_encode($request->code))->first()) {
                return response()->json(['res' => 'error', 'msg' => 'Coupon code already exist.']);
            } else {
                $data = new Coupon;
                $data->title = $request->title;
                $data->code = base64_encode($request->code);
                $data->discount_type = $request->discount_type;
                $data->discount = $request->discount;
                $data->units = $request->units;
                $data->products = ($request->products) ? json_encode($request->products) : null;
                $data->start_date = $request->start_date;
                $data->end_date = $request->end_date;
                $data->created_by = auth()->user()->id;
                if ($data->save())
                    return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.']);
                else
                    return response()->json(['res' => 'failed', 'msg' => 'Something wrong, try later.']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        $products = \App\Models\Product::all();
        return view('admin.coupon.edit', ['name' => 'Coupon', 'page' => 'Edit', 'data' => $coupon, 'products' => $products]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|max:255',
            'discount' => 'required|numeric',
            'units' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            if (Coupon::where('code', base64_encode($request->code))->first()) {
                return response()->json(['res' => 'error', 'msg' => 'Coupon code already exist.']);
            } else {
                $data = Coupon::find($coupon->id);
                $data->title = $request->title;
                $data->discount = $request->discount;
                $data->discount_type = $request->discount_type;
                $data->units = $request->units;
                $data->products = ($request->products) ? json_encode($request->products) : null;
                $data->start_date = $request->start_date;
                $data->end_date = $request->end_date;
                $data->updated_by = auth()->user()->id;
                if ($data->save())
                    return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => '/admin/coupon']);
                else
                    return response()->json(['res' => 'failed', 'msg' => 'Something wrong, try later.']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
