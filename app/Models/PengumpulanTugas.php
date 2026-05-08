<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PengumpulanTugas extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_tugas';

    /**
     * Status enum yang valid:
     * belum_dikumpulkan | dikumpulkan | terlambat | sudah_dinilai
     */
    const STATUS_BELUM      = 'belum_dikumpulkan';
    const STATUS_DIKUMPULKAN = 'dikumpulkan';
    const STATUS_TERLAMBAT  = 'terlambat';
    const STATUS_DINILAI    = 'sudah_dinilai';

    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'path_file',
        'jawaban_teks',
        'url_link',
        'nilai',
        'umpan_balik',
        'status',
        'dikumpulkan_pada',
        'dinilai_pada',
    ];

    protected function casts(): array
    {
        return [
            'nilai'           => 'decimal:2',
            'dikumpulkan_pada'=> 'datetime',
            'dinilai_pada'    => 'datetime',
        ];
    }

    // ── Business Logic ─────────────────────────────────────────────────────────

    /**
     * Cek apakah pengumpulan ini terlambat.
     * SAFE: load relasi tugas terlebih dahulu jika belum ada.
     */
    public function isTerlambat(): bool
    {
        if (! $this->dikumpulkan_pada) {
            return false;
        }

        // Eager load jika belum
        $tugas = $this->relationLoaded('tugas') ? $this->tugas : $this->load('tugas')->tugas;

        if (! $tugas) {
            return false;
        }

        return $this->dikumpulkan_pada->isAfter($tugas->batas_waktu);
    }

    /**
     * Beri nilai pada pengumpulan ini.
     * Otomatis set status ke sudah_dinilai dan catat waktu penilaian.
     */
    public function beriNilai(float $nilai, ?string $umpanBalik = null): void
    {
        $this->update([
            'nilai'        => $nilai,
            'umpan_balik'  => $umpanBalik,
            'status'       => self::STATUS_DINILAI,
            'dinilai_pada' => now(),
        ]);
    }

    /**
     * Reset penilaian (kembalikan ke status sebelum dinilai).
     */
    public function kembalikanPenilaian(): void
    {
        $this->update([
            'nilai'        => null,
            'umpan_balik'  => null,
            'status'       => $this->isTerlambat() ? self::STATUS_TERLAMBAT : self::STATUS_DIKUMPULKAN,
            'dinilai_pada' => null,
        ]);
    }

    public function sudahDinilai(): bool
    {
        return $this->status === self::STATUS_DINILAI;
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getFileUrlAttribute(): ?string
    {
        return $this->path_file
            ? asset('storage/' . $this->path_file)
            : null;
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_BELUM       => 'Belum Dikumpulkan',
            self::STATUS_DIKUMPULKAN => 'Dikumpulkan',
            self::STATUS_TERLAMBAT   => 'Terlambat',
            self::STATUS_DINILAI     => 'Sudah Dinilai',
            default                  => ucfirst($this->status),
        };
    }

    // ── Relationships ──────────────────────────────────────────────────────────

    public function tugas(): BelongsTo
    {
        return $this->belongsTo(Tugas::class);
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}