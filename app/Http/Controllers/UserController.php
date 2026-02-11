<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\EvaluationDB\User;

class UserController extends Controller
{
    public function index() 
    {
        return view("users.listusr");
    }

    public function getUserRead() 
    {
        $data = User::all();

        return response()->json(['data' => $data]);
    }

    public function create(Request $request) 
    {

        if ($request->isMethod('post')) {
            $request->validate([
                'lname' => 'required',
                'fname' => 'required',
                'mname' => 'required',
                'email' => 'required',
                'password' => 'required|string|min:5',
                'dept' => 'required',
                'role' => 'required',
                'campus' => 'required',
            ]);

            $emailName = $request->input('email'); 
            $existingEmail = User::where('email', $emailName)->first();

            if ($existingEmail) {
                return response()->json(['error' => true, 'message' => 'User already exists'], 404);
            }

            try {
                User::create([
                    'lname' => $request->input('lname'),
                    'fname' => $request->input('fname'),
                    'mname' => $request->input('mname'),
                    'email' => $emailName,
                    'password' => Hash::make($request->input('password')),
                    'dept' => $request->input('dept'),
                    'role' => $request->input('role'),
                    'campus' => $request->input('campus'),
                    'remember_token' => Str::random(60),
                ]);

                return response()->json(['success' => true, 'message' => 'User stored successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Failed to store User'], 404);
            }
        }
    }

    public function update(Request $request) 
    {
        $request->validate([
            'id' => 'required',
            'lname' => 'required',
            'fname' => 'required',
            'mname' => 'required',
            'email' => 'required',
            'dept' => 'required',
            'role' => 'required',
            'campus' => 'required',
        ]);

        try {
            $emailName = $request->input('email'); 
            $existingEmail = User::where('email', $emailName)
                            ->where('id', '!=', $request->input('id'))
                            ->first();

            if ($existingEmail) {
                return response()->json(['error' => true, 'message' => 'User already exists'], 404);
            }

            $qceuser = User::findOrFail($request->input('id'));
            $qceuser->update([
                'lname' => $request->input('lname'),
                'fname' => $request->input('fname'),
                'mname' => $request->input('mname'),
                'email' => $emailName,
                'dept' => $request->input('dept'),
                'role' => $request->input('role'),
                'campus' => $request->input('campus'),
        ]);
            return response()->json(['success' => true, 'message' => 'User update successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Failed to Update User'], 404);
        }
    }

    public function passUpdate(Request $request) 
    {
        $request->validate([
            'id' => 'required',
            'password' => 'required',
        ]);

        try {
            $passuser = User::findOrFail($request->input('id'));
            $passuser->resetcount = $passuser->resetcount + 1;
            $passuser->update([
                'password' => Hash::make($request->input('password')),
                'resetcount' => $passuser->resetcount,
        ]);
            return response()->json(['success' => true, 'message' => 'Password Updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Failed to Update Password'], 404);
        }
    }

    public function userUpdateStatus(Request $request) {
        $user = User::find($request->id);
        
        $request->validate([
            'id' => 'required',
            'ustatus' => 'required',
        ]);

        try {
            $user = User::findOrFail($request->input('id'));
            $user->update([
                'ustatus' => $request->input('ustatus'),
            ]);

            return response()->json(['success' => true, 'message' => 'User Status updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Failed to update User Password!']);
        }
    }

    public function destroy($id) 
    {
        $qceuser = User::find($id);
        $qceuser->delete();

        return response()->json(['success'=> true, 'message'=>'Deleted Successfully',]);
    }
}
