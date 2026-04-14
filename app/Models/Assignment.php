<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id','subject_id','class_id','judul','deskripsi','deadline'
    ];

    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function submissions() { return $this->hasMany(AssignmentSubmission::class); }
}
