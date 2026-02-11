<?php

namespace App\Models\EvaluationDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QCEquestion extends Model
{
    use HasFactory;

    protected $table = 'qcequestion';

    protected $fillable = [
        'catName_id', 
        'questiontext',
        'questcat',
        'postedBy',
    ];
}
