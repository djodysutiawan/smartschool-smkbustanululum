<?php

namespace App\Imports;

use App\Models\SoalUjian;
use App\Models\Ujian;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

class SoalUjianImport implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    /** Baris yang gagal diimpor (untuk feedback ke user) */
    protected array $rowErrors = [];

    public function __construct(protected Ujian $ujian) {}

    /*
    |--------------------------------------------------------------------------
    | Proses koleksi baris
    |--------------------------------------------------------------------------
    */
    public function collection(Collection $rows): void
    {
        DB::transaction(function () use ($rows) {
            // Ambil nomor soal terakhir sebelum import
            $nomorSoal = (int) $this->ujian->soal()->max('nomor_soal');

            foreach ($rows as $rowIndex => $row) {
                // Lewati baris kosong
                if ($this->isRowEmpty($row)) {
                    continue;
                }

                // Validasi per-baris
                $validator = Validator::make($row->toArray(), $this->rowRules());
                if ($validator->fails()) {
                    $this->rowErrors[] = [
                        'baris'  => $rowIndex + 2,  // +2: heading row + 0-index
                        'errors' => $validator->errors()->all(),
                    ];
                    continue;
                }

                $nomorSoal++;
                $jenisSoal = strtolower(trim($row['jenis_soal'] ?? 'pilihan_ganda'));

                // Buat soal
                $soal = $this->ujian->soal()->create([
                    'nomor_soal' => (int) ($row['nomor_soal'] ?? $nomorSoal),
                    'jenis_soal' => $jenisSoal,
                    'pertanyaan' => trim($row['pertanyaan']),
                    'bobot'      => (int) ($row['bobot'] ?? 1),
                ]);

                // Buat pilihan jawaban (untuk PG & benar_salah)
                if (in_array($jenisSoal, ['pilihan_ganda', 'benar_salah'])) {
                    $this->buatPilihan($soal, $row);
                }
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Buat pilihan jawaban dari kolom A-E
    |--------------------------------------------------------------------------
    */
    protected function buatPilihan(SoalUjian $soal, $row): void
    {
        // Kode jawaban benar — bisa "A" atau "A,B" (multiple correct)
        $jawabanBenar = array_map(
            fn($k) => strtoupper(trim($k)),
            explode(',', $row['jawaban_benar'] ?? '')
        );

        $kolomPilihan = [
            'A' => $row['pilihan_a'] ?? null,
            'B' => $row['pilihan_b'] ?? null,
            'C' => $row['pilihan_c'] ?? null,
            'D' => $row['pilihan_d'] ?? null,
            'E' => $row['pilihan_e'] ?? null,
        ];

        foreach ($kolomPilihan as $kode => $teks) {
            if (empty($teks)) {
                continue;
            }

            $soal->pilihan()->create([
                'kode_pilihan' => $kode,
                'teks_pilihan' => trim($teks),
                'adalah_benar' => in_array($kode, $jawabanBenar),
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Validasi per baris
    |--------------------------------------------------------------------------
    */
    protected function rowRules(): array
    {
        return [
            'jenis_soal' => ['required', 'in:pilihan_ganda,essay,benar_salah'],
            'pertanyaan' => ['required', 'string'],
            'bobot'      => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Cek apakah baris kosong
    |--------------------------------------------------------------------------
    */
    protected function isRowEmpty($row): bool
    {
        return empty(trim((string) ($row['pertanyaan'] ?? '')));
    }

    /*
    |--------------------------------------------------------------------------
    | Getter errors untuk ditampilkan controller
    |--------------------------------------------------------------------------
    */
    public function getRowErrors(): array
    {
        return $this->rowErrors;
    }
}