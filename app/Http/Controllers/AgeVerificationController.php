<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AgeVerificationController extends Controller
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
        return view('public.ageRestriction');
    }

    public function store(Request $request)
    {
        $request->session()->put('age_verified', true);
        $redirectUrl = $request->session()->pull('url.intended', url('/'));
        return response()->json([
            'res' => 'success',
            'redirect_url' => $redirectUrl,
        ]);

        // $request->validate([
        //     'age' => 'required|numeric',
        // ]);

        // $age = $request->input('age');

        // if ($age >= 21) {
        //     // Store age verification status in session
        //     $request->session()->put('age_verified', true);
        //     return redirect()->intended('/');
        // }

        // // Store failed verification in session
        // $request->session()->put('age_verified', false);
    }
}
