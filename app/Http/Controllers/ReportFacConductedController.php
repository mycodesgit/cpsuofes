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
use App\Models\ScheduleDB\SetClassSchedule;

class ReportFacConductedController extends Controller
{
    public function index()
    {
        $currsem = QCEsemester::select('id', 'qceschlyear')
            ->whereIn('id', function($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('qceschlyearsem')
                    ->groupBy('qceschlyear');
            })
            ->orderBy('id', 'DESC')
            ->get();
        
        $collegelist = College::whereIn('id', [2, 3, 4, 5, 6, 7, 8])->get();

        return view('reports.conductedeval.cndcteval', compact('currsem', 'collegelist'));
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

        $schlyear = $request->query('schlyear');
        $semester = $request->query('semester');
        $faculty_id = $request->query('faclty');
        $campus = $request->query('campus');

        $faculty = Faculty::where('faculty.id', '=', $faculty_id)->first();
        if ($faculty) {
            $facultyName = $faculty->fname . ' ' . substr($faculty->mname, 0, 1) . '. ' . $faculty->lname;
        } else {
            $facultyName = 'Faculty not found';
        }

        $facloadsched = SetClassSchedule::join('sub_offered', 'scheduleclass.subject_id', '=', 'sub_offered.id')
                ->join('subjects', 'sub_offered.subCode', '=', 'subjects.sub_code')
                ->leftJoin('faculty', 'scheduleclass.faculty_id', '=', 'faculty.id')
                ->leftJoin('rooms', 'scheduleclass.room_id', '=', 'rooms.id')
                ->leftJoin('coasv2_db_enrollment.studgrades', 'sub_offered.id', '=', 'coasv2_db_enrollment.studgrades.subjID')
                ->where('scheduleclass.schlyear', '=', $schlyear)
                ->where('scheduleclass.semester', '=', $semester)
                ->where('scheduleclass.faculty_id', $faculty_id)
                ->where('scheduleclass.campus', $campus)
                ->select('sub_offered.subSec', 
                        'sub_offered.subCode', 
                        'scheduleclass.*', 
                        'subjects.sub_name', 
                        'subjects.sub_title',
                        'subjects.sublecredit',  
                        'subjects.sublabcredit', 
                        'subjects.sub_unit', 
                        'faculty.lname', 
                        'faculty.fname', 
                        'faculty.mname', 
                        'faculty.dept',
                        'rooms.room_name',
                        DB::raw('COUNT(DISTINCT coasv2_db_enrollment.studgrades.studID) as studentCount'))
                ->groupBy(
                    'sub_offered.subSec',
                    'sub_offered.subCode',
                )
                ->orderBy('sub_offered.subSec')
                ->get();

        $evalCounts = QCEfevalrate::whereIn('subjidrate', $facloadsched->pluck('subject_id'))
            ->select('subjidrate', DB::raw('COUNT(DISTINCT studidno) as eval_count'))
            ->where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->groupBy('subjidrate')
            ->get()
            ->keyBy('subjidrate');

        return view('reports.conductedeval.cndctevalresult', compact('currsem', 'facultyName', 'facloadsched', 'schlyear', 'semester', 'faculty_id', 'evalCounts'));
    }

    public function facultySearchFilterPDF(Request $request)
    {
        $schlyear = $request->query('schlyear');
        $semester = $request->query('semester');
        $faculty_id = $request->query('faclty');
        $campus = $request->query('campus');

        $faculty = Faculty::where('faculty.id', '=', $faculty_id)->first();
        if ($faculty) {
            $facultyName = $faculty->fname . ' ' . substr($faculty->mname, 0, 1) . '. ' . $faculty->lname;
        } else {
            $facultyName = 'Faculty not found';
        }

        $facloadsched = SetClassSchedule::join('sub_offered', 'scheduleclass.subject_id', '=', 'sub_offered.id')
                ->join('subjects', 'sub_offered.subCode', '=', 'subjects.sub_code')
                ->leftJoin('faculty', 'scheduleclass.faculty_id', '=', 'faculty.id')
                ->leftJoin('rooms', 'scheduleclass.room_id', '=', 'rooms.id')
                ->leftJoin('coasv2_db_enrollment.studgrades', 'sub_offered.id', '=', 'coasv2_db_enrollment.studgrades.subjID')
                ->where('scheduleclass.schlyear', '=', $schlyear)
                ->where('scheduleclass.semester', '=', $semester)
                ->where('scheduleclass.faculty_id', $faculty_id)
                ->where('scheduleclass.campus', $campus)
                ->select('sub_offered.subSec', 
                        'sub_offered.subCode', 
                        'scheduleclass.*', 
                        'subjects.sub_name', 
                        'subjects.sub_title',
                        'subjects.sublecredit',  
                        'subjects.sublabcredit', 
                        'subjects.sub_unit', 
                        'faculty.lname', 
                        'faculty.fname', 
                        'faculty.mname', 
                        'faculty.dept', 
                        'rooms.room_name',
                        DB::raw('COUNT(DISTINCT coasv2_db_enrollment.studgrades.studID) as studentCount'))
                ->groupBy(
                    'sub_offered.subSec',
                    'sub_offered.subCode',
                )
                ->orderBy('sub_offered.subSec')
                ->get();

        $evalCounts = QCEfevalrate::whereIn('subjidrate', $facloadsched->pluck('subject_id'))
            ->select('subjidrate', DB::raw('COUNT(DISTINCT studidno) as eval_count'))
            ->where('campus', $campus)
            ->where('schlyear', $schlyear)
            ->where('semester', $semester)
            ->groupBy('subjidrate')
            ->get()
            ->keyBy('subjidrate');

        $data = [
            'facultyName' => $facultyName,
            'facloadsched' => $facloadsched,
            'schlyear' => $schlyear,
            'semester' => $semester,
            'evalCounts' => $evalCounts,
        ];

        $pdf = PDF::loadView('reports.conductedeval.cndctevalresultpdf', $data)->setPaper('Legal', 'landscape');
        return $pdf->stream();
    }
}
