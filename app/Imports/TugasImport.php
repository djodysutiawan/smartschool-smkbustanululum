<?php

namespace App\Imports;

use App\Models\Tugas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TugasImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row): Tugas
    {
        return new Tugas([
            'guru_id'           => $row['guru_id'],
            'mata_pelajaran_id' => $row['mata_pelajaran_id'],
            'kelas_id'          => $row['kelas_id'],
            'tahun_ajaran_id'   => $row['tahun_ajaran_id'],
            'judul'             => $row['judul'],
            'deskripsi'         => $row['deskripsi'] ?? null,
            'jenis_pengumpulan' => $row['jenis_pengumpulan_filetekslink_foto'],
            'batas_waktu'       => $row['batas_waktu_y_m_d_hi'],
            'nilai_maksimal'    => $row['nilai_maksimal'] ?? 100,
            'izinkan_terlambat' => $row['izinkan_terlambat_01'] ?? false,
            'dipublikasikan'    => $row['dipublikasikan_01'] ?? false,
        ]);
    }

    public function rules(): array
    {
        return [
            'guru_id'           => ['required', 'exists:guru,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string'],
            'batas_waktu_y_m_d_hi' => ['required'],
        ];
    }
}