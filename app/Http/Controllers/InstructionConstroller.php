<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\EvaluationDB\QCEinstruction;

class InstructionConstroller extends Controller
{
    public function index()
    {
        return view('manage.instruction');
    }

    public function show() 
    {
        $data = QCEinstruction::orderBy('instructcat', 'DESC')->get();

        return response()->json(['data' => $data]);
    }

    public function create(Request $request) 
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'instruction' => 'required',
                'instructcat' => 'required',
            ]);

            $instructionName = $request->input('instruction'); 
            $instructionType = $request->input('instructcat'); 
            $existingInstruction = QCEinstruction::where('instruction', $instructionName)->where('instructcat', $instructionType)->first();

            if ($existingInstruction) {
                return response()->json(['error' => true, 'message' => 'Instruction already exists'], 404);
            }

            try {
                QCEinstruction::create([
                    'instruction' => $request->input('instruction'),
                    'instructcat' => $request->input('instructcat'),
                    'postedBy' => 1,
                ]);

                return response()->json(['success' => true, 'message' => 'Instruction stored successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Failed to store Instruction'], 404);
            }
        }
    }

    public function update(Request $request) 
    {
        $request->validate([
            'id' => 'required',
            'catName' => 'required',
        ]);

        try {
            $instructionName = $request->input('instruction'); 
            $instructionType = $request->input('instructcat');  
            $existingInstruction = QCEinstruction::where('instruction', $instructionName)->where('instructcat', $instructionType)->where('id', '!=', $request->input('id'))->first();

            if ($existingInstruction) {
                return response()->json(['error' => true, 'message' => 'Instruction already exists'], 404);
            }

            $qceinstrct = QCEinstruction::findOrFail($request->input('id'));
            $qceinstrct->update([
                'instruction' => $request->input('instruction'),
                'instructcat' => $request->input('instructcat'),
                'postedBy' => 1,
        ]);
            return response()->json(['success' => true, 'message' => 'Instruction update successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Failed to Update Instruction'], 404);
        }
    }

    public function destroy($id) 
    {
        $qceinstrct = QCEinstruction::find($id);
        $qceinstrct->delete();

        return response()->json(['success'=> true, 'message'=>'Deleted Successfully',]);
    }
}
