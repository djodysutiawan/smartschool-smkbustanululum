<?php

namespace App\Imports;

use App\Models\Nilai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class NilaiImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $exists = Nilai::where('siswa_id', $row['siswa_id'])
                ->where('mata_pelajaran_id', $row['mata_pelajaran_id'])
                ->where('tahun_ajaran_id', $row['tahun_ajaran_id'])
                ->exists();

            if ($exists) {
                continue;
            }

            Nilai::create([
                'siswa_id'          => $row['siswa_id'],
                'mata_pelajaran_id' => $row['mata_pelajaran_id'],
                'guru_id'           => $row['guru_id'],
                'kelas_id'          => $row['kelas_id'],
                'tahun_ajaran_id'   => $row['tahun_ajaran_id'],
                'nilai_tugas'       => $row['nilai_tugas_0100'] ?? null,
                'nilai_harian'      => $row['nilai_harian_0100'] ?? null,
                'nilai_uts'         => $row['nilai_uts_0100'] ?? null,
                'nilai_uas'         => $row['nilai_uas_0100'] ?? null,
                'catatan'           => $row['catatan'] ?? null,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'siswa_id'          => ['required', 'exists:siswa,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'guru_id'           => ['required', 'exists:guru,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'nilai_tugas_0100'  => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_harian_0100' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_uts_0100'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_uas_0100'    => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'siswa_id.required'          => 'Kolom siswa_id wajib diisi.',
            'siswa_id.exists'            => 'ID siswa tidak ditemukan.',
            'mata_pelajaran_id.exists'   => 'ID mata pelajaran tidak ditemukan.',
            'guru_id.exists'             => 'ID guru tidak ditemukan.',
            'kelas_id.exists'            => 'ID kelas tidak ditemukan.',
            'tahun_ajaran_id.exists'     => 'ID tahun ajaran tidak ditemukan.',
            '*.numeric'                  => 'Nilai harus berupa angka.',
            '*.min'                      => 'Nilai tidak boleh kurang dari 0.',
            '*.max'                      => 'Nilai tidak boleh lebih dari 100.',
        ];
    }
}