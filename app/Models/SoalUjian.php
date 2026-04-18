<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalUjian extends Model
{
    use HasFactory;

    protected $table = 'soal_ujian';

    protected $fillable = [
        'ujian_id',
        'nomor_soal',
        'jenis_soal',
        'pertanyaan',
        'gambar_soal',
        'bobot',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'bobot'    => 'integer',
        ];
    }

    // ── Accessors ────────────────────────────────────────────────

    public function getGambarSoalUrlAttribute(): ?string
    {
        return $this->gambar_soal
            ? asset('storage/' . $this->gambar_soal)
            : null;
    }

    public function isPilihanGanda(): bool
    {
        return $this->jenis_soal === 'pilihan_ganda';
    }

    public function isEssay(): bool
    {
        return $this->jenis_soal === 'essay';
    }

    public function isBenarSalah(): bool
    {
        return $this->jenis_soal === 'benar_salah';
    }

    /**
     * Apakah soal ini bisa dikoreksi otomatis?
     * Essay harus dikoreksi manual oleh guru.
     */
    public function bisaAutoCorrect(): bool
    {
        return in_array($this->jenis_soal, ['pilihan_ganda', 'benar_salah']);
    }

    public function getJawabanBenarAttribute(): ?PilihanJawaban
    {
        return $this->pilihan()->where('adalah_benar', true)->first();
    }

    // ── Relationships ─────────────────────────────────────────────

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function pilihan()
    {
        return $this->hasMany(PilihanJawaban::class)->orderBy('kode_pilihan');
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswa::class);
    }
}