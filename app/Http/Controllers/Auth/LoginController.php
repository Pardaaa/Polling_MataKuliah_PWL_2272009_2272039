<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Determine the redirect path based on the user's role.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return string
     */
    protected function authenticated(Request $request, $user)
    {
        // Determine user role and redirect accordingly
        if ($user->isAdmin()) {
            return redirect()->route('admin');
        } elseif ($user->isProdi()) {
            return redirect()->route('prodi');
        } elseif ($user->isMahasiswa()) {
            return redirect()->route('mahasiswa');
        }

        // Default redirect if user role is not recognized
        return redirect()->intended($this->redirectTo);
    }
}