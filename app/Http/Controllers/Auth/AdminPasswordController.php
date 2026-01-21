<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Auth;
use Illuminate\Support\Facades\Validator;

class AdminPasswordController extends Controller
{
    protected $redirectTo = '/admin/login';

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function changePassword()
    {
        return view('auth.admin.changePassword', ['name' => 'Change Password', 'page' => 'Edit']);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            if (!Hash::check($request->oldPassword, auth()->user()->password))
                return response()->json(['res' => 'error', 'msg' => 'Old password does not match.']);
            elseif (strcmp($request->oldPassword, $request->newPassword) == 0)
                return response()->json(['res' => 'error', 'msg' => 'New password cannot be same.']);
            else {
                $admin = \App\Models\Admin::find(auth()->user()->id);
                if ($admin) {
                    $admin->password = Hash::make($request->newPassword);
                    if ($admin->save())
                        return response()->json(['res' => 'success', 'msg' => 'Password updated successfully.']);
                    else
                        return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
                } else
                    return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
            }
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $admin = \App\Models\Admin::find($request->id);
            if ($admin) {
                $admin->password = Hash::make($request->newPassword);
                if ($admin->save())
                    return response()->json(['res' => 'success', 'msg' => 'Password updated successfully.']);
                else
                    return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }
}
