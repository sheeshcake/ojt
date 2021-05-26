<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject_name',
        'subject_code',
        'subject_unit',
        'subject_hours',
        'subject_prerequisite',
        'subject_year_prerequisite',
        'subject_description'
    ];
}
