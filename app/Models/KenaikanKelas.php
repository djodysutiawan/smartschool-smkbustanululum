<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KenaikanKelas extends Model
{
    use HasFactory;

    protected $table = 'kenaikan_kelas';

    protected $fillable = [
        'tahun_ajaran_asal_id',
        'tahun_ajaran_tujuan_id',
        'dari_tingkat',
        'ke_tingkat',
        'diproses_oleh',
        'diproses_pada',
        'status',
        'total_siswa',
        'naik_kelas',
        'tidak_naik',
        'lulus',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'diproses_pada' => 'datetime',
            'total_siswa'   => 'integer',
            'naik_kelas'    => 'integer',
            'tidak_naik'    => 'integer',
            'lulus'         => 'integer',
        ];
    }

    // ── Enum constants ────────────────────────────────────────────────────────

    /**
     * PERBAIKAN: Tambah STATUS_DRAFT yang ada di migrasi DB tapi tidak di model.
     * Migrasi: ENUM('draft','diproses','selesai','dibatalkan')
     */
    public const STATUS_DRAFT      = 'draft';
    public const STATUS_DIPROSES   = 'diproses';
    public const STATUS_SELESAI    = 'selesai';
    public const STATUS_DIBATALKAN = 'dibatalkan';

    // ── Business Logic ────────────────────────────────────────────────────────

    public function isDraft(): bool      { return $this->status === self::STATUS_DRAFT; }
    public function isDiproses(): bool   { return $this->status === self::STATUS_DIPROSES; }
    public function isSelesai(): bool    { return $this->status === self::STATUS_SELESAI; }
    public function isDibatalkan(): bool { return $this->status === self::STATUS_DIBATALKAN; }

    /**
     * PERBAIKAN: bisaDibatalkan() sebelumnya hanya cek isDiproses().
     * Status 'draft' juga harus bisa dibatalkan karena belum ada data yang diubah.
     * Hanya 'selesai' yang tidak bisa dibatalkan (sudah mengubah data siswa).
     */
    public function bisaDibatalkan(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_DIPROSES]);
    }

    /**
     * Apakah batch sudah final (tidak bisa diubah lagi).
     */
    public function isFinal(): bool
    {
        return in_array($this->status, [self::STATUS_SELESAI, self::STATUS_DIBATALKAN]);
    }

    public function getLabelTingkatAttribute(): string
    {
        $ke = $this->ke_tingkat === 'lulus' ? 'Lulus' : "Kelas {$this->ke_tingkat}";
        return "Kelas {$this->dari_tingkat} → {$ke}";
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT      => 'Draft',
            self::STATUS_DIPROSES   => 'Sedang Diproses',
            self::STATUS_SELESAI    => 'Selesai',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
            default                 => ucfirst($this->status),
        };
    }

    /**
     * Badge warna untuk tampilan di view.
     */
    public function getBadgeStatusAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT      => 'secondary',
            self::STATUS_DIPROSES   => 'warning',
            self::STATUS_SELESAI    => 'success',
            self::STATUS_DIBATALKAN => 'danger',
            default                 => 'secondary',
        };
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function tahunAjaranAsal(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_asal_id');
    }

    public function tahunAjaranTujuan(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_tujuan_id');
    }

    public function diprosesOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(KenaikanKelasDetail::class);
    }

    public function detailNaik(): HasMany
    {
        return $this->hasMany(KenaikanKelasDetail::class)
            ->where('keputusan', KenaikanKelasDetail::KEPUTUSAN_NAIK_KELAS);
    }

    public function detailTidakNaik(): HasMany
    {
        return $this->hasMany(KenaikanKelasDetail::class)
            ->where('keputusan', KenaikanKelasDetail::KEPUTUSAN_TIDAK_NAIK);
    }

    public function detailLulus(): HasMany
    {
        return $this->hasMany(KenaikanKelasDetail::class)
            ->where('keputusan', KenaikanKelasDetail::KEPUTUSAN_LULUS);
    }
}