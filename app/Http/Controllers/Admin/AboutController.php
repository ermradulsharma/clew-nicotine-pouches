<?php

namespace App\Http\Controllers\Admin;

use App\Models\About;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AboutController extends Controller
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
        $about = About::find(1);
        return view('admin.about.index', ['name' => 'About Us', 'page' => 'View', 'data' => $about]);
    }

    public function edit(About $about)
    {
        return view('admin.about.edit', ['name' => 'About Us', 'page' => 'Edit', 'data' => $about]);
    }

    public function update(Request $request, About $about)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,bmp|max:2048',
            'description' => 'required',

            'om_title' => 'required|max:255',
            'om_image' => 'sometimes|image|mimes:jpeg,png,jpg,bmp|max:2048',
            'om_description' => 'required',

            'ov_title' => 'required|max:255',
            'ov_image' => 'sometimes|image|mimes:jpeg,png,jpg,bmp|max:2048',
            'ov_description' => 'required',

            'qa_title' => 'required|max:255',
            'qa_image' => 'sometimes|image|mimes:jpeg,png,jpg,bmp|max:2048',
            'qa_description' => 'required',

            'ni_title' => 'required|max:255',
            'ni_image' => 'sometimes|image|mimes:jpeg,png,jpg,bmp|max:2048',
            'ni_description' => 'required',

            'm_title' => 'required|max:255',
            'm_image' => 'sometimes|image|mimes:jpeg,png,jpg,bmp|max:2048',
            'm_video' => 'required|max:255',
            'm_description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->errors()]);
        }
        // Handle image uploads
        $about->image = $this->handleImageUpload($request, 'image', $about->image);
        $about->om_image = $this->handleImageUpload($request, 'om_image', $about->om_image);
        $about->ov_image = $this->handleImageUpload($request, 'ov_image', $about->ov_image);
        $about->qa_image = $this->handleImageUpload($request, 'qa_image', $about->qa_image);
        $about->ni_image = $this->handleImageUpload($request, 'ni_image', $about->ni_image);
        $about->m_image = $this->handleImageUpload($request, 'm_image', $about->m_image);

        // Assign text fields
        $about->title = $request->title;
        $about->description = $request->description;

        $about->om_title = $request->om_title;
        $about->om_description = $request->om_description;

        $about->ov_title = $request->ov_title;
        $about->ov_description = $request->ov_description;

        $about->qa_title = $request->qa_title;
        $about->qa_description = $request->qa_description;

        $about->ni_title = $request->ni_title;
        $about->ni_description = $request->ni_description;

        $about->m_title = $request->m_title;
        $about->m_video = $request->m_video;
        $about->m_description = $request->m_description;

        $about->updated_by = auth()->id();

        if ($about->save()) {
            return response()->json(['res' => 'success', 'msg' => 'Data saved successfully.', 'url' => route('admin.about.index')]);
        }
        return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
    }

    private function handleImageUpload(Request $request, $fieldName, $currentImage)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $filename = now()->timestamp . '-' . $file->getClientOriginalName();
            if ($file->storeAs('public/about', $filename)) {
                return $filename;
            }
        }
        return $currentImage;
    }
}
