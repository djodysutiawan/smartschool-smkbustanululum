<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
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

class SiswaImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure, WithBatchInserts, WithChunkReading
{
    use SkipsErrors, SkipsFailures;

    protected array $kelasCache = [];
    protected array $tahunCache = [];

    public function model(array $row): ?Siswa
    {
        // Skip duplikat NIS
        if (Siswa::withTrashed()->where('nis', $row['nis'])->exists()) {
            return null;
        }

        // Resolve kelas_id dari nama kelas
        $kelasId = $this->resolveKelas($row['kelas'] ?? '');
        $tahunId = $this->resolveTahunAjaran($row['tahun_ajaran'] ?? '');

        if (!$kelasId) return null;

        return new Siswa([
            'nis'              => $row['nis'],
            'nisn'             => $row['nisn'] ?? null,
            'nama_lengkap'     => $row['nama_lengkap'],
            'jenis_kelamin'    => $this->parseJk($row['jenis_kelamin'] ?? ''),
            'tempat_lahir'     => $row['tempat_lahir'] ?? null,
            'tanggal_lahir'    => $this->parseDate($row['tanggal_lahir'] ?? null),
            'agama'            => $row['agama'] ?? null,
            'no_hp'            => $row['no_hp'] ?? null,
            'email'            => $row['email'] ?? null,
            'alamat'           => $row['alamat'] ?? null,
            'kelas_id'         => $kelasId,
            'tahun_ajaran_id'  => $tahunId,
            'status'           => $this->parseStatus($row['status'] ?? 'Aktif'),
            'tanggal_masuk'    => $this->parseDate($row['tanggal_masuk'] ?? null),
            'nama_ayah'        => $row['nama_ayah'] ?? null,
            'pekerjaan_ayah'   => $row['pekerjaan_ayah'] ?? null,
            'no_hp_ayah'       => $row['no_hp_ayah'] ?? null,
            'nama_ibu'         => $row['nama_ibu'] ?? null,
            'pekerjaan_ibu'    => $row['pekerjaan_ibu'] ?? null,
            'no_hp_ibu'        => $row['no_hp_ibu'] ?? null,
            'nama_wali'        => $row['nama_wali'] ?? null,
            'hubungan_wali'    => $row['hubungan_wali'] ?? null,
            'no_hp_wali'       => $row['no_hp_wali'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nis'          => 'required|string',
            'nama_lengkap' => 'required|string|max:150',
        ];
    }

    public function batchSize(): int { return 100; }
    public function chunkSize(): int { return 100; }

    private function resolveKelas(string $nama): ?int
    {
        $nama = trim($nama);
        if (empty($nama)) return null;
        if (isset($this->kelasCache[$nama])) return $this->kelasCache[$nama];
        $kelas = Kelas::where('nama_kelas', $nama)->first();
        return $this->kelasCache[$nama] = $kelas?->id;
    }

    private function resolveTahunAjaran(string $val): ?int
    {
        $val = trim($val);
        if (empty($val)) {
            // Ambil tahun ajaran terbaru jika kosong
            return TahunAjaran::latest('id')->value('id');
        }
        if (isset($this->tahunCache[$val])) return $this->tahunCache[$val];
        $ta = TahunAjaran::where('tahun', 'like', "%{$val}%")->first();
        return $this->tahunCache[$val] = $ta?->id;
    }

    private function parseJk(string $val): string
    {
        return in_array(strtolower(trim($val)), ['l', 'laki-laki', 'laki', 'male']) ? 'L' : 'P';
    }

    private function parseStatus(string $val): string
    {
        $map = [
            'aktif'       => 'aktif',
            'active'      => 'aktif',
            'tidak aktif' => 'tidak_aktif',
            'nonaktif'    => 'tidak_aktif',
            'lulus'       => 'lulus',
            'pindah'      => 'pindah',
            'keluar'      => 'keluar',
        ];
        return $map[strtolower(trim($val))] ?? 'aktif';
    }

    private function parseDate($val): ?string
    {
        if (empty($val)) return null;
        try {
            if (is_numeric($val)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($val)->format('Y-m-d');
            }
            return Carbon::parse(str_replace('/', '-', $val))->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}