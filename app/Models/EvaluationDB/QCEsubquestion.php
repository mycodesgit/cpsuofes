<?php

namespace App\Models\EvaluationDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QCEsubquestion extends Model
{
    use HasFactory;

    protected $table = 'qcesubquestion';

    protected $fillable = [
        'questionID', 
        'subquestionstext',
        'postedBy',
    ];
}
