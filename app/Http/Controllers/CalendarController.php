<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\EvaluationDB\QCEcalendar;
use App\Models\EvaluationDB\QCEoffices;

class CalendarController extends Controller
{
    public function index()
    {
        $office = QCEoffices::orderBy('id', 'ASC')->get();
        return view('calendar.activities', compact('office'));
    }

    public function fetch() 
    {
        $data = QCEcalendar::leftJoin('offices', 'schedevents.collegeID', '=', 'offices.id')
                ->select('schedevents.*', 'offices.office_abbr', 'offices.id as oid')
                ->get();

        return response()->json(['data' => $data]);
    }

    public function show() 
    {
        $events = QCEcalendar::join('offices', 'schedevents.collegeID', '=', 'offices.id')
            ->select('schedevents.*', 'offices.*')
            ->orderBy('start', 'ASC')
            ->get();
        $eventData = [];

        foreach ($events as $event) {
            $eventData[] = [
                'title' => $event->office_abbr . ' - ' . $event->eventname,
                'start' => $event->start, 
                'end' => $event->end,
                'color' => $event->eventcolor,
            ];
        }
        return response()->json($eventData);
    }

    public function create(Request $request) 
    {
        $request->validate([
            'eventname' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'collegeID' => 'required',
        ]);

        $conflict = QCEcalendar::where('collegeID', $request->input('collegeID'))
            ->where(function ($query) use ($request) {
                $query->whereBetween('start', [$request->input('start'), $request->input('end')])
                      ->orWhereBetween('end', [$request->input('start'), $request->input('end')])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('start', '<=', $request->input('start'))
                                ->where('end', '>=', $request->input('end'));
                      });
            })
            ->exists();

        if ($conflict) {
            return response()->json(['error' => true, 'message' => 'Event schedule conflicts with an existing event'], 409);
        }

        try {
            QCEcalendar::create([
                'eventname' => $request->input('eventname'),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
                'collegeID' => $request->input('collegeID'),
                'eventcolor' => $request->input('eventcolor'),
            ]);
            return response()->json(['success' => true, 'message' => 'Event Schedule successfully created'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Failed to schedule Event'], 500);
        }
    }
}
