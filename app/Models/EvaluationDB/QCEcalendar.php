<?php

namespace App\Models\EvaluationDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QCEcalendar extends Model
{
    use HasFactory;

    protected $table = 'schedevents';

    protected $fillable = [
        'eventname',
        'start',
        'end',
        'collegeID',
        'eventcolor'
    ];
}
