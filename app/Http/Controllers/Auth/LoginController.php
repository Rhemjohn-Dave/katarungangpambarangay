<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect after login based on user role.
     */
    protected function redirectTo()
    {
        return route('dashboard');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override authenticated method to redirect by role.
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('dashboard');
    }
}
