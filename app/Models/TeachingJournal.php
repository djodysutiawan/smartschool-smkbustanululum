<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeachingJournal extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id','class_id','subject_id','tanggal','materi','keterangan'
    ];
}
