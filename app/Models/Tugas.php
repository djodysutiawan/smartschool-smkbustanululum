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

    /**
     * Jenis pengumpulan yang diizinkan.
     * PERBAIKAN: Dijadikan konstanta tunggal agar TugasController dan
     * PengumpulanTugas bisa referensikan dari sini tanpa duplikasi.
     */
    const JENIS_PENGUMPULAN = ['file', 'teks', 'link', 'foto'];

    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
        'kelas_id',
        'tahun_ajaran_id',
        'judul',
        'deskripsi',
        'path_file_soal',
        'jenis_pengumpulan',
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
            'guru_id'           => 'integer',
            'mata_pelajaran_id' => 'integer',
            'kelas_id'          => 'integer',
            'tahun_ajaran_id'   => 'integer',
        ];
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeDipublikasikan($query)
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
     *
     * PERBAIKAN: Tambahkan 'use App\Models\PengumpulanTugas' di atas,
     * atau gunakan nilai string konstanta langsung untuk menghindari
     * fatal error karena class PengumpulanTugas tidak di-import.
     * Menggunakan string literal 'belum' lebih aman dari dependency circular.
     */
    public function sudahDikumpulkan(int $siswaId): bool
    {
        return $this->pengumpulan()
            ->where('siswa_id', $siswaId)
            ->where('status', '!=', 'belum')
            ->exists();
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getFileSoalUrlAttribute(): ?string
    {
        return $this->path_file_soal
            ? asset('storage/' . $this->path_file_soal)
            : null;
    }

    /**
     * PERBAIKAN: Gunakan string literal konstanta status, bukan
     * PengumpulanTugas::STATUS_BELUM / STATUS_DINILAI (tidak ada 'use' statement,
     * fatal error saat dipanggil). Nilai string sesuai dengan konstanta di model
     * PengumpulanTugas yang harus sinkron.
     */
    public function getJumlahTerkumpulAttribute(): int
    {
        return $this->pengumpulan()
            ->where('status', '!=', 'belum')
            ->count();
    }

    public function getJumlahDinilaiAttribute(): int
    {
        return $this->pengumpulan()
            ->where('status', 'sudah_dinilai')
            ->count();
    }

    public function getSisaWaktuAttribute(): ?string
    {
        if ($this->isTelahBerakhir()) {
            return null;
        }
        return now()->diffForHumans($this->batas_waktu, true);
    }

    /**
     * Ambil satu pengumpulan milik siswa tertentu.
     * PERBAIKAN: Tidak ada return type hint relasi HasMany di sini —
     * ini adalah method biasa yang mengembalikan model atau null.
     * Relasi pengumpulan() sudah di-load via eager loading dari controller,
     * gunakan filter collection daripada query baru untuk hindari N+1.
     */
    public function pengumpulanSiswa(int $siswaId): ?PengumpulanTugas
    {
        // Jika relasi sudah di-load (eager loaded), pakai filter collection.
        if ($this->relationLoaded('pengumpulan')) {
            return $this->pengumpulan->firstWhere('siswa_id', $siswaId);
        }

        // Fallback: query langsung jika belum di-load.
        return $this->pengumpulan()
            ->where('siswa_id', $siswaId)
            ->first();
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
        // withDefault() aman untuk akses property di blade,
        // tapi JANGAN panggil ->siswa()->count() dari instance default ini.
        // Gunakan $tugas->kelas_id di controller (sudah diperbaiki).
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
}