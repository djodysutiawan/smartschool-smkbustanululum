<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAvailability extends Model
{
    use HasFactory;

    protected $table = 'teacher_availability';

    protected $fillable = [
        'teacher_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    /**
     * Relasi ke guru
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}