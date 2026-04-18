<?php

namespace App\Imports;

use App\Models\JurnalMengajar;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class JurnalMengajarImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            JurnalMengajar::create([
                'guru_id'             => $row['guru_id'],
                'kelas_id'            => $row['kelas_id'],
                'mata_pelajaran_id'   => $row['mata_pelajaran_id'],
                'jadwal_pelajaran_id' => $row['jadwal_pelajaran_id'] ?? null,
                'tanggal'             => $row['tanggal_yyyy_mm_dd'],
                'pertemuan_ke'        => $row['pertemuan_ke'] ?? null,
                'materi_ajar'         => $row['materi_ajar'],
                'metode_pembelajaran' => $row['metode_pembelajaran_ceramahdiskusipraktikumdemonstrasipro'] ?? null,
                'jumlah_hadir'        => $row['jumlah_hadir'] ?? null,
                'jumlah_tidak_hadir'  => $row['jumlah_tidak_hadir'] ?? null,
                'catatan_kelas'       => $row['catatan_kelas'] ?? null,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'guru_id'           => ['required', 'exists:guru,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'tanggal_yyyy_mm_dd'=> ['required', 'date'],
            'materi_ajar'       => ['required', 'string'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'guru_id.required'           => 'Kolom guru_id wajib diisi.',
            'guru_id.exists'             => 'ID guru tidak ditemukan.',
            'kelas_id.required'          => 'Kolom kelas_id wajib diisi.',
            'kelas_id.exists'            => 'ID kelas tidak ditemukan.',
            'mata_pelajaran_id.required' => 'Kolom mata_pelajaran_id wajib diisi.',
            'mata_pelajaran_id.exists'   => 'ID mata pelajaran tidak ditemukan.',
            'tanggal_yyyy_mm_dd.required'=> 'Kolom tanggal wajib diisi.',
            'tanggal_yyyy_mm_dd.date'    => 'Format tanggal tidak valid (gunakan YYYY-MM-DD).',
            'materi_ajar.required'       => 'Kolom materi_ajar wajib diisi.',
        ];
    }
}