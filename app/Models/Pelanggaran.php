<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran';

    protected $fillable = [
        'siswa_id',
        'dicatat_oleh',
        'kategori_pelanggaran_id',
        'poin',
        'deskripsi',
        'tanggal',
        'tindakan',
        'status',
        'diselesaikan_pada', // kolom timestamp eksplisit untuk kapan status = selesai
    ];

    /**
     * Daftar status yang valid.
     * Gunakan konstanta ini agar tidak ada typo di mana pun.
     */
    const STATUS_PENDING     = 'pending';
    const STATUS_DIPROSES    = 'diproses';
    const STATUS_SELESAI     = 'selesai';
    const STATUS_BANDING     = 'banding';
    const STATUS_DIBATALKAN  = 'dibatalkan';

    const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_DIPROSES,
        self::STATUS_SELESAI,
        self::STATUS_BANDING,
        self::STATUS_DIBATALKAN,
    ];

    /** Status yang dihitung sebagai pelanggaran aktif (poin ikut terhitung). */
    const STATUSES_AKTIF = [
        self::STATUS_PENDING,
        self::STATUS_DIPROSES,
        self::STATUS_SELESAI,
        self::STATUS_BANDING,
    ];

    protected function casts(): array
    {
        return [
            'tanggal'          => 'date',
            'poin'             => 'integer',
            'diselesaikan_pada'=> 'datetime',
        ];
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    /** Hanya pelanggaran yang masih aktif (poin terhitung). */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->whereNotIn('status', [self::STATUS_DIBATALKAN]);
    }

    /** Poin aktif siswa pada tahun tertentu. */
    public function scopePoinAktifTahun(Builder $query, int $tahun): Builder
    {
        return $query->aktif()->whereYear('tanggal', $tahun);
    }

    // ── Domain actions ────────────────────────────────────────────────────────

    /**
     * Tandai pelanggaran sebagai selesai.
     * Menyimpan timestamp penyelesaian secara eksplisit agar
     * tidak bergantung pada `updated_at` yang bisa berubah karena
     * alasan lain.
     */
    public function selesaikan(string $tindakan): void
    {
        $this->update([
            'status'            => self::STATUS_SELESAI,
            'tindakan'          => $tindakan,
            'diselesaikan_pada' => now(),
        ]);
    }

    public function batalkan(): void
    {
        $this->update(['status' => self::STATUS_DIBATALKAN]);
    }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function dicatatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPelanggaran::class, 'kategori_pelanggaran_id');
    }
}