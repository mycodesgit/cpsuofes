<?php

namespace App\Models\EvaluationDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QCEoffices extends Model
{
    use HasFactory;

    protected $table = 'offices';

    protected $fillable = [
        'office_name',
        'office_abbr',
        'color'
    ];
}
