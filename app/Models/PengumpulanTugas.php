<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_tugas';

    protected $fillable = [
        'tugas_id', 'siswa_id', 'path_file', 'jawaban_teks', 'url_link',
        'nilai', 'umpan_balik', 'status', 'dikumpulkan_pada', 'dinilai_pada',
    ];

    protected function casts(): array
    {
        return [
            'nilai'           => 'decimal:2',
            'dikumpulkan_pada'=> 'datetime',
            'dinilai_pada'    => 'datetime',
        ];
    }

    public function isTerlambat(): bool
    {
        if (!$this->dikumpulkan_pada) return false;
        return $this->dikumpulkan_pada->isAfter($this->tugas->batas_waktu);
    }

    public function beriNilai(float $nilai, ?string $umpanBalik = null): void
    {
        $this->update([
            'nilai'       => $nilai,
            'umpan_balik' => $umpanBalik,
            'status'      => 'sudah_dinilai',
            'dinilai_pada'=> now(),
        ]);
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->path_file ? asset('storage/' . $this->path_file) : null;
    }

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
