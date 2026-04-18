<?php

namespace App\Imports;
 
use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
 
class MataPelajaranImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;
 
    private const KELOMPOK = ['normatif', 'adaptif', 'produktif', 'muatan_lokal', 'pengembangan_diri'];
 
    public function model(array $row)
    {
        $kelompok = strtolower(str_replace(' ', '_', $row['kelompok'] ?? ''));
 
        return new MataPelajaran([
            'kode_mapel'      => strtoupper($row['kode_mapel']),
            'nama_mapel'      => $row['nama_mata_pelajaran'],
            'kelompok'        => in_array($kelompok, self::KELOMPOK) ? $kelompok : null,
            'jam_per_minggu'  => (int) ($row['jam_minggu'] ?? 2),
            'durasi_per_sesi' => (int) ($row['durasi_sesi_mnt'] ?? 45),
            'perlu_lab'       => strtolower($row['perlu_lab'] ?? 'tidak') === 'ya',
            'is_active'       => strtolower($row['status'] ?? 'aktif') === 'aktif',
        ]);
    }
 
    public function rules(): array
    {
        return [
            'kode_mapel'            => ['required', 'unique:mata_pelajaran,kode_mapel'],
            'nama_mata_pelajaran'   => ['required'],
            'jam_minggu'            => ['nullable', 'integer', 'min:1'],
            'durasi_sesi_mnt'       => ['nullable', 'integer', 'min:30'],
        ];
    }
 
    public function customValidationMessages(): array
    {
        return [
            'kode_mapel.required'          => 'Kolom kode mapel wajib diisi.',
            'kode_mapel.unique'            => 'Kode mata pelajaran sudah terdaftar.',
            'nama_mata_pelajaran.required' => 'Kolom nama mata pelajaran wajib diisi.',
        ];
    }
}