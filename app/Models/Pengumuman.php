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

    /**
     * Sudah dipublikasikan = dipublikasikan_pada tidak null.
     * (Kolom boolean 'dipublikasikan' tidak ada di tabel)
     */
    public function scopeDipublikasikan($query)
    {
        return $query->whereNotNull('dipublikasikan_pada');
    }

    public function scopeUntukRole($query, string $role)
    {
        return $query->where(function ($q) use ($role) {
            $q->where('target_role', $role)->orWhere('target_role', 'semua');
        });
    }

    /**
     * Cek apakah pengumuman sudah dipublikasikan (helper accessor).
     */
    public function getDipublikasikanAttribute(): bool
    {
        return $this->dipublikasikan_pada !== null;
    }

    public function publish(int $olehId): void
    {
        $this->update([
            'dipublikasikan_oleh' => $olehId,
            'dipublikasikan_pada' => now(),
        ]);
    }

    public function getLampiranUrlAttribute(): ?string
    {
        return $this->path_lampiran ? asset('storage/' . $this->path_lampiran) : null;
    }

    public function dipublikasikanOleh()
    {
        return $this->belongsTo(User::class, 'dipublikasikan_oleh');
    }

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}