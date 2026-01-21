<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Models\CartTemp;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // $old_session_id = session()->getId();

        if (Auth::attempt($credentials)) {
            $user = \App\Models\User::where('email', $credentials['email'])->first();
            if ($user->status !== 1) {
                Auth::logout();
                $message = 'Your account is not active.';
                if ($user->status === 0) {
                    $message = 'Your account is currently inactive. Please contact support.';
                }

                return back()->withErrors([
                    'email' => $message,
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            // \Helper::session_update($old_session_id);
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
