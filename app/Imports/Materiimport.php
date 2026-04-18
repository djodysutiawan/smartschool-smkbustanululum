<?php

namespace App\Imports;

use App\Models\Materi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class MateriImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnError, WithBatchInserts, WithChunkReading
{
    use SkipsErrors;

    protected array $errors = [];
    protected int $imported = 0;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            try {
                $data = $this->mapRow($row->toArray());

                if (empty($data['judul'])) {
                    continue;
                }

                Materi::create($data);
                $this->imported++;
            } catch (\Throwable $e) {
                $this->errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                Log::warning('MateriImport error at row ' . ($index + 2), ['error' => $e->getMessage()]);
            }
        }

        if (!empty($this->errors)) {
            throw new \Exception(implode("\n", array_slice($this->errors, 0, 5)));
        }
    }

    protected function mapRow(array $row): array
    {
        $dipublikasikan = isset($row['dipublikasikan_10'])
            ? (bool) $row['dipublikasikan_10']
            : (isset($row['dipublikasikan']) ? (bool) $row['dipublikasikan'] : false);

        return [
            'guru_id'           => (int) ($row['guru_id'] ?? 0),
            'mata_pelajaran_id' => (int) ($row['mata_pelajaran_id'] ?? 0),
            'kelas_id'          => (int) ($row['kelas_id'] ?? 0),
            'tahun_ajaran_id'   => (int) ($row['tahun_ajaran_id'] ?? 0),
            'judul'             => trim($row['judul'] ?? ''),
            'deskripsi'         => !empty($row['deskripsi']) ? trim($row['deskripsi']) : null,
            'jenis'             => strtolower(trim($row['jenis_filevideolinktek'] ?? $row['jenis'] ?? 'teks')),
            'url_eksternal'     => !empty($row['url_eksternal']) ? trim($row['url_eksternal']) : null,
            'urutan'            => isset($row['urutan']) ? (int) $row['urutan'] : 0,
            'dipublikasikan'    => $dipublikasikan,
            'dipublikasikan_pada' => $dipublikasikan ? now() : null,
        ];
    }

    public function rules(): array
    {
        return [
            '*.guru_id'           => ['required', 'integer', 'exists:guru,id'],
            '*.mata_pelajaran_id' => ['required', 'integer', 'exists:mata_pelajaran,id'],
            '*.kelas_id'          => ['required', 'integer', 'exists:kelas,id'],
            '*.tahun_ajaran_id'   => ['required', 'integer', 'exists:tahun_ajaran,id'],
            '*.judul'             => ['required', 'string', 'max:255'],
            '*.jenis'             => ['required', Rule::in(['file', 'video', 'link', 'teks'])],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            '*.guru_id.required'           => 'Kolom guru_id wajib diisi.',
            '*.guru_id.exists'             => 'ID guru tidak ditemukan di sistem.',
            '*.mata_pelajaran_id.required' => 'Kolom mata_pelajaran_id wajib diisi.',
            '*.mata_pelajaran_id.exists'   => 'ID mata pelajaran tidak ditemukan di sistem.',
            '*.kelas_id.required'          => 'Kolom kelas_id wajib diisi.',
            '*.kelas_id.exists'            => 'ID kelas tidak ditemukan di sistem.',
            '*.tahun_ajaran_id.required'   => 'Kolom tahun_ajaran_id wajib diisi.',
            '*.tahun_ajaran_id.exists'     => 'ID tahun ajaran tidak ditemukan di sistem.',
            '*.judul.required'             => 'Kolom judul wajib diisi.',
            '*.jenis.required'             => 'Kolom jenis wajib diisi.',
            '*.jenis.in'                   => 'Nilai jenis harus salah satu dari: file, video, link, teks.',
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 200;
    }

    public function getImportedCount(): int
    {
        return $this->imported;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}