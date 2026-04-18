<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'kategori_pelanggaran';

    protected $fillable = [
        'nama', 'deskripsi', 'tingkat', 'poin_default', 'batas_poin', 'warna', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeTingkat($query, string $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }

    public function getWarnaHexAttribute(): string
    {
        return $this->warna ?? match ($this->tingkat) {
            'berat'  => '#dc2626',
            'sedang' => '#f59e0b',
            default  => '#3b82f6',
        };
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }
}
