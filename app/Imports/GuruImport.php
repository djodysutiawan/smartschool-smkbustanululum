<?php

namespace App\Imports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;

class GuruImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure, WithBatchInserts, WithChunkReading
{
    use SkipsErrors, SkipsFailures;

    public function model(array $row): ?Guru
    {
        // Cek duplikat NIP
        if (!empty($row['nip']) && Guru::where('nip', $row['nip'])->exists()) {
            return null;
        }

        return new Guru([
            'nip'                 => $row['nip'] ?? null,
            'nama_lengkap'        => $row['nama_lengkap'],
            'jenis_kelamin'       => $this->parseJk($row['jenis_kelamin'] ?? ''),
            'tempat_lahir'        => $row['tempat_lahir'] ?? null,
            'tanggal_lahir'       => $this->parseDate($row['tanggal_lahir'] ?? null),
            'no_hp'               => $row['no_hp'] ?? null,
            'email'               => $row['email'] ?? null,
            'alamat'              => $row['alamat'] ?? null,
            'pendidikan_terakhir' => strtolower($row['pendidikan_terakhir'] ?? null),
            'jurusan_pendidikan'  => $row['jurusan'] ?? null,
            'universitas'         => $row['universitas'] ?? null,
            'tahun_lulus'         => $row['tahun_lulus'] ?? null,
            'status_kepegawaian'  => strtolower($row['status_kepegawaian'] ?? 'honorer'),
            'tanggal_masuk'       => $this->parseDate($row['tanggal_masuk'] ?? null),
            'adalah_guru_piket'   => $this->parseBool($row['guru_piket'] ?? 'Tidak'),
            'status'              => $this->parseStatus($row['status'] ?? 'Aktif'),
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:150',
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    private function parseJk(string $val): string
    {
        $val = strtolower(trim($val));
        return in_array($val, ['l', 'laki-laki', 'laki', 'male']) ? 'L' : 'P';
    }

    private function parseBool(string $val): bool
    {
        return in_array(strtolower(trim($val)), ['ya', 'yes', '1', 'true']);
    }

    private function parseStatus(string $val): string
    {
        $map = [
            'aktif'      => 'aktif',
            'active'     => 'aktif',
            'tidak aktif'=> 'tidak_aktif',
            'nonaktif'   => 'tidak_aktif',
            'cuti'       => 'cuti',
        ];
        return $map[strtolower(trim($val))] ?? 'aktif';
    }

    private function parseDate($val): ?string
    {
        if (empty($val)) return null;
        try {
            // Handle Excel serial date number
            if (is_numeric($val)) {
                return Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($val)->format('Y-m-d'))->format('Y-m-d');
            }
            return Carbon::parse(str_replace('/', '-', $val))->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}