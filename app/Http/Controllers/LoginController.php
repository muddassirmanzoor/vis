<?php

namespace App\Http\Controllers;

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
    public function login()
    {
        if (Auth::check()) {
            // User is already logged in, redirect to 'show-map' route
            return redirect()->route('show-map');
        }
    
        return view('login');
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

       
        if (Auth::attempt($credentials) ) {
            $user = Auth::user();
           // dd($user);
           
            return redirect()->intended('/show-map'); // Change to your desired redirect route
        }else{
           
            return back()->withErrors(['email' => 'Invalid Email or Password']);
        }
    }

    /**
     * Display a form of the login.
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->intended('/'); // Change to your desired redirect route
    }
}
