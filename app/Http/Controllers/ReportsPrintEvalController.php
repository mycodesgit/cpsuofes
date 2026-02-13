<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;

use App\Models\EvaluationDB\QCEratingscale;
use App\Models\EvaluationDB\QCEinstruction;
use App\Models\EvaluationDB\QCEcategory;
use App\Models\EvaluationDB\QCEquestion;
use App\Models\EvaluationDB\QCEsemester;
use App\Models\EvaluationDB\QCEfevalrate;
use App\Models\EvaluationDB\StudeSig;

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
use App\Models\ScheduleDB\Subject;
use App\Models\ScheduleDB\SubjectOffered;

class ReportsPrintEvalController extends Controller
{
    public function index()
    {
        //$currsem = QCEsemester::all();
        $currsem = QCEsemester::select('id', 'qceschlyear')
            ->whereIn('id', function($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('qceschlyearsem')
                    ->groupBy('qceschlyear');
            })
            ->orderBy('id', 'DESC')
            ->get();

        $currsemfac = QCEsemester::select('id', 'qceschlyear', 'qceratingfrom', 'qceratingto')
            ->orderBy('id', 'DESC')
            ->get();
        $collegelist = College::whereIn('id', [2, 3, 4, 5, 6, 7, 8])->get();

        return view('reports.prnteval.evaluationprint', compact('currsem', 'currsemfac', 'collegelist'));
    }

    public function subprintstudent_searchresultStore()
    {
        //$currsem = QCEsemester::all();
        $currsem = QCEsemester::select('id', 'qceschlyear')
            ->whereIn('id', function($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('qceschlyearsem')
                    ->groupBy('qceschlyear');
            })
            ->orderBy('id', 'DESC')
            ->get();
        return view('reports.prnteval.evaluationprintsearchresultstudent', compact('currsem'));
    }

    public function subprintsupervisor_searchresultStore()
    {
        //$currsem = QCEsemester::all();
        $currsem = QCEsemester::select('id', 'qceschlyear')
            ->whereIn('id', function($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('qceschlyearsem')
                    ->groupBy('qceschlyear');
            })
            ->orderBy('id', 'DESC')
            ->get();
        return view('reports.prnteval.evaluationprintsearchresultsupervisor', compact('currsem'));
    }

