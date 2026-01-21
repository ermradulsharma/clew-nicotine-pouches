<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    protected $redirectTo = RouteServiceProvider::Admin;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $from_date = ($request->filled('from_date')) ? $request->from_date : date('Y-m-d', strtotime('-7 days'));
        $to_date = ($request->filled('to_date')) ? $request->to_date : date('Y-m-d');

        return view('admin.dashboard', ['from_date' => $from_date, 'to_date' => $to_date]);
    }

    public function report(Request $request)
    {
        $from_date = ($request->filled('from_date')) ? $request->from_date : date('Y-m-01');
        $to_date = ($request->filled('to_date')) ? $request->to_date : date('Y-m-d');
        return view('admin.report', ['from_date' => $from_date, 'to_date' => $to_date]);
    }

    public function getData(Request $request)
    {
        $table = DB::table('mappings')->where('alias', $request->get('alias'))->select('title')->first();
        $dataRow = DB::table($table->title)->where('id', $request->get('id'))->select('*')->first();
        if ($dataRow)
            return response()->json(['res' => 'success', 'title' => $dataRow->title, 'image' => $dataRow->image, 'alias' => $request->get('alias')]);
        else
            return response()->json(['res' => 'failed', 'msg' => 'Something wrong, try later.']);
    }

    public function positionData(Request $request)
    {
        $table = DB::table('mappings')->where('alias', $request->get('alias'))->select('title')->first();
        if (DB::table($table->title)->where('id', $request->get('id'))->update(['position' => $request->get('position')]))
            return response()->json(['res' => 'success', 'msg' => 'Position updated successfully.']);
        else
            return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
    }

    public function featuredData(Request $request)
    {
        $table = DB::table('mappings')->where('alias', $request->get('alias'))->select('title')->first();
        $dataRow = DB::table($table->title)->where('id', $request->get('id'))->select('*')->first();
        if (DB::table($table->title)->where('id', $request->get('id'))->update(['featured' => ($dataRow->featured) ? 0 : 1]))
            return response()->json(['res' => 'success', 'status' => (($dataRow->featured) ? false : true), 'msg' => 'Data updated successfully.']);
        else
            return response()->json(['res' => 'error', 'status' => false, 'msg' => 'Something wrong, try later.']);
    }

    public function publishData(Request $request)
    {
        $alias = $request->get('alias');
        $id = $request->get('id');
        if (!$alias || !$id) {
            return response()->json(['res' => 'failed', 'status' => false, 'msg' => 'Missing required parameters.']);
        }
        $mapping = DB::table('mappings')->where('alias', $alias)->select('title')->first();
        if (!$mapping || !$mapping->title) {
            return response()->json(['res' => 'failed', 'status' => false, 'msg' => 'Invalid alias provided.']);
        }
        $table = $mapping->title;
        $dataRow = DB::table($table)->where('id', $id)->select('status')->first();
        if (!$dataRow) {
            return response()->json(['res' => 'failed', 'status' => false, 'msg' => 'Record not found.']);
        }
        $newStatus = $dataRow->status ? 0 : 1;
        $updated = DB::table($table)->where('id', $id)->update(['status' => $newStatus]);
        if ($updated) {
            return response()->json(['res' => 'success', 'status' => (bool) $newStatus, 'msg' => 'Status updated successfully.']);
        } else {
            return response()->json(['res' => 'failed', 'status' => (bool) $dataRow->status, 'msg' => 'Something went wrong. Try again later.']);
        }
    }


    public function deleteData(Request $request)
    {
        $alias = $request->get('alias');
        $id = $request->get('id');
        if (!$alias || !$id) {
            return response()->json(['res' => 'failed', 'msg' => 'Missing required parameters.']);
        }
        $mapping = DB::table('mappings')->where('alias', $alias)->select('title')->first();
        if (!$mapping || !$mapping->title) {
            return response()->json(['res' => 'failed', 'msg' => 'Invalid alias provided.']);
        }
        $table = $mapping->title;
        $record = DB::table($table)->where('id', $id)->first();
        if (!$record) {
            return response()->json(['res' => 'failed', 'msg' => 'Record not found.']);
        }
        $deleted = DB::table($table)->where('id', $id)->delete();
        if ($deleted) {
            return response()->json(['res' => 'success', 'msg' => 'Data deleted successfully.']);
        } else {
            return response()->json(['res' => 'failed', 'msg' => 'Something went wrong, please try again later.']);
        }
    }


    public function deleteImage(Request $request)
    {
        $table = DB::table('mappings')->where('alias', $request->get('alias'))->select('title')->first();
        $dataRow = DB::table($table->title)->where('id', $request->get('id'))->select('*')->first();
        if (DB::table($table->title)->where('id', $request->get('id'))->update(['image' => null]))
            return response()->json(['res' => 'success', 'msg' => 'Image deleted successfully.']);
        else
            return response()->json(['res' => 'failed', 'msg' => 'Something wrong, try later.']);
    }

    public function getSubcategory(Request $request)
    {
        $subcategories = DB::table('subcategories')->where('category_id', $request->get('category_id'))->orderBy('title', 'asc')->get();
        $html = '<option value="">Subcategory</option>';
        foreach ($subcategories as $subcategory)
            $html .= '<option value="' . $subcategory->id . '">' . $subcategory->title . '</option>';
        return response()->json(['res' => 'success', 'count' => count($subcategories), 'data' => $html,]);
    }
}
