<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ujian.php — Model Ujian yang diperluas.
 *
 * Tambahan relasi vs model lama:
 *   + soal()      → SoalUjian
 *   + sesi()      → SesiUjian (pengerjaan per siswa)
 *
 * Tambahan helper:
 *   + sudahDimulai(), sudahBerakhir(), getTotalSoalAttribute()
 *   + getTotalBobotAttribute(), getSiswaSelesaiAttribute()
 */
class Ujian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ujian';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
        'kelas_id',
        'tahun_ajaran_id',
        'judul',
        'jenis',           // ulangan_harian | uts | uas | kuis
        'tanggal',
        'jam_mulai',
        'durasi_menit',    // batas waktu pengerjaan
        'nilai_kkm',
        'acak_soal',       // boolean — soal diacak per siswa
        'acak_pilihan',    // boolean — urutan pilihan diacak
        'tampilkan_nilai', // boolean — siswa lihat nilai setelah selesai
        'maks_percobaan',  // int — berapa kali boleh mengulang (default 1)
        'keterangan',
        'status',          // draft | aktif | ditutup
    ];

    protected function casts(): array
    {
        return [
            'tanggal'         => 'date',
            'acak_soal'       => 'boolean',
            'acak_pilihan'    => 'boolean',
            'tampilkan_nilai' => 'boolean',
        ];
    }

    // ── Scopes ────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // ── Computed Attributes ───────────────────────────────────────

    public function getTotalSoalAttribute(): int
    {
        return $this->soal()->count();
    }

    public function getTotalBobotAttribute(): int
    {
        return (int) $this->soal()->sum('bobot');
    }

    public function getWaktuMulaiAttribute(): ?Carbon
    {
        if (!$this->tanggal || !$this->jam_mulai) return null;
        return Carbon::parse($this->tanggal->format('Y-m-d') . ' ' . $this->jam_mulai);
    }

    public function getWaktuBerakhirAttribute(): ?Carbon
    {
        return $this->waktu_mulai?->copy()->addMinutes($this->durasi_menit ?? 0);
    }

    public function sudahDimulai(): bool
    {
        return $this->waktu_mulai && Carbon::now()->gte($this->waktu_mulai);
    }

    public function sudahBerakhir(): bool
    {
        return $this->waktu_berakhir && Carbon::now()->gt($this->waktu_berakhir);
    }

    public function isLulus(float $nilai): bool
    {
        return $nilai >= $this->nilai_kkm;
    }

    /**
     * Cek apakah siswa boleh mengikuti ujian (belum melebihi maks_percobaan).
     */
    public function bolehIkut(int $siswaId): bool
    {
        $percobaan = $this->sesi()
            ->where('siswa_id', $siswaId)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->count();

        return $percobaan < ($this->maks_percobaan ?? 1);
    }

    public function getSesiSiswa(int $siswaId): ?SesiUjian
    {
        return $this->sesi()->where('siswa_id', $siswaId)->latest()->first();
    }

    // ── Relationships ─────────────────────────────────────────────

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    /** Daftar soal ujian ini, diurutkan nomor */
    public function soal()
    {
        return $this->hasMany(SoalUjian::class)->orderBy('nomor_soal');
    }

    /** Sesi pengerjaan semua siswa */
    public function sesi()
    {
        return $this->hasMany(SesiUjian::class);
    }

    /** Siswa yang sudah selesai mengerjakan */
    public function siswaSelesai()
    {
        return $this->sesi()->whereIn('status', ['selesai', 'habis_waktu']);
    }
}