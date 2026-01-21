<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\GetInTouch;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class EnquiryController extends Controller
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
    public function contact(Request $request, Contact $contact)
    {
        $data = (new Contact)->newQuery();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $data->where(function ($query) use ($searchKey) {
                $query->where('name', 'LIKE', '%' . $searchKey . '%')->orWhere('email', 'LIKE', '%' . $searchKey . '%')->orWhere('mobile', 'LIKE', '%' . $searchKey . '%')->orWhere('message', 'LIKE', '%' . $searchKey . '%');
            });
        }
        $all_data = $data->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.enquiry.contact', ['name' => 'Contact Enquiries', 'page' => 'View', 'all_data' => $all_data]);
    }

    public function getInTouch(Request $request, getInTouch $getInTouch)
    {
        $data = (new GetInTouch)->newQuery();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $data->where(function ($query) use ($searchKey) {
                $query->where('name', 'LIKE', '%' . $searchKey . '%')->orWhere('message', 'LIKE', '%' . $searchKey . '%');
            });
        }
        $all_data = $data->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.enquiry.getInTouch', ['name' => 'Get In Touch Enquiries', 'page' => 'View', 'all_data' => $all_data]);
    }

    public function NewsletterSubscription(Request $request, NewsletterSubscription $newsletterSubscription)
    {
        $data = (new NewsletterSubscription)->newQuery();
        if ($request->filled('searchKey')) {
            $searchKey = $request->query('searchKey');
            $data->where('email', 'LIKE', '%' . $searchKey . '%');
        }
        $all_data = $data->orderBy($request->query('sort', 'id'), $request->query('direction', 'desc'))->paginate(50);
        return view('admin.enquiry.newsletterSubscription', ['name' => 'Newsletter Subscriptions', 'page' => 'View', 'all_data' => $all_data]);
    }
}
