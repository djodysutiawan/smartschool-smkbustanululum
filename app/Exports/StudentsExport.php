<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsExport implements FromCollection
{
    public function collection()
    {
        return Student::with(['class', 'academicYear'])
            ->select('nis', 'nama_lengkap', 'class_id', 'tahun_ajaran_id', 'status')
            ->get();
    }
}
