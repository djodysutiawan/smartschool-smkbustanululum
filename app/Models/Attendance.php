<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id','class_id','date','status','method','time_in','time_out'
    ];

    public function student() { return $this->belongsTo(Student::class); }
    public function class() { return $this->belongsTo(Classes::class); }
}
