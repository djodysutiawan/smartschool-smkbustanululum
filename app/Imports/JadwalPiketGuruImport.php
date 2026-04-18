<?php
// ============================================================
// File: app/Imports/JadwalPiketGuruImport.php
// ============================================================

namespace App\Imports;

use App\Models\JadwalPiketGuru;
use App\Models\Guru;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Throwable;

class JadwalPiketGuruImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    protected array $errors = [];

    public function model(array $row): ?JadwalPiketGuru
    {
        $guru = Guru::where('nama_lengkap', trim($row['guru_piket'] ?? ''))
            ->orWhere('nip', trim($row['nip'] ?? ''))
            ->first();

        if (!$guru) {
            $this->errors[] = "Guru tidak ditemukan: " . ($row['guru_piket'] ?? '-');
            return null;
        }

        $tahunAjaran = TahunAjaran::where('tahun', trim($row['tahun_ajaran'] ?? ''))->first();

        if (!$tahunAjaran) {
            $this->errors[] = "Tahun ajaran tidak ditemukan: " . ($row['tahun_ajaran'] ?? '-');
            return null;
        }

        $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        $hari     = strtolower(trim($row['hari'] ?? ''));

        if (!in_array($hari, $hariList)) {
            $this->errors[] = "Hari tidak valid untuk baris guru: " . ($row['guru_piket'] ?? '-');
            return null;
        }

        return new JadwalPiketGuru([
            'guru_id'         => $guru->id,
            'tahun_ajaran_id' => $tahunAjaran->id,
            'hari'            => $hari,
            'jam_mulai'       => $row['jam_mulai'] ?? '07:00',
            'jam_selesai'     => $row['jam_selesai'] ?? '12:00',
            'catatan'         => $row['catatan'] ?? null,
            'is_active'       => strtolower($row['status'] ?? 'aktif') === 'aktif',
        ]);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}