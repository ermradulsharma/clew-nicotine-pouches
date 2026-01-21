<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Mail\OrderPacked;
use App\Mail\OrderShipped;
use App\Mail\OrderDelivered;
use App\Mail\OrderCancelled;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
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
        DB::enableQueryLog();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Order $order)
    {
        $query = Order::query();
        if ($request->filled('order_status')) {
            $query->where('order_status', $request->order_status);
        }
        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        } else {
            $query->where('payment_status', 'Paid');
        }
        if ($request->filled('searchKey')) {
            $searchKey = $request->searchKey;
            $query->where(function ($q) use ($searchKey) {
                $q->where('id', 'LIKE', "%{$searchKey}%")
                    ->orWhere('first_name', 'LIKE', "%{$searchKey}%")
                    ->orWhere('last_name', 'LIKE', "%{$searchKey}%")
                    ->orWhere('email', 'LIKE', "%{$searchKey}%")
                    ->orWhere('address', 'LIKE', "%{$searchKey}%")
                    ->orWhere('state', 'LIKE', "%{$searchKey}%")
                    ->orWhere('city', 'LIKE', "%{$searchKey}%")
                    ->orWhere('mobile', 'LIKE', "%{$searchKey}%")
                    ->orWhere('pincode', 'LIKE', "%{$searchKey}%");
            });
        }
        if ($request->filled('dateFrom') && $request->filled('dateTo')) {
            $from = Carbon::parse($request->dateFrom)->startOfDay();
            $to = Carbon::parse($request->dateTo)->endOfDay();
            $query->whereBetween('created_at', [$from, $to]);
        }
        $sort = $request->query('sort', 'id');
        $direction = $request->query('direction', 'desc');
        $orders = $query->orderBy($sort, $direction)->paginate(50);
        return view('admin.order.index', ['name' => 'Order', 'page' => 'View', 'all_data' => $orders]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('admin.order.invoice', ['order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('admin.order.edit', ['name' => 'Order', 'page' => 'Edit', 'data' => $order]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'order_status' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        }
        $order->order_status = $request->order_status;
        $order->remark = $request->remark ?? null;
        $order->docket_link = $request->docket_link ?? null;
        $order->docket_number = $request->docket_number ?? null;
        $order->updated_by = auth()->id();
        if ($order->save()) {
            return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => route('admin.order.index')]);
        }
        return response()->json(['res' => 'error', 'msg' => 'Something went wrong, please try again later.']);
    }
}
