<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\orderCart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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
    public function index(Request $request, User $user)
    {

        //dd($admin->toArray());

        $user = (new User)->newQuery();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $user->where(function ($query) use ($searchKey) {
                $query->where('fname', 'LIKE', '%' . $searchKey . '%')->orWhere('email', 'LIKE', '%' . $searchKey . '%')->orWhere('phoneno', 'LIKE', '%' . $searchKey . '%');
            });
        }

        $all_data = $user->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.user.index', ['name' => 'User', 'page' => 'View', 'all_data' => $all_data]);
    }

    public function userExport()
    {

        $columns = array('Name', 'Email iD', 'Created At');

        $fileName = 'Clew-Customer-' . now()->timestamp . '.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $orders = User::all();
        $callback = function () use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($orders as $order) {
                fputcsv($file, array($order->name, $order->email, date("d-m-Y", strtotime($order->created_at))));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
