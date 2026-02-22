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

use App\Models\EnrollmentDB\Grade;
use App\Models\EnrollmentDB\KioskUser;
use App\Models\EnrollmentDB\StudEnrolmentHistory;
use App\Models\EnrollmentDB\Student;

use App\Models\ScheduleDB\Addressee;
use App\Models\ScheduleDB\ClassEnroll;
use App\Models\ScheduleDB\ClassessSubjects;
use App\Models\ScheduleDB\College;
use App\Models\ScheduleDB\Department;
use App\Models\ScheduleDB\EnPrograms;
use App\Models\ScheduleDB\Faculty;
use App\Models\ScheduleDB\FacDesignation;
use App\Models\ScheduleDB\Subject;
use App\Models\ScheduleDB\SubjectOffered;

class ReportsPrintSumEvalresultController extends Controller
{
    public function index()
    {
        $currsem = QCEsemester::select('id', 'qceschlyear', 'qceratingfrom', 'qceratingto')
            ->where('id', '>=', 5)
            ->orderBy('id', 'DESC')
            ->get();
        
        $collegelist = College::whereIn('id', [2, 3, 4, 5, 6, 7, 8])->get();

        return view('reports.prntsummaryevalresult.evaluationsummaryprint', compact('currsem', 'collegelist'));
    }

    public function show(Request $request)
    {
        $currsem = QCEsemester::select('id', 'qceschlyear')
            ->whereIn('id', function($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('qceschlyearsem')
                    ->groupBy('qceschlyear');
            })
            ->orderBy('id', 'DESC')
            ->get();

        $ratingFrom = $request->query('ratingfrom');
        $ratingTo   = $request->query('ratingto');
        $rating_period = $ratingFrom . ' - ' . $ratingTo;

        $qcefacID = $request->query('faclty');

        $facdetail = Faculty::where('id', $qcefacID)
                ->select('faculty.*')
                ->get();

        return view('reports.prntsummaryevalresult.evaluationsummaryprintsearchresult', compact('currsem', 'facdetail', 'rating_period'));
    }

    public function getFacultycamp(Request $request)
    {
        $campus = $request->campus;
        $dept = $request->dept;

        $faclty = Faculty::join('addressee', 'faculty.adrID', '=', 'addressee.id')
            ->join('college', 'faculty.dept', '=', 'college.college_abbr')
            ->where('faculty.campus', $campus)
            ->when($dept, function ($query, $dept) {
                return $query->where('faculty.dept', $dept);
            })
            ->select('faculty.*', 'faculty.id as fctyid', 'faculty.campus as fcamp', 'college.*', 'addressee.*', 'addressee.id as adrid')
            ->orderBy('faculty.lname')
            ->get();

        return response()->json($faclty);
    }

    public function individualresultEvalPDF(Request $request)
    {
        $campus = $request->query('campus');
        $schlyear = $request->query('schlyear');
        $semester = $request->query('semester');
        $faclty = $request->query('faclty');
        $ratingFrom = $request->query('ratingfrom');
        $ratingTo   = $request->query('ratingto');
        $rating_period = $ratingFrom . ' - ' . $ratingTo;

        $fcs = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->get();

        $facRanck = DB::connection('schedule')->table('faculty')
            ->where('faculty.id', $faclty)
            ->get();
        
        $evaluationsStudent = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->where('qceevaluator', 'Student')
            ->get();

        $evaluationsStudComp = $evaluationsStudent->map(function ($row) {
            $answers = json_decode($row->question_rate, true);
            $totalScore = is_array($answers)
                ? array_sum($answers)
                : 0;
            $row->set_rating = ($totalScore / 75) * 100;
                return $row;
        });

        $facrated = $evaluationsStudComp
            ->groupBy('subjidrate')
            ->map(function ($rows) {

                $students = $rows->pluck('studidno')
                    ->unique()
                    ->count();

                $avgRating = $rows->avg('set_rating');

                return (object)[
                    'subjidrate'      => $rows->first()->subjidrate,
                    'noofstudents'    => $students,
                    'avgsetrating'    => $avgRating,
                    'weightedsetscore'=> $students * $avgRating,
                ];
            })
            ->values(); 
        
        foreach ($facrated as $row) {
            $row->weightedsetscore =
                $row->noofstudents * $row->avgsetrating;
        }

        $subjectIds = $facrated->pluck('subjidrate')->filter();

        $subjects = DB::connection('schedule')
            ->table('sub_offered')
            ->join('subjects', 'sub_offered.subCode', '=', 'subjects.sub_code')
            ->whereIn('sub_offered.id', $subjectIds)
            ->select(
                'sub_offered.id',
                'subjects.sub_name',
                'sub_offered.subSec'
            )
            ->get()
            ->keyBy('id');

        foreach ($facrated as $row) {
            $subject = $subjects->get($row->subjidrate);

            $row->sub_name = $subject->sub_name ?? 'N/A';
            $row->subSec   = $subject->subSec ?? 'N/A';
        }

        //$overallSefRating = 0; 
        $totalStudents = $facrated->sum('noofstudents');
        $totalWeightedScore = $facrated->sum('weightedsetscore');

        $overallSetRating = $totalStudents > 0
            ? $totalWeightedScore / $totalStudents
            : 0;

        $evaluationsSupervisor = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->where('qceevaluator', 'Supervisor')
            ->get();

        $evaluationsSupervisorComp = $evaluationsSupervisor->map(function ($row) {
            $answers = json_decode($row->question_rate, true);

            $totalScore = is_array($answers)
                ? array_sum($answers)
                : 0;

            $row->sef_rating = ($totalScore / 75) * 100;

            return $row;
        });

        $facratedSupervisor = $evaluationsSupervisorComp
            ->groupBy('subjidrate')
            ->map(function ($rows) {

                $supervisors = $rows->count();
                $avgRating = $rows->avg('sef_rating');

                return (object)[
                    'subjidrate'       => $rows->first()->subjidrate,
                    'noofsupervisor'   => $supervisors,
                    'avgsefrating'     => $avgRating,
                    'weightedsefscore' => $supervisors * $avgRating,
                ];
            })
            ->values();

        $totalSupervisor = $facratedSupervisor->sum('noofsupervisor');
        $totalSupervisorWeighted = $facratedSupervisor->sum('weightedsefscore');

        $overallSefRating = $totalSupervisor > 0
            ? $totalSupervisorWeighted / $totalSupervisor
            : 0;

        
        $data = [
            'fcs' => $fcs,
            'facrated' => $facrated,
            'evaluationsStudent' => $evaluationsStudent,
            'facratedSupervisor' => $facratedSupervisor,
            'evaluationsSupervisor' => $evaluationsSupervisor,
            'facRanck' => $facRanck,
            'rating_period' => $rating_period,
            'overallSetRating'  => $overallSetRating,
            'overallSefRating'  => $overallSefRating,
        ];

        $pdf = PDF::loadView('reports.prntsummaryevalresult.annexcindividualfacultyreportpdf', $data)->setPaper('Legal', 'portrait');
        return $pdf->stream();
    }

