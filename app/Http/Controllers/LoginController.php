<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function empstudlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:20',
        ]);

        $validatedUser = auth()->guard('web')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($validatedUser) {
            return redirect()->route('index.dashboard')->with('success', 'You have successfully logged in.');
        } 
        else {
            return redirect()->back()->with('error', 'Invalid Credentials');
        }
    }
}
