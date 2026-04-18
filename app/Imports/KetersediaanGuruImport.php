<?php

namespace App\Imports;
 
use App\Models\Guru;
use App\Models\KetersediaanGuru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
 
class KetersediaanGuruImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;
 
    public function model(array $row)
    {
        $guru = Guru::where('nama_lengkap', $row['nama_guru'])->first();
 
        return new KetersediaanGuru([
            'guru_id'     => $guru?->id,
            'hari'        => strtolower($row['hari']),
            'jam_mulai'   => $row['jam_mulai'],
            'jam_selesai' => $row['jam_selesai'],
            'tersedia'    => strtolower($row['tersedia'] ?? 'ya') === 'ya',
        ]);
    }
 
    public function rules(): array
    {
        return [
            'nama_guru'   => ['required'],
            'hari'        => ['required', 'in:senin,selasa,rabu,kamis,jumat,sabtu'],
            'jam_mulai'   => ['required'],
            'jam_selesai' => ['required'],
        ];
    }
 
    public function customValidationMessages(): array
    {
        return [
            'nama_guru.required'   => 'Kolom nama guru wajib diisi.',
            'hari.required'        => 'Kolom hari wajib diisi.',
            'hari.in'              => 'Nilai hari tidak valid.',
            'jam_mulai.required'   => 'Kolom jam mulai wajib diisi.',
            'jam_selesai.required' => 'Kolom jam selesai wajib diisi.',
        ];
    }
}