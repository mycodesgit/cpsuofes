<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\EvaluationDB\QCEsemester;

class SemesterController extends Controller
{
    public function index()
    {
        return view('manage.semester');
    }

    public function show() 
    {
        $data = QCEsemester::orderBy('id', 'DESC')->get();

        return response()->json(['data' => $data]);
    }

    public function create(Request $request) 
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'qceschlyear' => 'required',
                'qcesemester' => 'required',
                'qceratingfrom' => 'required',
                'qceratingto' => 'required',
            ]);

            $schlyear = $request->input('qceschlyear');
            $semester = $request->input('qcesemester');
            $ratingfrom = $request->input('qceratingfrom'); 
            $ratingto = $request->input('qceratingto'); 

            $existingSemester = QCEsemester::where('qceschlyear', $schlyear)
                                ->where('qcesemester', $semester)
                                ->where('qceratingfrom', $ratingfrom)
                                ->where('qceratingto', $ratingto)
                                ->first();

            if ($existingSemester) {
                return response()->json(['error' => true, 'message' => 'Semester already exists'], 404);
            }

            try {
                QCEsemester::create([
                    'qceschlyear' => $schlyear,
                    'qcesemester' => $semester,
                    'qceratingfrom' => $ratingfrom,
                    'qceratingto' => $ratingto,
                    'postedBy' => 1,
                ]);

                return response()->json(['success' => true, 'message' => 'Semester stored successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Failed to store Semester'], 404);
            }
        }
    }

    public function update(Request $request) 
    {
        $request->validate([
            'id' => 'required',
            'qceschlyear' => 'required',
            'qcesemester' => 'required',
            'qceratingfrom' => 'required',
            'qceratingto' => 'required',
        ]);

        try {
            $schlyear = $request->input('qceschlyear');
            $semester = $request->input('qcesemester');
            $ratingfrom = $request->input('qceratingfrom'); 
            $ratingto = $request->input('qceratingto'); 

            $existingSemester = QCEsemester::where('qceschlyear', $schlyear)
                                ->where('qcesemester', $semester)
                                ->where('qceratingfrom', $ratingfrom)
                                ->where('qceratingto', $ratingto)
                                ->where('id', '!=', $request->input('id'))
                                ->first();

            if ($existingSemester) {
                return response()->json(['error' => true, 'message' => 'Semester already exists'], 404);
            }

            $qcesem = QCEsemester::findOrFail($request->input('id'));
            $qcesem->update([
                'qceschlyear' => $schlyear,
                'qcesemester' => $semester,
                'qceratingfrom' => $ratingfrom,
                'qceratingto' => $ratingto,
                'qcesemstat' => $request->input('qcesemstat'),
                'postedBy' => 1,
        ]);
            return response()->json(['success' => true, 'message' => 'Semester update successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Failed to Update Semester'], 404);
        }
    }

    public function destroy($id) 
    {
        $qcesem = QCEsemester::find($id);
        $qcesem->delete();

        return response()->json(['success'=> true, 'message'=>'Deleted Successfully',]);
    }
}
