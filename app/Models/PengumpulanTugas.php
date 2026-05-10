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

    // ── Konstanta Status ───────────────────────────────────────────────────────
    // Sesuai ENUM di DB: 'belum_dikumpulkan','dikumpulkan','terlambat','dinilai'
    const STATUS_BELUM       = 'belum_dikumpulkan';
    const STATUS_DIKUMPULKAN = 'dikumpulkan';
    const STATUS_TERLAMBAT   = 'terlambat';
    const STATUS_DINILAI     = 'dinilai';

    // ── Fillable ───────────────────────────────────────────────────────────────
    // DIPERBAIKI: nama kolom disesuaikan dengan struktur DB aktual.
    // DB punya: path_file, jawaban_teks, url_link
    // DB TIDAK punya: file_pengumpulan, konten_teks, link_pengumpulan,
    //                 jenis_pengumpulan, catatan
    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'path_file',        // FIX: bukan 'file_pengumpulan'
        'jawaban_teks',     // FIX: bukan 'konten_teks'
        'url_link',         // FIX: bukan 'link_pengumpulan'
        'nilai',
        'umpan_balik',
        'status',
        'dikumpulkan_pada',
        'dinilai_pada',
    ];

    protected function casts(): array
    {
        return [
            'nilai'            => 'decimal:2',
            'dikumpulkan_pada' => 'datetime',
            'dinilai_pada'     => 'datetime',
            'tugas_id'         => 'integer',
            'siswa_id'         => 'integer',
        ];
    }

    // ── Business Logic ──────────────────────────────────────────────────────────

    public function isTerlambat(): bool
    {
        if (! $this->dikumpulkan_pada) {
            return false;
        }

        $tugas = $this->relationLoaded('tugas')
            ? $this->tugas
            : $this->load('tugas')->tugas;

        if (! $tugas || ! $tugas->batas_waktu) {
            return false;
        }

        return $this->dikumpulkan_pada->isAfter($tugas->batas_waktu);
    }

    public function beriNilai(float $nilai, ?string $umpanBalik = null): void
    {
        $this->update([
            'nilai'        => $nilai,
            'umpan_balik'  => $umpanBalik,
            'status'       => self::STATUS_DINILAI,
            'dinilai_pada' => now(),
        ]);
    }

    public function kembalikanPenilaian(): void
    {
        $statusSebelum = $this->isTerlambat()
            ? self::STATUS_TERLAMBAT
            : self::STATUS_DIKUMPULKAN;

        $this->update([
            'nilai'        => null,
            'umpan_balik'  => null,
            'status'       => $statusSebelum,
            'dinilai_pada' => null,
        ]);
    }

    public function sudahDinilai(): bool
    {
        return $this->status === self::STATUS_DINILAI;
    }

    // FIX: nama kolom path_file
    public function hapusFile(): void
    {
        if ($this->path_file && Storage::disk('public')->exists($this->path_file)) {
            Storage::disk('public')->delete($this->path_file);
        }
    }

    // ── Accessors ───────────────────────────────────────────────────────────────

    // FIX: pakai kolom path_file (sesuai DB)
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
            default                  => ucfirst(str_replace('_', ' ', $this->status ?? '')),
        };
    }

    // FIX: jenis diambil dari relasi tugas (tidak ada kolom jenis_pengumpulan di tabel ini)
    public function getLabelJenisAttribute(): string
    {
        $jenis = $this->relationLoaded('tugas')
            ? $this->tugas?->jenis_pengumpulan
            : $this->load('tugas')->tugas?->jenis_pengumpulan;

        return match ($jenis) {
            'file'  => 'File',
            'teks'  => 'Teks',
            'link'  => 'Link',
            'semua' => 'Semua Format',
            default => ucfirst($jenis ?? '-'),
        };
    }

    // ── Relationships ────────────────────────────────────────────────────────────

    public function tugas(): BelongsTo
    {
        return $this->belongsTo(Tugas::class);
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}