    public function facultyEvalDevAckPDF(Request $request)
    {
        $campus = $request->query('campus');
        $schlyear = $request->query('schlyear');
        $semester = $request->query('semester');
        $faclty = $request->query('faclty');
        $ratingFrom = $request->query('ratingfrom');
        $ratingTo   = $request->query('ratingto');
        $rating_period = $ratingFrom . ' - ' . $ratingTo;

        $fcs = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->get();

        $facRanck = DB::connection('schedule')->table('faculty')
            ->where('faculty.id', $faclty)
            ->get();
        
        $evaluationsStudent = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->where('qceevaluator', 'Student')
            ->get();

        $evaluationsStudComp = $evaluationsStudent->map(function ($row) {
            $answers = json_decode($row->question_rate, true);
            $totalScore = is_array($answers)
                ? array_sum($answers)
                : 0;
            $row->set_rating = ($totalScore / 75) * 100;
                return $row;
        });

        $facrated = $evaluationsStudComp
            ->groupBy('subjidrate')
            ->map(function ($rows) {

                $students = $rows->pluck('studidno')
                    ->unique()
                    ->count();

                $avgRating = $rows->avg('set_rating');

                return (object)[
                    'subjidrate'      => $rows->first()->subjidrate,
                    'noofstudents'    => $students,
                    'avgsetrating'    => $avgRating,
                    'weightedsetscore'=> $students * $avgRating,
                ];
            })
            ->values(); 
        
        foreach ($facrated as $row) {
            $row->weightedsetscore =
                $row->noofstudents * $row->avgsetrating;
        }

        $subjectIds = $facrated->pluck('subjidrate')->filter();

        $subjects = DB::connection('schedule')
            ->table('sub_offered')
            ->join('subjects', 'sub_offered.subCode', '=', 'subjects.sub_code')
            ->whereIn('sub_offered.id', $subjectIds)
            ->select(
                'sub_offered.id',
                'subjects.sub_name',
                'sub_offered.subSec'
            )
            ->get()
            ->keyBy('id');

        foreach ($facrated as $row) {
            $subject = $subjects->get($row->subjidrate);

            $row->sub_name = $subject->sub_name ?? 'N/A';
            $row->subSec   = $subject->subSec ?? 'N/A';
        }

        //$overallSefRating = 0; 
        $totalStudents = $facrated->sum('noofstudents');
        $totalWeightedScore = $facrated->sum('weightedsetscore');

        $overallSetRating = $totalStudents > 0
            ? $totalWeightedScore / $totalStudents
            : 0;

        $evaluationsSupervisor = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->where('qceevaluator', 'Supervisor')
            ->get();

        $evaluationsSupervisorComp = $evaluationsSupervisor->map(function ($row) {
            $answers = json_decode($row->question_rate, true);

            $totalScore = is_array($answers)
                ? array_sum($answers)
                : 0;

            $row->sef_rating = ($totalScore / 75) * 100;

            return $row;
        });

        $facratedSupervisor = $evaluationsSupervisorComp
            ->groupBy('subjidrate')
            ->map(function ($rows) {

                $supervisors = $rows->count();
                $avgRating = $rows->avg('sef_rating');

                return (object)[
                    'subjidrate'       => $rows->first()->subjidrate,
                    'noofsupervisor'   => $supervisors,
                    'avgsefrating'     => $avgRating,
                    'weightedsefscore' => $supervisors * $avgRating,
                ];
            })
            ->values();

        $totalSupervisor = $facratedSupervisor->sum('noofsupervisor');
        $totalSupervisorWeighted = $facratedSupervisor->sum('weightedsefscore');

        $overallSefRating = $totalSupervisor > 0
            ? $totalSupervisorWeighted / $totalSupervisor
            : 0;

        
        $data = [
            'fcs' => $fcs,
            'facrated' => $facrated,
            'evaluationsStudent' => $evaluationsStudent,
            'facratedSupervisor' => $facratedSupervisor,
            'evaluationsSupervisor' => $evaluationsSupervisor,
            'facRanck' => $facRanck,
            'rating_period' => $rating_period,
            'overallSetRating'  => $overallSetRating,
            'overallSefRating'  => $overallSefRating,
        ];

        $pdf = PDF::loadView('reports.prntsummaryevalresult.annexdindividualfacultyreportpdf', $data)->setPaper('Legal', 'portrait');
        return $pdf->stream();
    }
}
