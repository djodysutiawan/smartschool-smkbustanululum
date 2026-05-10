<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'judul', 'isi', 'path_lampiran', 'target_role', 'kadaluarsa_pada',
        'dipinned', 'dibuat_oleh', 'dipublikasikan_oleh', 'dipublikasikan_pada',
    ];

    protected function casts(): array
    {
        return [
            'dipublikasikan_pada' => 'datetime',
            'kadaluarsa_pada'     => 'datetime',
            'dipinned'            => 'boolean',
        ];
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Hanya pengumuman yang sudah dipublikasikan (dipublikasikan_pada not null
     * dan waktunya sudah lewat / sama dengan sekarang).
     */
    public function scopeDipublikasikan($query)
    {
        return $query->whereNotNull('dipublikasikan_pada')
                     ->where('dipublikasikan_pada', '<=', now());
    }

    /**
     * Filter berdasarkan target role; selalu sertakan target 'semua'.
     */
    public function scopeUntukRole($query, string $role)
    {
        return $query->where(function ($q) use ($role) {
            $q->where('target_role', $role)
              ->orWhere('target_role', 'semua');
        });
    }

    /**
     * Hanya pengumuman yang belum kadaluarsa.
     */
    public function scopeBelumKadaluarsa($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('kadaluarsa_pada')
              ->orWhere('kadaluarsa_pada', '>', now());
        });
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    /**
     * Apakah pengumuman sudah dipublikasikan.
     */
    public function getDipublikasikanAttribute(): bool
    {
        return $this->dipublikasikan_pada !== null
            && $this->dipublikasikan_pada->isPast();
    }

    /**
     * Apakah pengumuman sudah kadaluarsa.
     */
    public function getKadaluarsaAttribute(): bool
    {
        return $this->kadaluarsa_pada !== null
            && $this->kadaluarsa_pada->isPast();
    }

    /**
     * URL lampiran yang aman (null jika tidak ada).
     */
    public function getLampiranUrlAttribute(): ?string
    {
        return $this->path_lampiran
            ? asset('storage/' . $this->path_lampiran)
            : null;
    }

    // -------------------------------------------------------------------------
    // Actions
    // -------------------------------------------------------------------------

    public function publish(int $olehId): void
    {
        $this->update([
            'dipublikasikan_oleh' => $olehId,
            'dipublikasikan_pada' => now(),
        ]);
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function dipublikasikanOleh()
    {
        return $this->belongsTo(User::class, 'dipublikasikan_oleh');
    }
}