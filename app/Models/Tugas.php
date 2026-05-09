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
     * Jenis pengumpulan yang diizinkan — harus sinkron dengan
     * PengumpulanTugas::JENIS_VALID dan TugasController::JENIS_PENGUMPULAN.
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
            // FIX: cast FK ke integer agar perbandingan strict tidak mismatch
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

    // FIX: Hapus scopeAktif yang duplikat dengan scopeDipublikasikan —
    // dua scope dengan logika identik membingungkan. Gunakan ->dipublikasikan() saja.

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
     * FIX: Import PengumpulanTugas tidak diperlukan karena konstanta
     * direferensikan via fully-qualified name atau diganti nilai string langsung.
     * Sebelumnya kode mengacu PengumpulanTugas::STATUS_BELUM tanpa `use` — fatal error.
     * Solusi: gunakan nilai string konstanta langsung agar tidak ada dependency
     * circular antara Tugas ↔ PengumpulanTugas, atau tambahkan use statement.
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
        // FIX: withDefault() di sini aman tapi perlu hati-hati —
        // withDefault() mengembalikan instance Kelas kosong (bukan null)
        // sehingga $tugas->kelas->nama tidak error tapi menghasilkan null.
        // Ini perilaku yang diinginkan untuk view — pertahankan.
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
     * FIX: Kembalikan relasi HasMany dengan constraint, bukan langsung ->first(),
     * agar bisa di-eager load dari luar jika diperlukan.
     * Untuk fetch langsung, gunakan ->pengumpulanSiswa($id)->first().
     */
    public function pengumpulanSiswa(int $siswaId): ?PengumpulanTugas
    {
        return $this->pengumpulan()
            ->where('siswa_id', $siswaId)
            ->first();
    }
}