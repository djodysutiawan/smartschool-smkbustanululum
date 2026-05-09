<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'kategori_pelanggaran';

    protected $fillable = [
        'nama',
        'deskripsi',
        'tingkat',
        'poin_default',
        'batas_poin',
        'warna',
        'is_active',
    ];

    /** Nilai tingkat yang diizinkan. */
    const TINGKAT_RINGAN = 'ringan';
    const TINGKAT_SEDANG = 'sedang';
    const TINGKAT_BERAT  = 'berat';

    const TINGKATS = [
        self::TINGKAT_RINGAN,
        self::TINGKAT_SEDANG,
        self::TINGKAT_BERAT,
    ];

    protected function casts(): array
    {
        return [
            'is_active'   => 'boolean',
            'poin_default'=> 'integer',
            'batas_poin'  => 'integer',
        ];
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeTingkat(Builder $query, string $tingkat): Builder
    {
        return $query->where('tingkat', $tingkat);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Kembalikan warna hex berdasarkan kolom `warna` atau fallback dari tingkat.
     * Diubah menjadi accessor Laravel 9+ style agar bisa di-append dengan benar.
     */
    public function getWarnaHexAttribute(): string
    {
        if (! empty($this->warna)) {
            return $this->warna;
        }

        return match ($this->tingkat) {
            self::TINGKAT_BERAT  => '#dc2626',
            self::TINGKAT_SEDANG => '#f59e0b',
            default              => '#3b82f6',  // ringan / null
        };
    }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function pelanggaran(): HasMany
    {
        return $this->hasMany(Pelanggaran::class, 'kategori_pelanggaran_id');
    }
}