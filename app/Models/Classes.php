<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'nama_kelas','tingkat','jurusan','wali_kelas_id'
    ];

    public function waliKelas() {
        return $this->belongsTo(Teacher::class, 'wali_kelas_id');
    }

    public function students() {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function schedules() { return $this->hasMany(Schedule::class, 'class_id'); }
}