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
            ->orderBy('id', 'DESC')
            ->get();
        
        $collegelist = College::whereIn('id', [2, 3, 4, 5, 6, 7, 8])->get();

        return view('reports.prntsummaryevalresult.evaluationsummaryprint', compact('currsem', 'collegelist'));
    }

    public function summaryEvalFilter(Request $request)
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

        $pdf = PDF::loadView('reports.prntsummaryevalresult.individualfacultyreportpdf', $data)->setPaper('Legal', 'portrait');
        return $pdf->stream();
    }

    public function gencommentsevalPDF(Request $request)
    {
        $campus = $request->query('campus');
        $schlyear = $request->query('schlyear');
        $semester = $request->query('semester');
        $faclty = $request->query('faclty');
        $ratingFrom = $request->query('ratingfrom');
        $ratingTo   = $request->query('ratingto');
        $rating_period = $ratingFrom . ' - ' . $ratingTo;

        $facsum = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->first();

        // if (!$facsum) {
        //     return response()->json(['error' => 'No record found'], 404);
        // }

        $studcomments = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->where('qceevaluator', 'Student')
            ->get();
        
        $supercomments = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->where('qceevaluator', 'Supervisor')
            ->get();

        $data = [
            'facsum' => $facsum,
            'studcomments' => $studcomments,
            'supercomments' => $supercomments,
            'rating_period' => $rating_period,
            'semester' => $semester,
            'facsum' => $facsum,
        ];

        $pdf = PDF::loadView('reports.formpdf.pdfComments', $data)->setPaper('Legal', 'portrait');
        return $pdf->stream();
    }

    public function genpointsevalPDF(Request $request)
    {
        $campus = $request->query('campus');
        $schlyear = $request->query('schlyear');
        $semester = $request->query('semester');
        $faclty = $request->query('faclty');

        $ratingFrom = $request->query('ratingfrom');
        $ratingTo   = $request->query('ratingto');
        $rating_period = $ratingFrom . ' - ' . $ratingTo;
        

        $facId = DB::connection('schedule')->table('faculty')
            ->where('id', $faclty)
            ->first();
                    
        $facDean = QCEfevalrate::where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->first();
        
        $facDesignateId = DB::connection('schedule')->table('fac_designation')
            ->join('college', 'fac_designation.facdept', '=', 'college.college_abbr')
            ->join('faculty', 'fac_designation.fac_id', '=', 'faculty.id')
            ->where('fac_designation.schlyear', $schlyear)
            ->where('fac_designation.semester', $semester)
            ->where('fac_designation.facdept', $facDean->prog)
            ->first();

        $facDesignateIdCampusAd = DB::connection('schedule')->table('fac_designation')
            ->join('college', 'fac_designation.facdept', '=', 'college.college_abbr')
            ->join('faculty', 'fac_designation.fac_id', '=', 'faculty.id')
            ->where('fac_designation.schlyear', $schlyear)
            ->where('fac_designation.semester', $semester)
            ->where('fac_designation.campus', $campus)
            ->first();

        $fcs = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->first(); // Use get() to handle multiple records

        // Fetch all evaluations where the evaluator role is 'Student'
        $facsum = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->where('qceevaluator', 'Student') // Ensure only Student responses are fetched
            ->get(); // Use get() to handle multiple records

        if ($facsum->isEmpty()) {
            return response()->json(['error' => 'No Student records found'], 404);
        }

        $facRanck = DB::connection('schedule')->table('faculty')
            ->where('faculty.id', $faclty)
            ->get();

        // Initialize an array to store students' data
        $students = [];

        // Define categories with corresponding question IDs
        $categories = [
            'Commitment' => [1, 2, 3, 4, 5],
            'Knowledge of Subject' => [8, 9, 10, 11, 12],
            'Teaching for Independent Learning' => [13, 14, 15, 16, 17],
            'Management of Learning' => [18, 19, 20, 21, 22],
        ];

        // Initialize category totals
        $category_totals = [
            'Commitment' => 0,
            'Knowledge of Subject' => 0,
            'Teaching for Independent Learning' => 0,
            'Management of Learning' => 0,
        ];

        // Loop through each student's evaluation record
        foreach ($facsum as $record) {
            $ratings = json_decode($record->question_rate, true); // Convert JSON to array
            $student_data = [
                'id' => $record->studidno, // Use `studidno` for student ID
            ];

            $total_score = 0;

            // Sum ratings per category for the student
            foreach ($categories as $category => $question_ids) {
                $category_sum = 0;
                foreach ($question_ids as $question_id) {
                    if (isset($ratings[$question_id])) {
                        $category_sum += $ratings[$question_id];
                    }
                }
                $student_data[$category] = $category_sum;
                $category_totals[$category] += $category_sum; // Add to totals
                $total_score += $category_sum;
            }

            $student_data['TOTAL'] = $total_score;
            $students[] = $student_data;
        }

        // Calculate the average for TOTAL row
        $num_students = count($students);
        if ($num_students > 0) {
            foreach ($category_totals as $category => $sum) {
                $category_totals[$category] = round($sum / $num_students, 2); // Get average
            }
        }

        $total_student_eval = array_sum($category_totals);

        // Fetch supervisor's evaluation (assuming role is 'Supervisor')
        $supervisor_record = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->where('qceevaluator', 'Supervisor') // Fetch supervisor role
            ->first();

        $supervisor = [
            'Commitment' => 0,
            'Knowledge of Subject' => 0,
            'Teaching for Independent Learning' => 0,
            'Management of Learning' => 0,
            'TOTAL' => 0,
        ];

        $supervisor_total = 0;

        if ($supervisor_record) {
            $ratings = json_decode($supervisor_record->question_rate, true);
            $supervisor_total = 0;
            foreach ($categories as $category => $question_ids) {
                $category_sum = 0;
                foreach ($question_ids as $question_id) {
                    if (isset($ratings[$question_id])) {
                        $category_sum += $ratings[$question_id];
                    }
                }
                $supervisor[$category] = $category_sum;
                $supervisor_total += $category_sum;
            }
            $supervisor['TOTAL'] = $supervisor_total;
        }

        session([
            'total_student_eval' => $total_student_eval,
            'supervisor_total' => $supervisor_total,
            'semester' => $semester,
        ]);

        // Pass data to view
        $data = [
            'fcs' => $fcs,
            'students' => $students,
            'category_totals' => $category_totals,
            'supervisor' => $supervisor,
            'total_student_eval' => $total_student_eval,
            'supervisor_total' => $supervisor_total,
            'facId' => $facId,
            'facDesignateId' => $facDesignateId,
            'facDesignateIdCampusAd' => $facDesignateIdCampusAd,
            'facRanck' => $facRanck,
            'rating_period' => $rating_period,
        ];

        $pdf = PDF::loadView('reports.formpdf.pdfPoints', $data)->setPaper('Legal', 'landscape');
        return $pdf->stream();
    }

    public function gensumsheetevalPDF(Request $request)
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
            ->first(); // Use get() to handle multiple records
        
        $facDean = QCEfevalrate::where('schlyear', $schlyear)
        ->where('semester', $semester)
        ->where('qcefacID', $faclty)
        ->first();
        
        $facDesignateId = DB::connection('schedule')->table('fac_designation')
            ->join('college', 'fac_designation.facdept', '=', 'college.college_abbr')
            ->join('faculty', 'fac_designation.fac_id', '=', 'faculty.id')
            ->where('fac_designation.schlyear', $schlyear)
            ->where('fac_designation.semester', $semester)
            ->where('fac_designation.facdept', $facDean->prog)
            ->first();

        $facDesignateIdCampusAd = DB::connection('schedule')->table('fac_designation')
            ->join('college', 'fac_designation.facdept', '=', 'college.college_abbr')
            ->join('faculty', 'fac_designation.fac_id', '=', 'faculty.id')
            ->where('fac_designation.schlyear', $schlyear)
            ->where('fac_designation.semester', $semester)
            ->where('fac_designation.campus', $campus)
            ->first();

        // Fetch all evaluations where the evaluator role is 'Student'
        $facsum = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->where('qceevaluator', 'Student') // Ensure only Student responses are fetched
            ->get(); // Use get() to handle multiple records

        if ($facsum->isEmpty()) {
            return response()->json(['error' => 'No Student records found'], 404);
        }

        // Initialize an array to store students' data
        $students = [];

        // Define categories with corresponding question IDs
        $categories = [
            'Commitment' => [1, 2, 3, 4, 5],
            'Knowledge of Subject' => [8, 9, 10, 11, 12],
            'Teaching for Independent Learning' => [13, 14, 15, 16, 17],
            'Management of Learning' => [18, 19, 20, 21, 22],
        ];

        // Initialize category totals
        $category_totals = [
            'Commitment' => 0,
            'Knowledge of Subject' => 0,
            'Teaching for Independent Learning' => 0,
            'Management of Learning' => 0,
        ];

        // Loop through each student's evaluation record
        foreach ($facsum as $record) {
            $ratings = json_decode($record->question_rate, true); // Convert JSON to array
            $student_data = [
                'id' => $record->ratecount, // Use `studidno` for student ID
            ];

            $total_score = 0;

            // Sum ratings per category for the student
            foreach ($categories as $category => $question_ids) {
                $category_sum = 0;
                foreach ($question_ids as $question_id) {
                    if (isset($ratings[$question_id])) {
                        $category_sum += $ratings[$question_id];
                    }
                }
                $student_data[$category] = $category_sum;
                $category_totals[$category] += $category_sum; // Add to totals
                $total_score += $category_sum;
            }

            $student_data['TOTAL'] = $total_score;
            $students[] = $student_data;
        }

        // Calculate the average for TOTAL row
        $num_students = count($students);
        if ($num_students > 0) {
            foreach ($category_totals as $category => $sum) {
                $category_totals[$category] = round($sum / $num_students, 2); // Get average
            }
        }

        // Fetch supervisor's evaluation (assuming role is 'Supervisor')
        $supervisor_record = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->where('qceevaluator', 'Supervisor') // Fetch supervisor role
            ->first();

        $supervisor = [
            'Commitment' => 0,
            'Knowledge of Subject' => 0,
            'Teaching for Independent Learning' => 0,
            'Management of Learning' => 0,
            'TOTAL' => 0,
        ];

        if ($supervisor_record) {
            $ratings = json_decode($supervisor_record->question_rate, true);
            $supervisor_total = 0;
            foreach ($categories as $category => $question_ids) {
                $category_sum = 0;
                foreach ($question_ids as $question_id) {
                    if (isset($ratings[$question_id])) {
                        $category_sum += $ratings[$question_id];
                    }
                }
                $supervisor[$category] = $category_sum;
                $supervisor_total += $category_sum;
            }
            $supervisor['TOTAL'] = $supervisor_total;
        }

        // Pass data to view
        $data = [
            'fcs' => $fcs,
            'students' => $students,
            'category_totals' => $category_totals,
            'supervisor' => $supervisor,
            'facDesignateId' => $facDesignateId,
            'facDesignateIdCampusAd' => $facDesignateIdCampusAd,
            'rating_period' => $rating_period,
        ];

        $pdf = PDF::loadView('reports.formpdf.pdfSumSheet', $data)->setPaper('Legal', 'portrait');
        return $pdf->stream();
    }

    public function gensumsheetevalPDFdecimal(Request $request)
    {
        $campus = $request->query('campus');
        $schlyear = $request->query('schlyear');
        $semester = $request->query('semester');
        $faclty = $request->query('faclty');

        $fcs = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->first(); // Use get() to handle multiple records
        
        $facDean = QCEfevalrate::where('schlyear', $schlyear)
        ->where('semester', $semester)
        ->where('qcefacID', $faclty)
        ->first();
        
        $facDesignateId = DB::connection('schedule')->table('fac_designation')
            ->join('college', 'fac_designation.facdept', '=', 'college.college_abbr')
            ->join('faculty', 'fac_designation.fac_id', '=', 'faculty.id')
            ->where('fac_designation.schlyear', $schlyear)
            ->where('fac_designation.semester', $semester)
            ->where('fac_designation.facdept', $facDean->prog)
            ->first();

        $facDesignateIdCampusAd = DB::connection('schedule')->table('fac_designation')
            ->join('college', 'fac_designation.facdept', '=', 'college.college_abbr')
            ->join('faculty', 'fac_designation.fac_id', '=', 'faculty.id')
            ->where('fac_designation.schlyear', $schlyear)
            ->where('fac_designation.semester', $semester)
            ->where('fac_designation.campus', $campus)
            ->first();

        // Fetch all evaluations where the evaluator role is 'Student'
        $facsum = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->where('qceevaluator', 'Student') // Ensure only Student responses are fetched
            ->get(); // Use get() to handle multiple records

        if ($facsum->isEmpty()) {
            return response()->json(['error' => 'No Student records found'], 404);
        }

        // Initialize an array to store students' data
        $students = [];

        // Define categories with corresponding question IDs
        $categories = [
            'Commitment' => [1, 2, 3, 4, 5],
            'Knowledge of Subject' => [8, 9, 10, 11, 12],
            'Teaching for Independent Learning' => [13, 14, 15, 16, 17],
            'Management of Learning' => [18, 19, 20, 21, 22],
        ];

        // Initialize category totals
        $category_totals = [
            'Commitment' => 0,
            'Knowledge of Subject' => 0,
            'Teaching for Independent Learning' => 0,
            'Management of Learning' => 0,
            'TOTAL' => 0,
        ];

        // Loop through each student's evaluation record
        foreach ($facsum as $record) {
            $ratings = json_decode($record->question_rate, true); // Convert JSON to array
            $student_data = [
                'id' => $record->ratecount, // Use `studidno` for student ID
            ];

            $total_score = 0;

            // Sum ratings per category for the student
            foreach ($categories as $category => $question_ids) {
                $category_sum = 0;
                foreach ($question_ids as $question_id) {
                    if (isset($ratings[$question_id])) {
                        $category_sum += $ratings[$question_id];
                    }
                }
                $student_data[$category] = $category_sum;
                $category_totals[$category] += $category_sum; // Add to totals
                $total_score += $category_sum; // Average per question
            }

            $student_data['TOTAL'] = $total_score;
            $students[] = $student_data;
        }

        // Calculate the average for TOTAL row
        $num_students = count($students);
        if ($num_students > 0) {
            foreach ($category_totals as $category => $sum) {
                $category_totals[$category] = round($sum / $num_students, 2); // Get average
            }
        }

        // Fetch supervisor's evaluation (assuming role is 'Supervisor')
        $supervisor_record = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->where('qceevaluator', 'Supervisor') // Fetch supervisor role
            ->first();

        $supervisor = [
            'Commitment' => 0,
            'Knowledge of Subject' => 0,
            'Teaching for Independent Learning' => 0,
            'Management of Learning' => 0,
            'TOTAL' => 0,
        ];

        if ($supervisor_record) {
            $ratings = json_decode($supervisor_record->question_rate, true);
            $supervisor_total = 0;
            foreach ($categories as $category => $question_ids) {
                $category_sum = 0;
                foreach ($question_ids as $question_id) {
                    if (isset($ratings[$question_id])) {
                        $category_sum += $ratings[$question_id];
                    }
                }
                $supervisor[$category] = $category_sum;
                $supervisor_total += $category_sum;
            }
            $supervisor['TOTAL'] = $supervisor_total;
        }

        // Pass data to view
        $data = [
            'fcs' => $fcs,
            'students' => $students,
            'category_totals' => $category_totals,
            'supervisor' => $supervisor,
            'facDesignateId' => $facDesignateId,
            'facDesignateIdCampusAd' => $facDesignateIdCampusAd,
        ];

        $pdf = PDF::loadView('reports.formpdf.pdfSumSheetdecimal', $data)->setPaper('Legal', 'portrait');
        return $pdf->stream();
    }
}
