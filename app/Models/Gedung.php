<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AbsensiGuru;

class Gedung extends Model
{
    use HasFactory;

    protected $table = 'gedung';

    protected $fillable = [
        'kode_gedung', 'nama_gedung', 'jumlah_lantai', 'deskripsi', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function ruang()
    {
        return $this->hasMany(Ruang::class);
    }

    public function ruangTersedia()
    {
        return $this->ruang()->where('status', 'tersedia');
    }

    public function absensiGuru(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AbsensiGuru::class, 'guru_id');
    }

}
