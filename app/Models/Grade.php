<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id','subject_id','teacher_id',
        'nilai_tugas','nilai_uts','nilai_uas','nilai_akhir'
    ];

    public function student() { return $this->belongsTo(Student::class); }
}
