<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class PageBannerController extends Controller
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
    public function index(Request $request, $page_id)
    {
        $parent = Page::find($page_id);
        $banners = PageBanner::where('page_id', $page_id)->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.page.banners.index', ['name' => 'Page Banners', 'page' => 'View', 'parent' => $parent, 'all_data' => $banners]);
    }

    public function create($page_id)
    {
        return view('admin.page.banners.addModal', ['name' => 'Page Banners', 'page' => 'Add', 'page_id' => $page_id]);
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
            'page_id' => 'required|numeric',
            'title' => 'required|max:255',
            'mobile' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048',
            'desktop' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $mobile = now()->timestamp . "-" . $request->file('mobile')->getClientOriginalName();
            $request->file('mobile')->storeAs('public/page/banner', $mobile);

            $desktop = now()->timestamp . "-" . $request->file('desktop')->getClientOriginalName();
            $request->file('desktop')->storeAs('public/page/banner', $desktop);

            $data = new PageBanner;
            $data->page_id = $request->page_id;
            $data->title = $request->title;
            $data->mobile = $mobile;
            $data->desktop = $desktop;
            $data->position = PageBanner::where('page_id', $request->page_id)->max('position') + 1;
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
     * @param  \App\PageBanner  $pageBanner
     * @return \Illuminate\Http\Response
     */
    public function edit($page_id, $id)
    {
        $pageBanner = PageBanner::find($id);
        return view('admin.page.banners.editModal', ['name' => 'Page Banners', 'page' => 'Edit', 'data' => $pageBanner]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PageBanner  $pageBanner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PageBanner $pageBanner)
    {
        $validator = \Validator::make($request->all(), [
            'page_id' => 'required|numeric',
            'title' => 'required|max:255',
            'mobile' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048',
            'desktop' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = PageBanner::find($request->id);
            if ($request->hasFile('mobile')) {
                $mobile = now()->timestamp . "-" . $request->file('mobile')->getClientOriginalName();
                $request->file('mobile')->storeAs('public/page/banner', $mobile);
            } else
                $mobile = $data->mobile;

            if ($request->hasFile('desktop')) {
                $desktop = now()->timestamp . "-" . $request->file('desktop')->getClientOriginalName();
                $request->file('desktop')->storeAs('public/page/banner', $desktop);
            } else
                $desktop = $data->desktop;

            $data->title = $request->title;
            $data->mobile = $mobile;
            $data->desktop = $desktop;
            $data->updated_by = auth()->user()->id;
            if ($data->save())
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.']);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PageBanner  $pageBanner
     * @return \Illuminate\Http\Response
     */
    public function destroy(PageBanner $pageBanner)
    {
        $pageBanner = PageBanner::find($pageBanner->id);
        $pageBanner->delete();
    }
}
