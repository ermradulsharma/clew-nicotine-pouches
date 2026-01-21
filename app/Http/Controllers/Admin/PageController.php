<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PageController extends Controller
{
    protected $redirectTo = '/admin/login';

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Page $page)
    {
        $page = (new Page)->newQuery();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $page->where(function ($query) use ($searchKey) {
                $query->where('title', 'LIKE', '%' . $searchKey . '%')->orWhere('pageTitle', 'LIKE', '%' . $searchKey . '%')->orWhere('pageDescription', 'LIKE', '%' . $searchKey . '%')->orWhere('pageKeywords', 'LIKE', '%' . $searchKey . '%');
            });
        }
        $all_data = $page->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.page.index', ['name' => 'Page', 'page' => 'View', 'all_data' => $all_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page.add', ['name' => 'Page', 'page' => 'Add']);
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
            'title' => 'required|max:255|unique:pages,title',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,bmp|max:2048',
            'pageTitle' => 'required|string',
            'pageDescription' => 'required|string',
            'pageKeywords' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->errors()]);
        }
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = now()->timestamp . '-' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/page', $imageName);
        }
        $page = new Page();
        $page->title = $request->title;
        $page->image = $imageName;
        $page->pageTitle = $request->pageTitle;
        $page->pageDescription = $request->pageDescription;
        $page->pageKeywords = $request->pageKeywords;
        $page->content = $request->content;
        $page->slug = Str::slug($request->title);
        $page->created_by = auth()->id();
        if ($page->save()) {
            return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.']);
        }
        return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('admin.page.edit', ['name' => 'Page', 'page' => 'Edit', 'data' => $page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:pages,title,' . $page->id,
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,bmp|max:2048',
            'pageTitle' => 'required|string',
            'pageDescription' => 'required|string',
            'pageKeywords' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        }
        if ($request->hasFile('image')) {
            $image = now()->timestamp . "-" . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/page', $image);
            // Storage::delete('public/page/' . $page->image);
            $page->image = $image;
        }
        $page->title = $request->title;
        $page->pageTitle = $request->pageTitle;
        $page->pageDescription = $request->pageDescription;
        $page->pageKeywords = $request->pageKeywords;
        $page->content = $request->content;
        $page->updated_by = auth()->id();
        if ($page->save()) {
            return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => route('admin.page.index')]);
        }
        return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page = Page::find($page->id);
        $page->delete();
    }
}
