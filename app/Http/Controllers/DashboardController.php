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

use App\Models\EvaluationDB\QCEratingscale;
use App\Models\EvaluationDB\QCEcategory;
use App\Models\EvaluationDB\QCEquestion;
use App\Models\EvaluationDB\QCEsemester;
use App\Models\EvaluationDB\QCEfevalrate;
use App\Models\EvaluationDB\QCEsetting;

use App\Models\EnrollmentDB\StudEnrolmentHistory;

use App\Models\ScheduleDB\Faculty;
use App\Models\ScheduleDB\SetClassSchedule;
use App\Models\ScheduleDB\College;

class DashboardController extends Controller
{
    public function index()
    {
        $currsem = QCEsemester::select('id', 'qceschlyear', 'qcesemester', 'qceratingfrom', 'qceratingto')
            ->where('qcesemstat', '2')
            ->orderBy('id', 'DESC')
            ->get();

        $currenrolled = StudEnrolmentHistory::whereIn('status', ['2', '3'])
            ->where('semester', $currsem->first()->qcesemester)
            ->where('schlyear', $currsem->first()->qceschlyear)
            ->where('campus', '=', 'MC')
            ->count();

        $currfacultySched = SetClassSchedule::where('semester', '2')
            ->where('schlyear', '2025-2026')
            ->where('campus', 'MC')
            ->distinct('faculty_id')
            ->count('faculty_id');

        $ratescale = QCEratingscale::where('instratingscalestat', '=', '1')->get();

        $ratecollege = College::whereIn('id', [2, 3, 4, 5, 6, 7, 8])->orderBy('college_name', 'ASC')->get();

        $labels = [];
        $data = [];
        $colors = [];
        foreach ($ratecollege as $college) {
            $labels[] = $college->college_abbr;

            $count = QCEfevalrate::where('prog', $college->college_abbr)
                ->where('semester', '2')
                ->where('schlyear', '2025-2026')
                ->where('campus', 'MC')
                ->count();

            $data[] = $count;
            $colors[] = $college->colcolor ?? '#4e73df';
        }

        $currresponses = QCEfevalrate::where('semester', $currsem->first()->qcesemester)
                ->where('schlyear', $currsem->first()->qceschlyear)
                ->where('campus', '=', 'MC')
                ->count();

        $currevalstat = QCEsetting::first();
            
        return view('home.dashboard', compact('currsem', 'currenrolled', 'currfacultySched', 'ratescale', 'ratecollege', 'labels', 'data', 'colors', 'currresponses', 'currevalstat'));
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
