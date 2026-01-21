<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
    public function index(Request $request, Category $category)
    {
        $category = (new Category)->newQuery();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $category->where(function ($query) use ($searchKey) {
                $query->where('title', 'LIKE', '%' . $searchKey . '%')->orWhere('tagline', 'LIKE', '%' . $searchKey . '%')->orWhere('description', 'LIKE', '%' . $searchKey . '%')->orWhere('pageTitle', 'LIKE', '%' . $searchKey . '%')->orWhere('pageDescription', 'LIKE', '%' . $searchKey . '%')->orWhere('pageKeywords', 'LIKE', '%' . $searchKey . '%');
            });
        }
        $all_data = $category->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.category.index', ['name' => 'Category', 'page' => 'View', 'all_data' => $all_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.add', ['name' => 'Category', 'page' => 'Add']);
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
            'title' => 'required|max:255|unique:categories',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $image = now()->timestamp . "-" . $request->file('image')->getClientOriginalName();
            if ($request->file('image')->storeAs('public/category', $image)) {
                $data = new Category;
                $data->title = $request->title;
                $data->tagline = $request->tagline;
                $data->description = $request->description;
                $data->image = $image;
                $data->pageTitle = $request->pageTitle;
                $data->pageDescription = $request->pageDescription;
                $data->pageKeywords = $request->pageKeywords;
                $data->slug = Str::slug($request->title, '-');
                $data->position = Category::max('position') + 1;
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', ['name' => 'Category', 'page' => 'Edit', 'data' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|max:255|unique:categories,title,' . $category->id,
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,bmp|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = Category::find($category->id);

            if ($request->hasFile('image')) {
                $image = now()->timestamp . "-" . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/category', $image);
            } else
                $image = $data->image;

            $data->title = $request->title;
            $data->tagline = $request->tagline;
            $data->description = $request->description;
            $data->image = $image;
            $data->pageTitle = $request->pageTitle;
            $data->pageDescription = $request->pageDescription;
            $data->pageKeywords = $request->pageKeywords;
            $data->slug = Str::slug($request->title, '-');
            $data->updated_by = auth()->user()->id;
            if ($data->save())
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => route('admin.category.index')]);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category = Category::find($category->id);
        $category->delete();
    }
}
