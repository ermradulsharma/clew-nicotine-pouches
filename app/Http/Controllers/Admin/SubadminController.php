<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SubadminController extends Controller
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
    public function index(Request $request)
    {
        $data = (new Admin)->newQuery();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $data->where(function ($query) use ($searchKey) {
                $query->where('name', 'LIKE', '%' . $searchKey . '%')->orWhere('email', 'LIKE', '%' . $searchKey . '%')->orWhere('username', 'LIKE', '%' . $searchKey . '%');
            });
        }
        $all_data = $data->where('username', '!=', 'admin')->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.subadmin.index', ['name' => 'Additional Admin', 'page' => 'View', 'all_data' => $all_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('id', '!=', 1)->get();
        return view('admin.subadmin.add', ['name' => 'Additional Admin', 'page' => 'Add', 'roles' => $roles]);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'role_id' => 'required|numeric',
            'password' => 'required|min:6|max:20',
            'confirmPassword' => 'required|min:6|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = new Admin;
            $data->role_id = $request->role_id;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->username = $request->email;
            $data->password = Hash::make($request->password);
            if ($data->save())
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.']);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $subadmin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $subadmin)
    {
        $roles = Role::where('id', '!=', 1)->get();
        return view('admin.subadmin.edit', ['name' => 'Additional Admin', 'page' => 'Edit', 'data' => $subadmin, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $subadmin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $subadmin)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $subadmin->id,
            'role_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = Admin::where('id', $subadmin->id)->where('type', 'sub')->first();
            $data->role_id = $request->role_id;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->username = $request->email;
            if ($data->save())
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => route('admin.subadmin.index')]);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin $subadmin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $subadmin)
    {
        //
    }
}
