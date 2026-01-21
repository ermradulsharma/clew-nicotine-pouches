<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
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
        $query = Banner::query();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $query->where(function ($q) use ($searchKey) {
                $q->where('title', 'LIKE', '%' . $searchKey . '%')
                    ->orWhere('redirect_url', 'LIKE', '%' . $searchKey . '%');
            });
        }
        $allowedSorts = ['id', 'title', 'created_at'];
        $sort = in_array($request->query('sort'), $allowedSorts) ? $request->query('sort') : 'id';
        $direction = in_array($request->query('direction'), ['asc', 'desc']) ? $request->query('direction') : 'desc';
        $banners = $query->orderBy($sort, $direction)->paginate(50);
        return view('admin.banner.index', [
            'name' => 'Banner',
            'page' => 'View',
            'all_data' => $banners,
            'searchKey' => $request->searchKey,
            'sort' => $sort,
            'direction' => $direction
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.add', ['name' => 'banner', 'page' => 'Add']);
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
            'title' => 'required|max:255',
            'bannerType' => 'required|string',
            'thumb' => 'sometimes|image|mimes:jpeg,png,jpg,gif,bmp|max:2048',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,bmp|max:2048',
            'poster' => 'sometimes|image|mimes:jpeg,png,jpg,gif,bmp|max:2048',
            'video' => 'sometimes|mimes:mp4|max:51200', // 50MB max video
            'redirect_url' => 'nullable|url',
            'redirect_target' => 'nullable|in:_blank,_self'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'res' => 'invalid',
                'msg' => $validator->errors()
            ]);
        }
        $thumb = $this->uploadFile($request, 'thumb', 'banner');
        $image = $this->uploadFile($request, 'image', 'banner');
        $poster = $this->uploadFile($request, 'poster', 'banner');
        $video = $this->uploadFile($request, 'video', 'banner');

        $banner = new Banner();
        $banner->title = $request->title;
        $banner->bannerType = $request->bannerType;
        $banner->thumb = $thumb;
        $banner->image = $image;
        $banner->poster = $poster;
        $banner->video = $video;
        $banner->redirect_url = $request->redirect_url;
        $banner->redirect_target = $request->redirect_target;
        $banner->position = Banner::max('position') + 1 ?? 1;
        $banner->status = 1;
        $banner->created_by = auth()->id();
        if ($banner->save()) {
            return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.']);
        }
        return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
    }

    private function uploadFile(Request $request, string $field, string $directory)
    {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $filename = now()->timestamp . '-' . $file->getClientOriginalName();
            $file->storeAs("public/{$directory}", $filename);
            return $filename;
        }
        return null;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', ['name' => 'banner', 'page' => 'Edit', 'data' => $banner]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'bannerType' => 'required|string',
            'thumb' => 'sometimes|image|mimes:jpeg,png,jpg,gif,bmp|max:2048',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,bmp|max:2048',
            'poster' => 'sometimes|image|mimes:jpeg,png,jpg,gif,bmp|max:2048',
            'video' => 'sometimes|mimes:mp4|max:51200', // up to 50MB
            'redirect_url' => 'nullable|url',
            'redirect_target' => 'nullable|in:_blank,_self',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->errors()]);
        }
        $banner->thumb = $this->uploadFile($request, 'thumb', 'banner', $banner->thumb);
        $banner->image = $this->uploadFile($request, 'image', 'banner', $banner->image);
        $banner->poster = $this->uploadFile($request, 'poster', 'banner', $banner->poster);
        $banner->video = $this->uploadFile($request, 'video', 'banner', $banner->video);
        $banner->title = $request->title;
        $banner->bannerType = $request->bannerType;
        $banner->redirect_url = $request->redirect_url;
        $banner->redirect_target = $request->redirect_target;
        $banner->updated_by = auth()->id();
        if ($banner->save()) {
            return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => '/admin/banner']);
        }
        return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        foreach (['thumb', 'image', 'poster', 'video'] as $field) {
            if ($banner->$field) {
                Storage::delete("public/banner/{$banner->$field}");
            }
        }
        $banner->delete();
        return response()->json(['res' => 'success', 'msg' => 'Banner deleted successfully.']);
    }
}
