<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Imports\StoreImport;
use App\Exports\StoreExport;
use App\Exports\StoreTemplateExport;
// use Excel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class StoreController extends Controller
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
    public function index(Request $request, Store $store)
    {
        $data = (new Store)->newQuery();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $data->where(function ($query) use ($searchKey) {
                $query->where('name', 'LIKE', '%' . $searchKey . '%')->orWhere('address', 'LIKE', '%' . $searchKey . '%')->orWhere('state', 'LIKE', '%' . $searchKey . '%')->orWhere('city', 'LIKE', '%' . $searchKey . '%')->orWhere('zip', 'LIKE', '%' . $searchKey . '%');
            });
        }
        $all_data = $data->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.store.index', ['name' => 'Store', 'page' => 'View', 'all_data' => $all_data]);
    }

    public function importView(Request $request)
    {
        return view('admin.store.import', ['name' => 'Store', 'page' => 'Import']);
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'excel' => 'required|mimes:xlsx,xls',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->with('error', $errors->first('excel'));
        }
        Excel::import(new StoreImport, request()->file('excel'));
        return redirect()->back()->with('success', 'Excel file imported successfully!');
    }

    public function export()
    {
        return Excel::download(new StoreExport, 'stores-' . time() . '.xlsx');
    }
    public function downloadTemplate()
    {
        return Excel::download(new StoreTemplateExport, 'clew-pouches-store-template.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.store.add', ['name' => 'store', 'page' => 'Add']);
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
            'name' => 'required|max:255',
            'address' => 'required',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'zip' => 'required|max:255',
            'country' => 'required|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = new Store;
            $data->name = $request->name;
            $data->address = $request->address;
            $data->city = $request->city;
            $data->state = $request->state;
            $data->zip = $request->zip;
            $data->country = $request->country;
            $data->latitude = $request->latitude;
            $data->longitude = $request->longitude;
            $data->status = 1;
            $data->created_by = auth()->user()->id;
            if ($data->save())
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.']);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        return view('admin.store.edit', ['name' => 'store', 'page' => 'Edit', 'data' => $store]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'address' => 'required',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'zip' => 'required|max:255',
            'country' => 'required|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = Store::find($store->id);
            $data->name = $request->name;
            $data->address = $request->address;
            $data->city = $request->city;
            $data->state = $request->state;
            $data->zip = $request->zip;
            $data->country = $request->country;
            $data->latitude = $request->latitude;
            $data->longitude = $request->longitude;
            $data->updated_by = auth()->user()->id;
            if ($data->save())
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => '/admin/store']);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        //
    }
}
