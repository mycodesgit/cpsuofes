<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\EvaluationDB\QCEcategory;
use App\Models\EvaluationDB\QCEquestion;
use App\Models\EvaluationDB\QCEsubquestion;

class SubQuestionController extends Controller
{
    public function index()
    {
        $questions = QCEquestion::where('questcat', 2)->get();

        return view('manage.subquestion', compact('questions'));
    }

    public function show() 
    {
        $data = QCEsubquestion::join('qcequestion', 'qcesubquestion.questionID', '=', 'qcequestion.id')
            ->join('qcecategory', 'qcequestion.catName_id', '=', 'qcecategory.id')
            ->select('qcesubquestion.*', 'qcequestion.questiontext', 'qcecategory.catName')
            ->orderBy('qcecategory.catName', 'ASC')->get();

        return response()->json(['data' => $data]);
    }

    public function create(Request $request) 
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'subquestionstext' => 'required',
            ]);

            $subquestionsName = $request->input('subquestionstext'); 
            $existingSubQuestion = QCEsubquestion::where('subquestionstext', $subquestionsName)->first();

            if ($existingSubQuestion) {
                return response()->json(['error' => true, 'message' => 'Sub Question already exists'], 404);
            }

            try {
                QCEsubquestion::create([
                    'subquestionstext' => $request->input('subquestionstext'),
                    'questionID' => $request->input('questionID'),
                    'postedBy' => 1,
                ]);

                return response()->json(['success' => true, 'message' => 'Sub Question stored successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Failed to store Sub Question'], 404);
            }
        }
    }

    public function update(Request $request) 
    {
        $request->validate([
            'id' => 'required',
            'subquestionstext' => 'required',
        ]);

        try {
            $subquestionstext = $request->input('subquestionstext'); 
            $existingSubQuestion = QCEsubquestion::where('subquestionstext', $subquestionstext)->where('id', '!=', $request->input('id'))->first();

            if ($existingSubQuestion) {
                return response()->json(['error' => true, 'message' => 'Sub Question already exists'], 404);
            }

            $subquestion = QCEsubquestion::findOrFail($request->input('id'));
            $subquestion->update([
                'subquestionstext' => $request->input('subquestionstext'),
                'questionID' => $request->input('questionID'),
                'postedBy' => 1,
        ]);
            return response()->json(['success' => true, 'message' => 'Sub Question update successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Failed to Update Sub Question'], 404);
        }
    }

    public function destroy($id) 
    {
        $qcesubquestion = QCEsubquestion::find($id);
        $qcesubquestion->delete();

        return response()->json(['success'=> true, 'message'=>'Deleted Successfully',]);
    }
}
