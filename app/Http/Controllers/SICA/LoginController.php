<?php

namespace App\Http\Controllers\SICA;

use App\Http\Controllers\Controller;
use App\Models\Schools;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display a form of the login.
     */
    public function login(): View
    {
        return view('sica.login');
    }

    /**
     * Check Login credentials.
     */
    public function checkLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if (Auth::guard('sica')->attempt($credentials) ) {

            return redirect()->intended('sica/dashboard'); // Change to your desired redirect route
        }else{

            return back()->withErrors(['email' => 'Invalid Email or Password']);
        }
    }

    /**
     * Display a form of the login.
     */
    public function logout()
    {
        Auth::guard('sica')->logout();

        return redirect()->intended('/sica/login'); // Change to your desired redirect route
    }
}
