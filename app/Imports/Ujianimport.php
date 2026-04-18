<?php

namespace App\Imports;

use App\Models\Ujian;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class UjianImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            Ujian::create([
                'judul'             => $row['judul'],
                'jenis'             => $row['jenis'],
                'guru_id'           => $row['guru_id'],
                'mata_pelajaran_id' => $row['mata_pelajaran_id'],
                'kelas_id'          => $row['kelas_id'],
                'tahun_ajaran_id'   => $row['tahun_ajaran_id'],
                'tanggal'           => $row['tanggal_yyyy_mm_dd'],
                'jam_mulai'         => $row['jam_mulai_hh_mm'] ?? null,
                'durasi_menit'      => $row['durasi_menit'],
                'nilai_kkm'         => $row['nilai_kkm'] ?? 75,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'judul'             => ['required', 'string', 'max:255'],
            'jenis'             => ['required', 'in:ulangan_harian,uts,uas,remedial,quiz'],
            'guru_id'           => ['required', 'exists:guru,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'tanggal_yyyy_mm_dd'=> ['required', 'date'],
            'durasi_menit'      => ['required', 'integer', 'min:1'],
            'nilai_kkm'         => ['nullable', 'integer', 'min:0', 'max:100'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'judul.required'             => 'Kolom judul wajib diisi.',
            'jenis.required'             => 'Kolom jenis wajib diisi.',
            'jenis.in'                   => 'Jenis ujian tidak valid.',
            'guru_id.required'           => 'Kolom guru_id wajib diisi.',
            'guru_id.exists'             => 'ID guru tidak ditemukan.',
            'mata_pelajaran_id.exists'   => 'ID mata pelajaran tidak ditemukan.',
            'kelas_id.exists'            => 'ID kelas tidak ditemukan.',
            'tahun_ajaran_id.exists'     => 'ID tahun ajaran tidak ditemukan.',
            'tanggal_yyyy_mm_dd.required'=> 'Kolom tanggal wajib diisi.',
            'durasi_menit.required'      => 'Kolom durasi wajib diisi.',
            'durasi_menit.min'           => 'Durasi minimal 1 menit.',
        ];
    }
}