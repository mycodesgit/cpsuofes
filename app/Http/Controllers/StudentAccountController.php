<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use Carbon\Carbon;

use App\Models\EnrollmentDB\Student;
use App\Models\EnrollmentDB\KioskUser;

class StudentAccountController extends Controller
{
    public function index()
    {
        return view('studaccount.stdntaccntcamp');
    }

    public function store(Request $request)
    {
        $campus = $request->query('campus');
        $decryptedCampus = Crypt::decrypt($campus);
        return view('studaccount.stdntaccntcampresult');
    }

    public function getStudentById(Request $request, $id)
    {
        $campus = $request->query('campus');
        $decryptedCampus = Crypt::decrypt($campus);
        $campusArray = array_map('trim', explode(',', $decryptedCampus));

        $student = Student::where('stud_id', $id)
                //->where('campus', $campusArray)
                ->where(function ($q) use ($campusArray) {
                    foreach ($campusArray as $campus) {
                        $q->orWhere('campus', 'LIKE', "%$campus%");
                    }
                })
                ->first();
        if ($student) {
            return response()->json($student);
        } else {
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    public function show(Request $request)
    {
        $campus = $request->query('campus');
        $decryptedCampus = Crypt::decrypt($campus);
        $campusArray = array_map('trim', explode(',', $decryptedCampus));
        $data = KioskUser::join('students', 'kioskstudent.studid', '=', 'students.stud_id')
                    // ->where('students.campus', $campusArray)
                    ->where(function ($q) use ($campusArray) {
                        foreach ($campusArray as $campus) {
                            $q->orWhere('campus', 'LIKE', "%$campus%");
                        }
                    })
                    ->select('kioskstudent.*', 'kioskstudent.id as studkiosid', 'students.lname', 'students.fname', 'students.mname', 'students.campus')
                    ->get();

        return response()->json(['data' => $data]);
    }

    public function create(Request $request) 
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'studid' => 'required',
                'password' => 'required',
            ]);

            $studidName = $request->input('studid'); 
            $existingStudentID = KioskUser::where('studid', $studidName)->first();

            if ($existingStudentID) {
                return response()->json(['error' => true, 'message' => 'Student ID No already exists'], 404);
            }

            try {
                KioskUser::create([
                    'studid' => $request->input('studid'),
                    'password' => Hash::make($request->input('password')),
                    'postedBy' => Auth::guard('web')->user()->id
                ]);

                return response()->json(['success' => true, 'message' => 'Stored successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Failed to store'], 404);
            }
        }
    }

    public function update(Request $request) 
    {
        $request->validate([
            'id' => 'required',
            'studid' => 'required',
            'password' => 'required',
        ]);

        try {
            $studidName = $request->input('studid');
            $existingStudentID = KioskUser::where('studid', $studidName)->where('id', '!=', $request->input('id'))->first();

            if ($existingStudentID) {
                return response()->json(['error' => true, 'message' => 'Student ID No already exists'], 404);
            }

            $kioskuser = KioskUser::findOrFail($request->input('id'));
            $kioskuser->resetnumber = $kioskuser->resetnumber + 1;
            $kioskuser->update([
                'studid' => $studidName,
                'password' => Hash::make($request->input('password')),
                //'postedBy' => Auth::guard('web')->user()->id,
                'postedBy' => 1,
                'resetnumber' => $kioskuser->resetnumber,
        ]);
            return response()->json(['success' => true, 'message' => 'Student Password in Kiosk Updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Failed to Update Student Password'], 404);
        }
    }
}
