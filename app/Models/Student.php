<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','nis','nisn','nama_lengkap','jenis_kelamin',
        'tempat_lahir','tanggal_lahir','agama','alamat','no_hp','email','foto',
        'nama_ayah','pekerjaan_ayah','no_hp_ayah',
        'nama_ibu','pekerjaan_ibu','no_hp_ibu',
        'nama_wali','pekerjaan_wali','no_hp_wali',
        'class_id','academic_year_id','status'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function class() { return $this->belongsTo(Classes::class, 'class_id'); }
    public function academicYear() { return $this->belongsTo(AcademicYear::class, 'academic_year_id'); }

    public function parents() {
        return $this->belongsToMany(ParentModel::class, 'student_parent')
            ->withPivot('hubungan');
    }

    public function submissions() { return $this->hasMany(AssignmentSubmission::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }
    public function violations() { return $this->hasMany(Violation::class); }
    public function grades() { return $this->hasMany(Grade::class); }
}