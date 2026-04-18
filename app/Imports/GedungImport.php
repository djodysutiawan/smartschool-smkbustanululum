<?php

namespace App\Imports;
 
use App\Models\Gedung;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
 
class GedungImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;
 
    public function model(array $row)
    {
        return new Gedung([
            'kode_gedung'   => strtoupper($row['kode_gedung']),
            'nama_gedung'   => $row['nama_gedung'],
            'jumlah_lantai' => (int) $row['jumlah_lantai'],
            'deskripsi'     => $row['deskripsi'] ?? null,
            'is_active'     => strtolower($row['status'] ?? 'aktif') === 'aktif',
        ]);
    }
 
    public function rules(): array
    {
        return [
            'kode_gedung'   => ['required', 'string', 'unique:gedung,kode_gedung'],
            'nama_gedung'   => ['required', 'string'],
            'jumlah_lantai' => ['required', 'integer', 'min:1'],
        ];
    }
 
    public function customValidationMessages(): array
    {
        return [
            'kode_gedung.required'   => 'Kolom kode gedung wajib diisi.',
            'kode_gedung.unique'     => 'Kode gedung sudah terdaftar.',
            'nama_gedung.required'   => 'Kolom nama gedung wajib diisi.',
            'jumlah_lantai.required' => 'Kolom jumlah lantai wajib diisi.',
        ];
    }
}