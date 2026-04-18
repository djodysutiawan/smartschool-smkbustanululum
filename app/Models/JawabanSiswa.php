<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    use HasFactory;

    protected $table = 'jawaban_siswa';

    protected $fillable = [
        'sesi_ujian_id',
        'soal_ujian_id',
        'pilihan_jawaban_id',
        'jawaban_essay',
        'adalah_benar',
        'poin_didapat',
        'catatan_koreksi',
    ];

    protected function casts(): array
    {
        return [
            'adalah_benar'  => 'boolean',
            'poin_didapat'  => 'decimal:2',
        ];
    }

    // ── Auto Correct ──────────────────────────────────────────────

    /**
     * Koreksi otomatis untuk soal PG dan benar/salah.
     * Dipanggil saat jawaban disimpan.
     */
    public static function boot(): void
    {
        parent::boot();

        static::saving(function (self $model) {
            if ($model->pilihan_jawaban_id && $model->soal) {
                $model->autoCorrect();
            }
        });
    }

    public function autoCorrect(): void
    {
        if (!$this->soal->bisaAutoCorrect()) return;

        $pilihan = PilihanJawaban::find($this->pilihan_jawaban_id);
        if (!$pilihan) return;

        $benar = $pilihan->adalah_benar;
        $this->adalah_benar = $benar;
        $this->poin_didapat = $benar ? $this->soal->bobot : 0;
    }

    /**
     * Koreksi manual essay oleh guru.
     */
    public function koreksiEssay(float $poin, ?string $catatan = null): void
    {
        $maxPoin = $this->soal->bobot;
        $poin    = min($poin, $maxPoin);

        $this->update([
            'adalah_benar'   => $poin >= ($maxPoin * 0.6), // >= 60% bobot = benar
            'poin_didapat'   => $poin,
            'catatan_koreksi'=> $catatan,
        ]);

        // Trigger recalculate sesi setelah koreksi
        $this->sesi->hitungNilai();
    }

    // ── Relationships ─────────────────────────────────────────────

    public function sesi()
    {
        return $this->belongsTo(SesiUjian::class, 'sesi_ujian_id');
    }

    public function soal()
    {
        return $this->belongsTo(SoalUjian::class, 'soal_ujian_id');
    }

    public function pilihan()
    {
        return $this->belongsTo(PilihanJawaban::class, 'pilihan_jawaban_id');
    }
}