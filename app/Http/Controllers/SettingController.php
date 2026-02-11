<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\EvaluationDB\QCEsetting;

class SettingController extends Controller
{
    public function index()
    {
        $setevalmode = QCEsetting::first();

        return view('manage.starteval', compact('setevalmode'));
    }

    public function toggleEval(Request $request)
    {
        $request->validate([
            'statuseval' => 'required', 
        ]);

        $setvalMode = QCEsetting::firstOrCreate([], ['statuseval' => 'Off']);

        $setvalMode->statuseval = $request->statuseval ? 'On' : 'Off';
        $setvalMode->save();

        return response()->json([
            'success' => true,
            'message' => $setvalMode->statuseval === 'On' 
                ? ' is now Open.' 
                : ' is Turn Off.',
        ]);
    }
}
