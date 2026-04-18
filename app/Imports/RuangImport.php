<?php

namespace App\Imports;
 
use App\Models\Gedung;
use App\Models\Ruang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
 
class RuangImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;
 
    public function model(array $row)
    {
        $gedung = Gedung::where('kode_gedung', strtoupper($row['kode_gedung']))->first();
 
        return new Ruang([
            'gedung_id'     => $gedung?->id,
            'kode_ruang'    => strtoupper($row['kode_ruang']),
            'nama_ruang'    => $row['nama_ruang'],
            'lantai'        => (int) $row['lantai'],
            'jenis_ruang'   => strtolower(str_replace(' ', '_', $row['jenis_ruang'])),
            'kapasitas'     => (int) $row['kapasitas'],
            'ada_proyektor' => strtolower($row['proyektor'] ?? 'tidak') === 'ya',
            'ada_ac'        => strtolower($row['ac'] ?? 'tidak') === 'ya',
            'ada_wifi'      => strtolower($row['wifi'] ?? 'tidak') === 'ya',
            'ada_komputer'  => strtolower($row['komputer'] ?? 'tidak') === 'ya',
            'status'        => strtolower(str_replace(' ', '_', $row['status'] ?? 'tersedia')),
            'keterangan'    => $row['keterangan'] ?? null,
        ]);
    }
 
    public function rules(): array
    {
        return [
            'kode_gedung' => ['required'],
            'kode_ruang'  => ['required', 'unique:ruang,kode_ruang'],
            'nama_ruang'  => ['required'],
            'lantai'      => ['required', 'integer'],
            'kapasitas'   => ['required', 'integer'],
        ];
    }
 
    public function customValidationMessages(): array
    {
        return [
            'kode_gedung.required' => 'Kolom kode gedung wajib diisi.',
            'kode_ruang.required'  => 'Kolom kode ruang wajib diisi.',
            'kode_ruang.unique'    => 'Kode ruang sudah terdaftar.',
            'nama_ruang.required'  => 'Kolom nama ruang wajib diisi.',
            'lantai.required'      => 'Kolom lantai wajib diisi.',
            'kapasitas.required'   => 'Kolom kapasitas wajib diisi.',
        ];
    }
}