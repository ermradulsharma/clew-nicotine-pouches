<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcessController extends Controller
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
        $data = (new Process)->newQuery();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $data->where(function ($query) use ($searchKey) {
                $query->where('title', 'LIKE', '%' . $searchKey . '%')->orWhere('tagline', 'LIKE', '%' . $searchKey . '%')->orWhere('image', 'LIKE', '%' . $searchKey . '%');
            });
        }
        $all_data = $data->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.process.index', ['name' => 'Process', 'page' => 'View', 'all_data' => $all_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.process.add', ['name' => 'Process', 'page' => 'Add']);
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
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp|max:2048',
            'tagline' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $image = now()->timestamp . "-" . $request->file('image')->getClientOriginalName();
            if ($request->file('image')->storeAs('public/process', $image)) {
                $data = new Process;
                $data->title = $request->title;
                $data->image = $image;
                $data->tagline = $request->tagline;
                $data->position = Process::max('position') + 1;
                $data->status = 1;
                $data->created_by = auth()->user()->id;
                if ($data->save())
                    return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.']);
                else
                    return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Cannot upload image, try later.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function edit(Process $process)
    {
        return view('admin.process.edit', ['name' => 'Process', 'page' => 'Edit', 'data' => $process]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Process $process)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp|max:2048',
            'tagline' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            if ($request->hasFile('image')) {
                $image = now()->timestamp . "-" . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/process', $image);
            } else
                $image = $process->image;

            $data = Process::find($process->id);
            $data->title = $request->title;
            $data->image = $image;
            $data->tagline = $request->tagline;
            $data->updated_by = auth()->user()->id;
            if ($data->save())
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => '/admin/process']);
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
            $data = Process::find($request->id);
            $data->position = $request->position;
            if ($data->save()) {
                $position = 0;
                $all_data = Process::select('id')->where('id', '!=', $request->id)->orderBy('position', 'asc')->get();
                foreach ($all_data as $data) {
                    $position++;
                    if ($position == $request->position) $position++;
                    $dataUpdate = Process::find($data->id);
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
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function destroy(Process $process)
    {
        //
    }
}
