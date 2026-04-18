<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilihanJawaban extends Model
{
    use HasFactory;

    protected $table = 'pilihan_jawaban';

    protected $fillable = [
        'soal_ujian_id',
        'kode_pilihan',
        'teks_pilihan',
        'gambar_pilihan',
        'adalah_benar',
    ];

    protected function casts(): array
    {
        return [
            'adalah_benar' => 'boolean',
        ];
    }

    public function getGambarPilihanUrlAttribute(): ?string
    {
        return $this->gambar_pilihan
            ? asset('storage/' . $this->gambar_pilihan)
            : null;
    }

    // ── Relationships ─────────────────────────────────────────────

    public function soal()
    {
        return $this->belongsTo(SoalUjian::class, 'soal_ujian_id');
    }
}