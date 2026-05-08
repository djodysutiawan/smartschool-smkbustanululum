<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tugas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tugas';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
        'kelas_id',
        'tahun_ajaran_id',
        'judul',
        'deskripsi',
        'path_file_soal',
        'jenis_pengumpulan',   // file | teks | link | foto
        'batas_waktu',
        'nilai_maksimal',
        'izinkan_terlambat',
        'dipublikasikan',
    ];

    protected function casts(): array
    {
        return [
            'batas_waktu'       => 'datetime',
            'izinkan_terlambat' => 'boolean',
            'dipublikasikan'    => 'boolean',
            'nilai_maksimal'    => 'decimal:2',
        ];
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeDipublikasikan($query)
    {
        return $query->where('dipublikasikan', true);
    }

    public function scopeAktif($query)
    {
        return $query->where('dipublikasikan', true);
    }

    // ── Business Logic ─────────────────────────────────────────────────────────

    public function isTelahBerakhir(): bool
    {
        return now()->isAfter($this->batas_waktu);
    }

    public function isMasihBisaDikumpulkan(): bool
    {
        if (! $this->isTelahBerakhir()) {
            return true;
        }

        return (bool) $this->izinkan_terlambat;
    }

    /**
     * Cek apakah siswa tertentu sudah mengumpulkan tugas ini.
     */
    public function sudahDikumpulkan(int $siswaId): bool
    {
        return $this->pengumpulan()
            ->where('siswa_id', $siswaId)
            ->where('status', '!=', PengumpulanTugas::STATUS_BELUM)
            ->exists();
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getFileSoalUrlAttribute(): ?string
    {
        return $this->path_file_soal
            ? asset('storage/' . $this->path_file_soal)
            : null;
    }

    public function getJumlahTerkumpulAttribute(): int
    {
        return $this->pengumpulan()
            ->where('status', '!=', PengumpulanTugas::STATUS_BELUM)
            ->count();
    }

    public function getJumlahDinilaiAttribute(): int
    {
        return $this->pengumpulan()
            ->where('status', PengumpulanTugas::STATUS_DINILAI)
            ->count();
    }

    public function getSisaWaktuAttribute(): ?string
    {
        if ($this->isTelahBerakhir()) {
            return null;
        }

        return now()->diffForHumans($this->batas_waktu, true);
    }

    // ── Relationships ──────────────────────────────────────────────────────────

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class)->withDefault();
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function pengumpulan(): HasMany
    {
        return $this->hasMany(PengumpulanTugas::class);
    }

    /**
     * Ambil pengumpulan milik siswa tertentu (single record).
     */
    public function pengumpulanSiswa(int $siswaId): ?PengumpulanTugas
    {
        return $this->pengumpulan()
            ->where('siswa_id', $siswaId)
            ->first();
    }
}