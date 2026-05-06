<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gedung extends Model
{
    use HasFactory;

    protected $table = 'gedung';

    protected $fillable = [
        'kode_gedung',
        'nama_gedung',
        'jumlah_lantai',
        'deskripsi',
        'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────
    // CATATAN: accessor ini hanya untuk kebutuhan serialisasi JSON / API.
    // Di Blade gunakan $gedung->ruang->count() atau withCount('ruang')
    // agar tidak terjadi N+1 query.

    public function getTotalRuangAttribute(): int
    {
        // Jika relasi sudah di-load (eager), pakai collection — tidak query ulang
        if ($this->relationLoaded('ruang')) {
            return $this->ruang->count();
        }

        return $this->ruang()->count();
    }

    public function getTotalRuangTersediaAttribute(): int
    {
        if ($this->relationLoaded('ruang')) {
            return $this->ruang->where('status', 'tersedia')->count();
        }

        return $this->ruangTersedia()->count();
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function ruang(): HasMany
    {
        return $this->hasMany(Ruang::class);
    }

    public function ruangTersedia(): HasMany
    {
        return $this->hasMany(Ruang::class)->where('status', 'tersedia');
    }
}