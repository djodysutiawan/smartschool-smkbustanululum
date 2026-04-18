<?php

namespace App\Imports;
 
use App\Models\JadwalPelajaran;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Ruang;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
 
class JadwalPelajaranImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;
 
    public function model(array $row)
    {
        $tahunAjaran  = TahunAjaran::where('tahun', $row['tahun_ajaran'] ?? null)->first();
        $kelas        = Kelas::where('kode_kelas', strtoupper($row['kelas'] ?? ''))->first();
        $mataPelajaran = MataPelajaran::where('kode_mapel', strtoupper($row['mata_pelajaran'] ?? ''))->first();
        $ruang        = Ruang::where('kode_ruang', strtoupper($row['ruang'] ?? ''))->first();
        $guru         = Guru::where('nip', $row['guru'] ?? null)->first();
 
        return new JadwalPelajaran([
            'tahun_ajaran_id'   => $tahunAjaran?->id,
            'kelas_id'          => $kelas?->id,
            'mata_pelajaran_id' => $mataPelajaran?->id,
            'guru_id'           => $guru?->id,
            'ruang_id'          => $ruang?->id,
            'hari'              => strtolower($row['hari']),
            'jam_mulai'         => $row['jam_mulai'],
            'jam_selesai'       => $row['jam_selesai'],
            'sumber_jadwal'     => 'manual',
            'is_active'         => true,
        ]);
    }
 
    public function rules(): array
    {
        return [
            'tahun_ajaran' => ['required'],
            'hari'         => ['required', 'in:senin,selasa,rabu,kamis,jumat,sabtu'],
            'jam_mulai'    => ['required'],
            'jam_selesai'  => ['required'],
            'kelas'        => ['required'],
            'mata_pelajaran' => ['required'],
            'guru'         => ['required'],
        ];
    }
 
    public function customValidationMessages(): array
    {
        return [
            'tahun_ajaran.required'   => 'Kolom tahun ajaran wajib diisi.',
            'hari.required'           => 'Kolom hari wajib diisi.',
            'hari.in'                 => 'Nilai hari tidak valid.',
            'jam_mulai.required'      => 'Kolom jam mulai wajib diisi.',
            'jam_selesai.required'    => 'Kolom jam selesai wajib diisi.',
            'kelas.required'          => 'Kolom kelas wajib diisi.',
            'mata_pelajaran.required' => 'Kolom mata pelajaran wajib diisi.',
            'guru.required'           => 'Kolom guru wajib diisi.',
        ];
    }
}