<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;
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

use App\Models\SettingDB\Campus;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $campus = $request->query('campus');
        $ratingperiod = $request->query('ratingperiod');
        $userCampus = Auth::guard('web')->user()->campus;

        $campuses = Campus::all();

        $currsem = QCEsemester::select('id', 'qceschlyear', 'qcesemester', 'qceratingfrom', 'qceratingto')
            ->where('qcesemstat', '2')
            ->orderBy('id', 'DESC')
            ->get();

        $currenrolled = StudEnrolmentHistory::whereIn('status', ['2', '3'])
            ->where('semester', $currsem->first()->qcesemester)
            ->where('schlyear', $currsem->first()->qceschlyear)
            ->where('campus', '=', $userCampus)
            ->where('studentID', 'NOT LIKE', '%-G%')
            ->count();

        $currfacultySched = SetClassSchedule::where('semester', '2')
            ->where('schlyear', '2025-2026')
            ->where('campus', 'MC')
            ->distinct('faculty_id')
            ->count('faculty_id');

        $currevalstat = QCEsetting::first();

        $ratescale = QCEratingscale::where('instratingscalestat', '=', '1')->get();

        $ratecollege = College::whereIn('id', [2, 3, 4, 5, 6, 7, 8])->orderBy('college_name', 'ASC')->get()->keyBy('college_abbr');

        $schlyearactive = $currsem->first()->qceschlyear ?? null;
        $semesteractive = $currsem->first()->qcesemester ?? null;

        $cacheKeyPrefix = "dashboard_{$userCampus}_{$schlyearactive}_{$semesteractive}_";

        $collegesFirstSemester = Cache::remember($cacheKeyPrefix . 'currentcolleges', 1000, function () use ($userCampus, $schlyearactive, $semesteractive) {
            return College::join('coasv2_db_enrollment.program_en_history', function ($join) {
                    $join->on(DB::raw("SUBSTRING_INDEX(coasv2_db_enrollment.program_en_history.progCod, '-', 1)"), '=', 'college.college_abbr');
                })
                ->whereIn('college.id', [2, 3, 4, 5, 6, 7, 8])
                ->where(function ($query) use ($userCampus) {
                    $campuses = explode(', ', $userCampus);
                    foreach ($campuses as $userCampus) {
                        $query->orWhere('college.campus', 'LIKE', '%' . $userCampus . '%');
                    }
                })
                ->where('coasv2_db_enrollment.program_en_history.semester', $semesteractive)
                ->where('coasv2_db_enrollment.program_en_history.schlyear', $schlyearactive)
                ->where('coasv2_db_enrollment.program_en_history.campus', $userCampus)
                ->whereIn('coasv2_db_enrollment.program_en_history.status', [2, 3])
                ->select(
                    'college.college_abbr',
                    'college.colcolor',
                    DB::raw('COUNT(DISTINCT coasv2_db_enrollment.program_en_history.studentID) as college_count')
                )
                ->groupBy('college.id', 'college.college_abbr', 'college.colcolor')
                ->orderBy('college_name', 'ASC')
                ->get();
        });

        $collegelabels = $collegesFirstSemester->pluck('college_abbr');
        $collegedata = $collegesFirstSemester->pluck('college_count');
        $collegecolors = $collegesFirstSemester->pluck('colcolor');

        $labels = [];
        $data = [];
        $colors = [];
        foreach ($ratecollege as $college) {
            $labels[] = $college->college_abbr;

            $count = QCEfevalrate::where('prog', $college->college_abbr)
                ->where('semester', '2')
                ->where('schlyear', '2025-2026')
                ->where('campus', $userCampus)
                ->count();

            $data[] = $count;
            $colors[] = $college->colcolor ?? '#4e73df';
        }

        $currresponses = QCEfevalrate::where('semester', $currsem->first()->qcesemester)
            ->where('schlyear', $currsem->first()->qceschlyear)
            ->where('campus', '=', $userCampus)
            ->count();
        
        
            
        return view('home.dashboard', compact(
                            'campuses',
                            'currsem',
                            'currenrolled', 
                            'currfacultySched', 
                            'currevalstat',
                            'ratescale', 
                            'ratecollege', 
                            'collegelabels', 
                            'collegedata', 
                            'collegecolors', 
                            'labels',  
                            'data', 
                            'colors', 
                            'currresponses', 
                        ));
    }

    public function filter(Request $request)
    {
        $campus = $request->campus;
        $ratingperiod = $request->ratingperiod;

        $currsem = QCEsemester::find($ratingperiod);

        if (!$currsem) {
            return response()->json(['error' => 'Invalid rating period'], 400);
        }

        $semester = $currsem->qcesemester;
        $schlyear = $currsem->qceschlyear;

        // TOTAL STUDENTS
        $currenrolled = StudEnrolmentHistory::whereIn('status', ['2', '3'])
            ->where('semester', $semester)
            ->where('schlyear', $schlyear)
            ->where('campus', $campus)
            ->where('studentID', 'NOT LIKE', '%-G%')
            ->count();

        // TOTAL FACULTY
        $currfacultySched = SetClassSchedule::where('semester', $semester)
            ->where('schlyear', $schlyear)
            ->where('campus', $campus)
            ->distinct('faculty_id')
            ->count('faculty_id');

        // TOTAL RESPONSES
        $currresponses = QCEfevalrate::where('semester', $semester)
            ->where('schlyear', $schlyear)
            ->where('campus', $campus)
            ->count();

        // BAR CHART DATA
        $ratecollege = College::whereIn('id', [2,3,4,5,6,7,8])
            ->orderBy('college_name', 'ASC')
            ->get();

        $schlyearactive = $currsem->first()->qceschlyear ?? null;
        $semesteractive = $currsem->first()->qcesemester ?? null;

        $cacheKeyPrefix = "dashboard_{$campus}_{$schlyearactive}_{$semesteractive}_";

        $collegesFirstSemester = Cache::remember($cacheKeyPrefix . 'currentcolleges', 1000, function () use ($campus, $schlyearactive, $semesteractive) {
            return College::join('coasv2_db_enrollment.program_en_history', function ($join) {
                    $join->on(DB::raw("SUBSTRING_INDEX(coasv2_db_enrollment.program_en_history.progCod, '-', 1)"), '=', 'college.college_abbr');
                })
                ->whereIn('college.id', [2, 3, 4, 5, 6, 7, 8])
                ->where(function ($query) use ($campus) {
                    $campuses = explode(', ', $campus);
                    foreach ($campuses as $campus) {
                        $query->orWhere('college.campus', 'LIKE', '%' . $campus . '%');
                    }
                })
                ->where('coasv2_db_enrollment.program_en_history.semester', $semesteractive)
                ->where('coasv2_db_enrollment.program_en_history.schlyear', $schlyearactive)
                ->where('coasv2_db_enrollment.program_en_history.campus', $campus)
                ->whereIn('coasv2_db_enrollment.program_en_history.status', [2, 3])
                ->select(
                    'college.college_abbr',
                    'college.colcolor',
                    DB::raw('COUNT(DISTINCT coasv2_db_enrollment.program_en_history.studentID) as college_count')
                )
                ->groupBy('college.id', 'college.college_abbr', 'college.colcolor')
                ->orderBy('college_name', 'ASC')
                ->get();
        });

        $collegelabels = $collegesFirstSemester->pluck('college_abbr');
        $collegedata = $collegesFirstSemester->pluck('college_count');
        $collegecolors = $collegesFirstSemester->pluck('colcolor');

        $labels = [];
        $data = [];
        $colors = [];

        foreach ($ratecollege as $college) {
            $labels[] = $college->college_abbr;

            $count = QCEfevalrate::where('prog', $college->college_abbr)
                ->where('semester', $semester)
                ->where('schlyear', $schlyear)
                ->where('campus', $campus)
                ->count();

            $data[] = $count;
            $colors[] = $college->colcolor ?? '#4e73df';
        }

        return response()->json([
            'currenrolled' => $currenrolled,
            'currfacultySched' => $currfacultySched,
            'currresponses' => $currresponses,
            'collegelabels' => $collegelabels,
            'collegedata' => $collegedata,
            'collegecolors' => $collegecolors,
            'labels' => $labels,
            'data' => $data,
            'colors' => $colors
        ]);
    }

    public function getevalresponse() 
    {
        $currsem = QCEsemester::select('id', 'qceschlyear', 'qcesemester', 'qceratingfrom', 'qceratingto')
            ->where('qcesemstat', '2')
            ->orderBy('id', 'DESC')
            ->get();

        $currcollegesresponses = QCEfevalrate::where('semester', $currsem->first()->qcesemester)
            ->where('schlyear', $currsem->first()->qceschlyear)
            ->where('campus', '=', 'MC')
            ->get();
        
        $studentIds = $currcollegesresponses->pluck('studidno')->unique();

        $enrolments = StudEnrolmentHistory::whereIn('studentID', $studentIds)
            ->whereIn('status', ['2', '3'])
            ->where('semester', $currsem->first()->qcesemester)
            ->where('schlyear', $currsem->first()->qceschlyear)
            ->where('campus', 'MC')
            ->get()
            ->keyBy('studentID');

        $merged = $currcollegesresponses->map(function ($item) use ($enrolments) {
            $enrol = $enrolments->get($item->studidno);
            if ($enrol) {
                $item->progCod = $enrol->progCod; 
                $item->progCod = explode('-', $enrol->progCod)[0];
                $item->program = $enrol->course; 
            } else {
                $item->program = 'UNKNOWN';
            }

            return $item;
        });

        $data = $merged->groupBy('program')->map(function ($group) {
            return [
                'progCod' => $group->first()->progCod,
                'program' => $group->first()->program,
                'count'   => $group->count(),
            ];
        })->values();

        return response()->json(['data' => $data]);
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
