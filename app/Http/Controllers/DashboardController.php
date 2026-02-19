<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;

use App\Models\EvaluationDB\QCEsemester;

class DashboardController extends Controller
{
    public function index()
    {
        $currsem = QCEsemester::select('id', 'qceschlyear', 'qceratingfrom', 'qceratingto')
            ->orderBy('id', 'DESC')
            ->get();
            
        return view('home.dashboard', compact('currsem'));
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
