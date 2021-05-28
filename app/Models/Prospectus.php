<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospectus extends Model
{
    use HasFactory;
    protected $table = "prospectus";
    protected $fillable = [
        'course_id',
        'subject_id',
        'subject_semester',
        'subject_year'
    ];
}
