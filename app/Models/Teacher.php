<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','nip','nama_lengkap','jenis_kelamin','tempat_lahir',
        'tanggal_lahir','alamat','no_hp','email','foto',
        'pendidikan_terakhir','status'
    ];

    public function user() { return $this->belongsTo(User::class); }

    public function classes() {
        return $this->hasMany(Classes::class, 'wali_kelas_id');
    }

    public function schedules() { return $this->hasMany(Schedule::class); }
    public function materials() { return $this->hasMany(Material::class); }
    public function assignments() { return $this->hasMany(Assignment::class); }
    public function exams() { return $this->hasMany(Exam::class); }
    public function violations() { return $this->hasMany(Violation::class); }
    public function journals() { return $this->hasMany(TeachingJournal::class); }
    public function availability()
    {
        return $this->hasMany(TeacherAvailability::class);
    }
    public function piketSchedules()
    {
        return $this->hasMany(TeacherAvailability::class);
    }
}
