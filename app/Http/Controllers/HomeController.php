<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Banner;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\NewsletterSubscription;
use App\Models\Page;
use App\Models\PressRelease;
use App\Models\Process;
use App\Models\Product;
use App\Models\Promise;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
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
        $banners = Banner::where('status', 1)->orderBy('position', 'asc')->get();
        $promises = Promise::where('status', 1)->orderBy('position', 'asc')->get();
        $products = Product::where('featured', 1)->where('status', 1)->orderBy('position', 'asc')->get();
        $processes = Process::where('status', 1)->orderBy('position', 'asc')->get();

        return view('public.home', ['banners' => $banners, 'promises' => $promises, 'products' => $products, 'processes' => $processes]);
    }

    public function about()
    {
        $about = About::find(1);
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'About Clew'],
        ];
        return view('public.about', ['about' => $about, 'breadcrumbs' => $breadcrumbs]);
    }

    public function faqs()
    {
        $page = Page::with('Banners')->where('slug', 'frequently-asked-questions')->first();
        if (!$page) {
            abort(404, 'Frequently Asked Questions page not found.');
        }
        $faqs = Faq::get();
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Frequently Asked Questions'],
        ];
        return view('public.faq', ['faqs' => $faqs, 'page' => $page, 'breadcrumbs' => $breadcrumbs]);
    }

    public function shippingDelivery()
    {
        $page = Page::with('Banners')->where('slug', 'shipping-delivery')->whereNotNull('content')->first();
        if (!$page) {
            abort(404, 'Shipping & Delivery page not found.');
        }
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Shipping & Delivery'],
        ];
        return view('public.pages', ['page' => $page, 'breadcrumbs' => $breadcrumbs]);
    }

    public function returns()
    {
        $page = Page::with('Banners')->where('slug', 'returns')->whereNotNull('content')->first();
        if (!$page) {
            abort(404, 'Returns page not found.');
        }
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Returns'],
        ];
        return view('public.pages', ['page' => $page, 'breadcrumbs' => $breadcrumbs]);
    }

    public function privacyPolicy()
    {
        $page = Page::with('Banners')->where('slug', 'privacy-policy')->whereNotNull('content')->first();
        if (!$page) {
            abort(404, 'Privacy Policy page not found.');
        }
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Returns'],
        ];
        return view('public.pages', ['page' => $page, 'breadcrumbs' => $breadcrumbs]);
    }

    public function termsCondition()
    {
        $page = Page::with('Banners')->where('slug', 'terms-condition')->whereNotNull('content')->first();
        if (!$page) {
            abort(404, 'Terms & Conditions page not found.');
        }
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Returns'],
        ];
        return view('public.pages', ['page' => $page, 'breadcrumbs' => $breadcrumbs]);
    }

    public function contact()
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Contact Us'],
        ];
        return view('public.contact', ['breadcrumbs' => $breadcrumbs]);
    }

    public function blogs()
    {
        return view('public.blogs');
    }

    public function blogDetails()
    {
        return view('public.blogDetails');
    }

    public function pressRelease()
    {
        $pressReleases = PressRelease::where('status', 1)->orderBy('position', 'asc')->get();
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Clew Press Release'],
        ];
        return view('public.press-release', ['pressReleases' => $pressReleases, 'breadcrumbs' => $breadcrumbs]);
    }

    public function contactSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'enquiry_type' => 'required|max:255',
            'email' => 'required|email|max:255',
            'country_code' => 'required|max:255',
            'phone_no' => 'required|numeric|digits:10',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = new Contact();
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->name = $request->first_name . ' ' . $request->last_name;
            $data->enquiry_type = $request->enquiry_type;
            $data->email = $request->email;
            $data->country_code = $request->country_code;
            $data->phone_no = $request->phone_no;
            $data->message = $request->message;
            if ($data->save()) {
                $userData = ['name' => $request->name, 'enquiry_type' => $request->enquiry_type, 'email' => $request->email, 'country_code' => $request->country_code, 'phone_no' => $request->phone_no, 'message' => $request->message];
                return response()->json(['res' => 'success', 'msg' => 'Your message submited successfully.']);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function newsletterSubscriptionSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_address' => 'required|email|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['res' => 'invalid', 'msg' => $validator->messages()]);
        } else {
            $data = new NewsletterSubscription();
            $data->email = $request->email_address;
            if ($data->save()) {
                $userData = ['email' => $request->email];
                return response()->json(['res' => 'success', 'msg' => 'Newsletter subscribed successfully.']);
            } else
                return response()->json(['res' => 'error', 'msg' => 'Something wrong, try later.']);
        }
    }

    public function getStates(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->orderBy('title', 'asc')->get();
        $html = '<option value="">State*</option>';
        foreach ($states as $state)
            $html .= '<option value="' . $state->id . '">' . $state->title . '</option>';
        return $html;
    }
}
