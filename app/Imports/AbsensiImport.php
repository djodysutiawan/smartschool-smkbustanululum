<?php

namespace App\Imports;
 
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
 
class AbsensiImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, WithBatchInserts, WithChunkReading
{
    use SkipsErrors;
 
    private int $rowCount = 0;
 
    /**
     * Mapping satu baris Excel ke model Absensi.
     */
    public function model(array $row): ?Absensi
    {
        // Cari siswa berdasarkan NIS
        $siswa = Siswa::where('nis', $row['siswa_nis'])->first();
        if (!$siswa) return null;
 
        // Cari kelas berdasarkan nama
        $kelas = Kelas::where('nama_kelas', $row['kelas_nama'])->first();
        if (!$kelas) return null;
 
        // Cegah duplikat (unique: siswa_id + tanggal + kelas_id)
        $exists = Absensi::where('siswa_id', $siswa->id)
            ->where('kelas_id', $kelas->id)
            ->whereDate('tanggal', $row['tanggal'])
            ->exists();
 
        if ($exists) return null;
 
        $this->rowCount++;
 
        return new Absensi([
            'siswa_id'    => $siswa->id,
            'kelas_id'    => $kelas->id,
            'tanggal'     => $row['tanggal'],
            'status'      => strtolower($row['status']),
            'metode'      => strtolower($row['metode'] ?? 'manual'),
            'jam_masuk'   => $row['jam_masuk'] ?: null,
            'jam_keluar'  => $row['jam_keluar'] ?: null,
            'keterangan'  => $row['keterangan'] ?: null,
            'dicatat_oleh'=> Auth::id(),
        ]);
    }
 
    public function rules(): array
    {
        return [
            'siswa_nis' => ['required'],
            'kelas_nama' => ['required'],
            'tanggal'   => ['required', 'date'],
            'status'    => ['required', 'in:hadir,telat,izin,sakit,alfa'],
            'metode'    => ['nullable', 'in:manual,qr'],
            'jam_masuk' => ['nullable'],
            'jam_keluar'=> ['nullable'],
        ];
    }
 
    public function customValidationMessages(): array
    {
        return [
            'status.in'  => 'Status harus salah satu dari: hadir, telat, izin, sakit, alfa.',
            'metode.in'  => 'Metode harus salah satu dari: manual, qr.',
            'tanggal.date' => 'Format tanggal tidak valid. Gunakan YYYY-MM-DD.',
        ];
    }
 
    public function batchSize(): int
    {
        return 500;
    }
 
    public function chunkSize(): int
    {
        return 500;
    }
 
    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
 