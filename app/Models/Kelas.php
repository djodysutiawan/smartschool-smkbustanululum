<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'jurusan_id',
        'kode_kelas',
        'wali_kelas_id',
        'ruang_id',
        'tahun_ajaran_id',
        'kapasitas_maks',
        'status',
    ];

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeTingkat($query, string $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }

    public function scopeUntukJurusan($query, int $jurusanId)
    {
        return $query->where('jurusan_id', $jurusanId);
    }

    public function scopeTahunAjaran($query, int $tahunAjaranId)
    {
        return $query->where('tahun_ajaran_id', $tahunAjaranId);
    }

    // ── Accessors / Helpers ───────────────────────────────────────────────────

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    public function isSudahPenuh(): bool
    {
        return $this->siswa()->count() >= $this->kapasitas_maks;
    }

    public function getSisaKapasitasAttribute(): int
    {
        return max(0, $this->kapasitas_maks - $this->siswa()->count());
    }

    public function getLabelAttribute(): string
    {
        return $this->nama_kelas . ' (' . $this->tingkat . ')';
    }

    /**
     * Cari kelas tujuan untuk naik tingkat (X→XI, XI→XII).
     * Mencari kelas dengan jurusan yang sama di tahun ajaran tujuan.
     */
    public function getKelasTujuanNaikKelas(int $tahunAjaranTujuanId): ?self
    {
        $tingkatBerikutnya = match ($this->tingkat) {
            'X'  => 'XI',
            'XI' => 'XII',
            default => null,
        };

        if (! $tingkatBerikutnya) return null;

        return static::where('tingkat', $tingkatBerikutnya)
            ->where('jurusan_id', $this->jurusan_id)
            ->where('tahun_ajaran_id', $tahunAjaranTujuanId)
            ->where('status', 'aktif')
            ->first();
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(Ruang::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    public function jadwalPelajaran(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class);
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function materi(): HasMany
    {
        return $this->hasMany(Materi::class);
    }

    public function tugas(): HasMany
    {
        return $this->hasMany(Tugas::class);
    }

    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    public function sesiQr(): HasMany
    {
        return $this->hasMany(SesiQr::class);
    }

    /**
     * Semua riwayat perpindahan siswa yang pernah masuk kelas ini.
     */
    public function riwayatSiswa(): HasMany
    {
        return $this->hasMany(RiwayatKelasSiswa::class);
    }

    /**
     * Detail kenaikan kelas di mana kelas ini menjadi kelas ASAL.
     */
    public function kenaikanKelasDetailAsal(): HasMany
    {
        return $this->hasMany(KenaikanKelasDetail::class, 'kelas_asal_id');
    }

    /**
     * Detail kenaikan kelas di mana kelas ini menjadi kelas TUJUAN.
     */
    public function kenaikanKelasDetailTujuan(): HasMany
    {
        return $this->hasMany(KenaikanKelasDetail::class, 'kelas_tujuan_id');
    }
}