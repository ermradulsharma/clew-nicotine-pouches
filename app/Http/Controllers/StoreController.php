<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;


class StoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lng = -110.89031;
        $lat = 32.11889;
        $states = Store::select('state')->where('status', 1)->groupBy('state')->orderBy('state', 'asc')->get();
        $stores = Store::where('status', 1)->orderBy('name', 'asc')->get();
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Clew Store'],
        ];
        return view('public.stores', ['lng' => $lng, 'lat' => $lat, 'states' => $states, 'stores' => $stores, 'breadcrumbs' => $breadcrumbs]);
    }

    public function storeCities(Request $request)
    {
        $cities = Store::select('city')->where('state', $request->state)->where('status', 1)->groupBy('city')->orderBy('city', 'asc')->get();
        $html = '<option value="">City*</option>';
        foreach ($cities as $city)
            $html .= '<option value="' . $city->city . '">' . $city->city . '</option>';
        return $html;
    }

    public function storeSearch(Request $request)
    {
        $stores = (new Store)->newQuery();
        if ($request->filled('state')) {
            $stores->where('state', $request->state);
        }
        if ($request->filled('city')) {
            $stores->where('city', $request->city);
        }
        if ($request->filled('pincode')) {
            $stores->where('pincode', $request->pincode);
        }
        $stores = $stores->orderBy('name', 'asc')->get();
        return view('public.parts.storeSearch', ['stores' => $stores])->render();
    }

    public function storeLocations(Request $request)
    {
        $stores = (new Store)->newQuery();
        if ($request->filled('state')) {
            $stores->where('state', $request->state);
        }
        if ($request->filled('city')) {
            $stores->where('city', $request->city);
        }
        if ($request->filled('pincode')) {
            $stores->where('pincode', $request->pincode);
        }
        $stores = $stores->orderBy('name', 'asc')->get()->toArray();

        if (count($stores)) {
            // Fetch all results as an associative array
            $locations = [];

            foreach ($stores as $store) {
                $locations[] = $store;
            }

            // Output the data as JSON
            header('Content-Type: application/json');
            return json_encode($locations);
        }
        return "";
    }
}
