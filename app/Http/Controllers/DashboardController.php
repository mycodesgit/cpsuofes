<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('home.dashboard');
    }

    public function logout()
    {
        if (\Auth::guard('web')->check()) {
            auth()->guard('web')->logout();
            return redirect()->route('login')->with('success', 'You have been Successfully Logged Out');
        } else {
            return redirect()->route('home')->with('error', 'No authenticated user to log out');
        }
    }
}
