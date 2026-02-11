<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\EvaluationDB\QCEratingscale;
use App\Models\EvaluationDB\FacultyProfile;

use App\Models\ScheduleDB\Addressee;
use App\Models\ScheduleDB\College;
use App\Models\ScheduleDB\Faculty;

class FacultyController extends Controller
{
    public function index()
    {
        return view('manage.faculty');
    }

    public function facultyFilter(Request $request)
    {   
        return view('manage.facultysearch');
    }

    public function getfacultylistRead(Request $request) 
    {
        $campus = $request->query('campus');
        $decryptedCampus = Crypt::decrypt($campus);

        // Step 1: Get faculty data
        $facultyData = Faculty::join('addressee', 'faculty.adrID', '=', 'addressee.id')
            ->join('college', 'faculty.dept', '=', 'college.college_abbr')
            ->where('faculty.campus', $decryptedCampus)
            ->select('faculty.*', 'faculty.id as fctyid', 'faculty.campus as fcamp', 'college.*', 'addressee.*', 'addressee.id as adrid')
            ->orderBy('faculty.lname')
            ->get();

        // Step 2: Get faculty profile data using DB::connection
        $facultyProfiles = DB::connection('mysql')
            ->table('faculty_profile')
            ->get()
            ->keyBy('facidprof'); // Index by facidprof for quick lookup

        // Step 3: Merge data
        $mergedData = $facultyData->map(function ($faculty) use ($facultyProfiles) {
            $profile = $facultyProfiles->get($faculty->fctyid);
            $faculty->profimage = $profile->profimage ?? null;
            return $faculty;
        });

        // Step 4: Return response
        return response()->json(['data' => $mergedData]);
    }

    public function facultyUploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'facidprof' => 'required',
            'lname' => 'required',
            'fname' => 'required',
            //'profimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }

        $existingProfile = FacultyProfile::where('facidprof', $request->input('facidprof'))->first();

        if ($existingProfile) {
            return response()->json(['error' => true, 'message' => 'A profile with this Faculty ID already exists.'], 400);
        }

        $facultyProfile = new FacultyProfile();

        if ($request->hasFile('profimage')) {
            $file = $request->file('profimage');
            $extension = $file->getClientOriginalExtension();

            $filename = strtolower($request->input('lname') . '_' . $request->input('fname') . '_' . $request->input('facidprof')) . '.' . $extension;

            $path = $file->storeAs('facultyimage', $filename, 'public');

            $facultyProfile->profimage = $path;
        }

        $facultyProfile->facidprof = $request->input('facidprof');
        $facultyProfile->save();

        return response()->json(['success' => true, 'message' => 'Faculty profile Uploded successfully'], 200);
    }

    public function facultyrankUpdate(Request $request) 
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $facrank = Faculty::findOrFail($request->input('id'));
            $facrank->update([
                'rank' => $request->input('rank'),
                'email' => $request->input('email'),
        ]);
            return response()->json(['success' => true, 'message' => 'Academic Rank Updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Failed to Update Academic Rank'], 404);
        }
    }
}
