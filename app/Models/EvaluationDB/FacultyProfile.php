<?php

namespace App\Models\EvaluationDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyProfile extends Model
{
    use HasFactory;

    protected $table = 'faculty_profile';

    protected $fillable = [
        'facidprof',
        'profimage',
    ];
}
