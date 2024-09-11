<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;

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
    protected $redirectTo = 'profile';

    public function login(Request $request)
    {
        $this->validateLogin($request);
        
        if ($this->attemptLogin($request)) {
            // Return the intended URL in the JSON response
            return response()->json([
                'status' => 'success',
                'redirect_url' => url()->previous() // or use intended() if you want to get the intended URL
            ]);
        }

        // Return error response for failed login attempt
        return $this->sendFailedLoginResponse($request);
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {

        if (url()->current() != url()->previous()) {
            session(['previous_url' => url()->previous()]);
        }

        return view('store.auth.login');
    }
}
