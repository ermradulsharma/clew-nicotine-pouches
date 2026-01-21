<?php

namespace App\Http\Controllers\Admin;

use App\Models\Website;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WebsiteController extends Controller
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
        return view('admin.website.index', ['name' => 'Website', 'page' => 'View', 'data' => Website::find(1)]);
    }

    public function edit(Website $website)
    {
        return view('admin.website.edit', ['name' => 'Website', 'page' => 'Edit', 'data' => $website]);
    }

    public function update(Request $request, Website $website)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|max:255',
            'logo' => 'sometimes|required|image|mimes:jpeg,png,jpg,bmp|max:2048',
            'favicon' => 'sometimes|required|mimes:ico,png|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $website = Website::find($website->id);
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo')->getClientOriginalName();
                if (!$request->file('logo')->storeAs('public/website', $logo)) $logo = $website->logo;
            } else $logo = $website->logo;

            if ($request->hasFile('favicon')) {
                $favicon = $request->file('favicon')->getClientOriginalName();
                if (!$request->file('favicon')->storeAs('public/website', $favicon)) $favicon = $website->favicon;
            } else $favicon = $website->favicon;

            $website->title = $request->title;
            $website->logo = $logo;
            $website->favicon = $favicon;
            $website->disclaimer = $request->disclaimer;
            $website->pageTitle = $request->pageTitle;
            $website->pageDescription = $request->pageDescription;
            $website->pageKeywords = $request->pageKeywords;
            $website->updated_by = auth()->user()->id;
            if ($website->save())
                return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => route('admin.website.index')]);
            else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }
}
