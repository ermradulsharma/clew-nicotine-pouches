<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flavour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FlavourController extends Controller
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
    public function index(Request $request, Flavour $flavour)
    {
        $data = (new Flavour)->newQuery();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $data->where(function ($query) use ($searchKey) {
                $query->where('title', 'LIKE', '%' . $searchKey . '%');
            });
        }
        $all_data = $data->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.flavour.index', ['name' => 'Flavor', 'page' => 'View', 'all_data' => $all_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.flavour.add', ['name' => 'flavor', 'page' => 'Add']);
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
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = new Flavour;
            $data->title = $request->title;
            $data->position = Flavour::max('position') + 1;
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
     * @param  \App\Flavour  $flavour
     * @return \Illuminate\Http\Response
     */
    public function edit(Flavour $flavour)
    {
        return view('admin.flavour.edit', ['name' => 'flavor', 'page' => 'Edit', 'data' => $flavour]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Flavour  $flavour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flavour $flavour)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = Flavour::find($flavour->id);
            $data->title = $request->title;
            $data->updated_by = auth()->user()->id;
            if ($data->save())
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => '/admin/flavour']);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function position(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'id' => 'required|numeric',
                'position' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            return back()->with('error', 'Please enter position.');
        } else {
            $data = Flavour::find($request->id);
            $data->position = $request->position;
            if ($data->save()) {
                $position = 0;
                $all_data = Flavour::select('id')->where('id', '!=', $request->id)->orderBy('position', 'asc')->get();
                foreach ($all_data as $data) {
                    $position++;
                    if ($position == $request->position) $position++;
                    $dataUpdate = Flavour::find($data->id);
                    $dataUpdate->position = $position;
                    $dataUpdate->save();
                }
                return back()->with('success', 'Position saved successfully.');
            } else
                return back()->with('error', 'Something wrong, try later.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flavour  $flavour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flavour $flavour)
    {
        //
    }
}