    public function getevalsubratelistRead(Request $request) 
    {
        $semester = $request->query('semester');
        $schlyear = $request->query('schlyear');
        $campus = $request->query('campus');
        $progCodRaw = $request->query('progCod');

        // Convert spaces back to `+`
        $progCodRaw = str_replace(' ', '+', $progCodRaw);

        // Extract only the part before "+"
        $progCodParts = explode('+', $progCodRaw);
        $progCod = $progCodParts[0]; // Extract 'CSS-INT-001'

        // Ensure $progCodParts[1] exists before using it
        $progCodSection = isset($progCodParts[1]) ? $progCodParts[1] : null;

        // Extract studYear (integer) and studSec (letter) using regex
        $studYear = null;
        $studSec = null;

        if ($progCodSection) {
            preg_match('/^(\d+)-([A-Z]+)$/', $progCodSection, $matches);
            if (!empty($matches)) {
                $studYear = $matches[1]; // Extracts '1' from '1-A'
                $studSec = $matches[2];  // Extracts 'A' from '1-A'
            }
        }

        //\Log::info('Extracted progCod:', [$progCod]);
        //\Log::info('Extracted studYear:', [$studYear]);
        //\Log::info('Extracted studSec:', [$studSec]);

        try {
            $studentIds = DB::connection('enrollment')->table('program_en_history')
                ->where('semester', $semester)
                ->where('schlyear', $schlyear)
                ->where('campus', $campus)
                ->where('progCod', $progCod)
                ->when($studYear, function ($query) use ($studYear) {
                    return $query->where('studYear', '=', $studYear);
                })
                ->when($studSec, function ($query) use ($studSec) {
                    return $query->where('studSec', '=', $studSec);
                })
                ->select('program_en_history.*')
                ->pluck('studentID');

            if ($studentIds->isEmpty()) {
                return response()->json(['data' => [], 'message' => 'No students found'], 200);
            }

            $data = DB::table('qceformevalrate')
                ->whereIn('studidno', $studentIds)
                ->where('statprint', 1)
                ->where('semester', $semester)
                ->where('schlyear', $schlyear)
                ->where('campus', $campus)
                ->get();

            return response()->json(['data' => $data]);

        } catch (\Exception $e) {
            //\Log::error('Database Query Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getevalsubrateprintedlistRead(Request $request) 
    {
        $semester = $request->query('semester');
        $schlyear = $request->query('schlyear');
        $campus = $request->query('campus');
        $progCodRaw = $request->query('progCod');

        // Convert spaces back to `+`
        $progCodRaw = str_replace(' ', '+', $progCodRaw);

        // Extract only the part before "+"
        $progCodParts = explode('+', $progCodRaw);
        $progCod = $progCodParts[0]; // Extract 'CSS-INT-001'

        // Ensure $progCodParts[1] exists before using it
        $progCodSection = isset($progCodParts[1]) ? $progCodParts[1] : null;

        // Extract studYear (integer) and studSec (letter) using regex
        $studYear = null;
        $studSec = null;

        if ($progCodSection) {
            preg_match('/^(\d+)-([A-Z]+)$/', $progCodSection, $matches);
            if (!empty($matches)) {
                $studYear = $matches[1]; // Extracts '1' from '1-A'
                $studSec = $matches[2];  // Extracts 'A' from '1-A'
            }
        }

        //\Log::info('Extracted progCod:', [$progCod]);
        //\Log::info('Extracted studYear:', [$studYear]);
        //\Log::info('Extracted studSec:', [$studSec]);

        try {
            $studentIds = DB::connection('enrollment')->table('program_en_history')
                ->where('semester', $semester)
                ->where('schlyear', $schlyear)
                ->where('campus', $campus)
                ->where('progCod', $progCod)
                ->when($studYear, function ($query) use ($studYear) {
                    return $query->where('studYear', '=', $studYear);
                })
                ->when($studSec, function ($query) use ($studSec) {
                    return $query->where('studSec', '=', $studSec);
                })
                ->pluck('studentID');

            if ($studentIds->isEmpty()) {
                return response()->json(['data' => [], 'message' => 'No students found'], 200);
            }

            $data = DB::table('qceformevalrate')
                ->whereIn('studidno', $studentIds)
                ->where('statprint', 2)
                ->where('semester', $semester)
                ->where('schlyear', $schlyear)
                ->where('campus', $campus)
                ->get();

            return response()->json(['data' => $data]);

        } catch (\Exception $e) {
            //\Log::error('Database Query Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getCoursesyearsec(Request $request)
    {
        $semester = $request->semester;
        $schlyear = $request->schlyear;
        $campus = $request->campus;

        $courses = ClassEnroll::join('programs', 'class_enroll.progCode', '=', 'programs.progCod')
            ->where('class_enroll.semester', $semester)
            ->where('class_enroll.schlyear', $schlyear)
            ->where('class_enroll.campus', $campus)
            ->orderBy('class_enroll.progCode')
            ->orderBy('class_enroll.classSection')
            ->get();

        return response()->json($courses);
    }

    public function exportPrintStudentEvalPDF(Request $request)
    {
        $id = $request->query('id');
        $semester = $request->query('semester');
        $schlyear = $request->query('schlyear');
        $campus = $request->query('campus');
        $progCod = $request->query('progCod');
        $studYear = $request->query('studYear');
        $studSec = $request->query('studSec');
        $studidno = $request->query('studidno');

        if (!$id || !$progCod || !$studYear || !$studSec || !$schlyear || !$semester || !$campus || !$studidno) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }

        $facrated = QCEfevalrate::where('id', $id)
            ->where('semester', $semester)
            ->where('schlyear', $schlyear)
            ->where('campus', $campus)
            ->where('studidno', $studidno)
            ->get();

        if ($facrated->isEmpty()) {
            return response()->json(['error' => 'No data found for the provided parameters'], 404);
        }

        $facRanck = DB::connection('schedule')->table('faculty')
            ->where('faculty.id', $facrated->first()->qcefacID)
            ->get();

        $ratingscale = QCEratingscale::orderBy('inst_scale', 'DESC')->where('instratingscalestat', 1)->get();
        $instrctn = QCEinstruction::where('instructcat', 1)->get();
        $currsem = QCEsemester::where('qcesemstat', 2)->get();
        $quest = QCEquestion::join('qcecategory', 'qcequestion.catName_id', '=', 'qcecategory.id')
            ->select('qcecategory.catName', 'qcecategory.catDesc', 'qcequestion.*')
            ->where('qcequestion.questcat', '1')
            ->where('qcecategory.catstatus', '2')
            ->get();
        
        $esig = StudeSig::leftJoin('qceformevalrate', 'studsignature.studIDno', '=', 'qceformevalrate.studidno')
            ->where('qceformevalrate.studidno', $facrated->first()->studidno)
            ->select('studsignature.studesig')
            ->get();

        $pdf = PDF::loadView('reports.prnteval.studevalforteacherpdf', compact('ratingscale', 'instrctn', 'currsem', 'quest', 'facrated', 'progCod', 'studYear', 'studSec', 'schlyear', 'semester', 'campus', 'facRanck', 'esig'))->setPaper('Legal', 'portrait');

        return $pdf->stream('Student Evaluation for Teacher.pdf');
    }

    public function exportPrintSupervisorEvalPDF(Request $request)
    {
        $campus = $request->query('campus');
        $schlyear = $request->query('schlyear');
        $semester = $request->query('semester');
        $faclty = $request->query('faclty');
        $ratingFrom = $request->query('ratingfrom');
        $ratingTo   = $request->query('ratingto');
        $rating_period = $ratingFrom . ' - ' . $ratingTo;

        if (!$schlyear || !$semester || !$campus || !$faclty) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }

        $facrated = QCEfevalrate::where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->where('qcefacID', $faclty)
            ->where('qceevaluator', '=', 'Supervisor')
            ->select('qceformevalrate.*')
            ->get();

        $facRanck = DB::connection('schedule')->table('faculty')
            ->where('faculty.id', $facrated->first()->qcefacID)
            ->get();

        $ratingscale = QCEratingscale::orderBy('inst_scale', 'DESC')->where('instratingscalestat', 1)->get();
        $instrctn = QCEinstruction::where('instructcat', 2)->first();
        $currsem = QCEsemester::where('qcesemstat', 2)->get();
        $quest = QCEquestion::join('qcecategory', 'qcequestion.catName_id', '=', 'qcecategory.id')
            ->select('qcecategory.catName', 'qcecategory.catDesc', 'qcequestion.*')
            ->where('qcequestion.questcat', '2')
            ->where('qcecategory.catstatus', '2')
            ->get();
        
        $esig = StudeSig::leftJoin('qceformevalrate', 'studsignature.studIDno', '=', 'qceformevalrate.studidno')
            ->where('qceformevalrate.studidno', $facrated->first()->qcefacID)
            ->select('studsignature.studesig')
            ->get();

        $pdf = PDF::loadView('reports.prnteval.studevalforsupervisorpdf', compact('ratingscale', 'instrctn', 'currsem', 'quest', 'facrated', 'schlyear', 'semester', 'campus', 'facRanck', 'esig'))->setPaper('Legal', 'portrait');

        return $pdf->stream('Supervisors Evaluation of Faculty.pdf');
    }

    public function updateStatprint(Request $request) 
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {

            $prinrate = QCEfevalrate::findOrFail($request->input('id'));
            $prinrate->update([
                'statprint' => 2,
        ]);
            return response()->json(['success' => true, 'message' => 'Done Print'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Error'], 404);
        }
    }
}
