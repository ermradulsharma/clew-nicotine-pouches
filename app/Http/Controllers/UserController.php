<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReturned;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        $user = User::find(auth()->user()->id);
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'My Profile'],
        ];
        return view('public.profile', ['user' => $user, 'breadcrumbs' => $breadcrumbs]);
    }

    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = User::find(auth()->user()->id);
            $data->name = $request->first_name . " " . $request->last_name;
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            if ($data->save())
                return response()->json(['res' => 'success', 'msg' => 'Profile saved successfully.']);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function passwordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => [
                'required',
                'string',
                'min:12',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
                'confirmed',
            ],
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            if (!Hash::check($request->current_password, auth()->user()->password))
                return response()->json(['res' => 'error', 'msg' => 'Current password does not match.']);
            elseif (strcmp($request->current_password, $request->password) == 0)
                return response()->json(['res' => 'error', 'msg' => 'New password cannot be same.']);
            else {
                $user = User::find(auth()->user()->id);
                $user->password = Hash::make($request->password);
                $user->updated_at = date('Y-m-d H:i:s');
                if ($user->save())
                    return response()->json(['res' => 'success', 'msg' => 'Password updated successfully.']);
                else
                    return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
            }
        }
    }

    public function orders()
    {
        $orders = \App\Models\Order::where('user_id', auth()->user()->id)->where('payment_status', 'Paid')->orderBy('id', 'desc')->get();
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'My Order'],
        ];
        return view('public.orders', ['orders' => $orders, 'breadcrumbs' => $breadcrumbs]);
    }

    public function orderDetails($order_id)
    {
        if ($order_id) {
            $order = \App\Models\Order::where('id', $order_id)->where('user_id', auth()->user()->id)->where('payment_status', 'Paid')->first();
            if ($order) {
                $carts = \App\Models\Cart::where('order_id', $order->id)->where('user_id', auth()->user()->id)->get();
                $breadcrumbs = [
                    ['label' => 'Home', 'url' => route('home')],
                    ['label' => 'Products', 'url' => route('products')],
                    ['label' => 'Order Details'],
                ];
                return view('public.orderDetails', ['order' => $order, 'carts' => $carts, 'breadcrumbs' => $breadcrumbs]);
            } else
                return view('404');
        } else
            return view('404');
    }

    public function orderReturnForm(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'error', 'msg' => 'Order ID not not found.']);
        } else {
            $order = Cart::where('id', $request->cart_id)->where('order_id', $request->order_id)->where('user_id', auth()->user()->id)->where('status', 'Shipped')->first();
            if (!$order) {
                $order = Cart::where('id', $request->cart_id)->where('order_id', $request->order_id)->where('user_id', auth()->user()->id)->where('status', 'Delivered')->first();
            }
            //dd($order->toArray());
            //dd("-".$order->return_days." day"); 
            if ($order) {
                if (strtotime("-" . $order->return_days . " day") <= strtotime($order->updated_at)) {
                    $html = view('public.parts.orderReturnForm', ['order' => $order, 'cart_id' => $request->cart_id]);
                    return response()->json(['res' => 'success', 'msg' => 'Return window opend successfully.', 'html' => $html->render()]);
                } else
                    return response()->json(['res' => 'error', 'msg' => 'Return window is closed for this Order.']);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Order ID not not found.']);
        }
    }

    public function orderReturnConfirm(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|max:255',
            'cart_id' => 'required|max:255',
            'return_reason' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'error', 'msg' => 'Please enter order return reason']);
        } else {
            $order = Order::where('id', $request->order_id)->where('user_id', auth()->user()->id)->where('order_status', 'Shipped')->where('payment_status', 'Paid')->first();
            if (!$order) {
                $order = Order::where('id', $request->order_id)->where('user_id', auth()->user()->id)->where('order_status', 'Delivered')->where('payment_status', 'Paid')->first();
            }
            if ($order) {
                $cartReturn = Cart::where('id', $request->cart_id)->where('status', 'Shipped')->where('order_id', $request->order_id)->where('user_id', auth()->user()->id)->first();
                if (!$cartReturn) {
                    $cartReturn = Cart::where('id', $request->cart_id)->where('status', 'Delivered')->where('order_id', $request->order_id)->where('user_id', auth()->user()->id)->first();
                }
                if (strtotime("-" . $cartReturn->return_days . " day") <= strtotime($cartReturn->updated_at)) {
                    $cartReturn->status = "Return request";
                    $cartReturn->order_status = "return";
                    $cartReturn->return_reason = $request->return_reason;
                    $cartReturn->return_at = date("Y-m-d H:i:s");
                    if ($cartReturn->save()) {
                        $order = Order::find($order->id);
                        // @Mail::to($order->email)->bcc("orders@purys.com")->send(new OrderReturned($order));
                        return response()->json(['res' => 'success', 'msg' => 'Order returned successfully.']);
                    } else
                        return response()->json(['res' => 'error', 'msg' => 'Something wrong wrong, please try later.']);
                } else
                    return response()->json(['res' => 'error', 'msg' => 'Return window is closed for this Order.']);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Order ID not not found.']);
        }
    }

    public function addresses()
    {
        $states = \App\Models\State::where('status', 1)->orderBy('title', 'asc')->get();
        $userAddresses = \App\Models\UserAddress::where('user_id', auth()->user()->id)->get();
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Address'],
        ];
        return view('public.addresses', ['userAddresses' => $userAddresses, 'states' => $states, 'breadcrumbs' => $breadcrumbs]);
    }

    public function addressCreate(Request $request)
    {
        $states = \App\Models\State::where('status', 1)->orderBy('title', 'asc')->get();
        return view('public.parts.addressForm', ['userAddress' => '', 'states' => $states]);
    }

    public function addressStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required|numeric',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required',
            'apartment' => 'required',
            'pincode' => 'required|numeric',
            'state' => 'required|numeric',
            'city' => 'required|max:255',
            'mobile' => 'required|numeric|digits:10',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            if ($request->filled('id')) {
                $userAddress = \App\Models\UserAddress::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
                $preferred = $userAddress->preferred;
                if (!$userAddress) $userAddress = new \App\Models\UserAddress;
            } else {
                $userAddressCount = \App\Models\UserAddress::where('user_id', auth()->user()->id)->first();
                $preferred = ($userAddressCount) ? 0 : 1;
                $userAddress = new \App\Models\UserAddress;
            }
            $userAddress->user_id = auth()->user()->id;
            $userAddress->country = \App\Models\Country::where('id', $request->country)->value('title');
            $userAddress->country_id = $request->country;
            $userAddress->first_name = $request->first_name;
            $userAddress->last_name = $request->last_name;
            $userAddress->name = $request->first_name . " " . $request->last_name;
            $userAddress->email = auth()->user()->email;
            $userAddress->mobile = $request->mobile;
            $userAddress->address = $request->address;
            $userAddress->apartment = $request->apartment;
            $userAddress->city = $request->city;
            $userAddress->state = \App\Models\State::where('id', $request->state)->value('title');
            $userAddress->state_id = $request->state;
            $userAddress->pincode = $request->pincode;
            $userAddress->preferred = $preferred;
            if ($userAddress->save())
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.']);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function addressEdit(Request $request)
    {
        $states = \App\Models\State::where('status', 1)->orderBy('title', 'asc')->get();
        $userAddress = \App\Models\UserAddress::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
        return view('public.parts.addressForm', ['userAddress' => $userAddress, 'states' => $states]);
    }

    public function addressUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'name' => 'required|max:255',
            // 'email' => 'required|email|max:255',
            'mobile' => 'required|numeric|digits:10',
            'address' => 'required',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'pincode' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $userAddress = \App\Models\UserAddress::find($request->id);
            $userAddress->user_id = auth()->user()->id;
            $userAddress->name = $request->name;
            $userAddress->email = $request->email;
            $userAddress->mobile = $request->mobile;
            $userAddress->address = $request->address;
            $userAddress->area = $request->area;
            $userAddress->landmark = $request->landmark;
            $userAddress->city = $request->city;
            $userAddress->state = \App\Models\State::where('id', $request->state)->value('title');
            $userAddress->state_id = $request->state;
            $userAddress->pincode = $request->pincode;
            if ($userAddress->save())
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.']);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function addressPreferred(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails())
            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        else {
            \App\Models\UserAddress::where('user_id', auth()->user()->id)->update(['preferred' => 0]);
            if (\App\Models\UserAddress::where('id', $request->id)->update(['preferred' => 1]))
                return response()->json(['res' => 'success', 'msg' => 'Address set as default successfully.']);
            else
                return response()->json(['res' => 'failed', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function deleteAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails())
            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        else {
            $userAddress = \App\Models\UserAddress::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
            if ($userAddress->delete())
                return response()->json(['res' => 'success', 'msg' => 'Address removed successfully.']);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function reloadAddress()
    {
        $userAddresses = \App\Models\UserAddress::where('user_id', auth()->user()->id)->get();
        return view('public.parts.addressSection', ['page' => 'addresses', 'userAddresses' => $userAddresses]);
    }

    public function resetAddress()
    {
        return view('public.parts.addressForm', ['userAddress' => '']);
    }

    public function wishlist()
    {
        $wishlists = \App\Models\Wishlist::where('user_id', auth()->user()->id)->get();
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Products', 'url' => route('products')],
            ['label' => 'My Wishlist'],
        ];
        return view('public.wishlist', ['wishlists' => $wishlists, 'breadcrumbs' => $breadcrumbs]);
    }

    public function deleteWishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails())
            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        else {
            $wishlist = \App\Models\Wishlist::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
            if ($wishlist->delete()) {
                $items = \App\Models\Wishlist::where('user_id', auth()->user()->id)->count();
                return response()->json(['res' => 'success', 'msg' => 'Item removed from wishlist successfully.', 'items' => $items]);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function reloadWishlist()
    {
        $wishlists = \App\Models\Wishlist::where('user_id', auth()->user()->id)->get();
        return view('public.parts.wishlistSection', ['wishlists' => $wishlists]);
    }
}
