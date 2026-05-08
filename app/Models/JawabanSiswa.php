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
            'adalah_benar' => 'boolean',
            'poin_didapat' => 'decimal:2',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Boot — Auto Correct untuk PG & benar_salah
    |--------------------------------------------------------------------------
    |
    | Hanya dijalankan jika:
    | 1. Ada pilihan_jawaban_id (bukan essay)
    | 2. Relasi soal berhasil di-load (safety check)
    | 3. Jenis soal mendukung auto correct
    |
    */
    public static function boot(): void
    {
        parent::boot();

        static::saving(function (self $model) {
            // Hanya auto correct jika pilihan diisi
            if (! $model->pilihan_jawaban_id) {
                return;
            }

            // Load relasi soal jika belum ada (hindari lazy loading error)
            $soal = $model->relationLoaded('soal')
                ? $model->soal
                : SoalUjian::find($model->soal_ujian_id);

            if (! $soal || ! $soal->bisaAutoCorrect()) {
                return;
            }

            $pilihan = PilihanJawaban::find($model->pilihan_jawaban_id);
            if (! $pilihan) {
                return;
            }

            $benar = $pilihan->adalah_benar;
            $model->adalah_benar  = $benar;
            $model->poin_didapat  = $benar ? $soal->bobot : 0;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Auto Correct (dapat dipanggil manual jika perlu)
    |--------------------------------------------------------------------------
    */
    public function autoCorrect(): void
    {
        if (! $this->pilihan_jawaban_id) return;

        $soal = $this->soal ?? SoalUjian::find($this->soal_ujian_id);
        if (! $soal || ! $soal->bisaAutoCorrect()) return;

        $pilihan = PilihanJawaban::find($this->pilihan_jawaban_id);
        if (! $pilihan) return;

        $benar = $pilihan->adalah_benar;
        $this->update([
            'adalah_benar' => $benar,
            'poin_didapat' => $benar ? $soal->bobot : 0,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Koreksi Manual Essay oleh Guru / Admin
    |--------------------------------------------------------------------------
    |
    | $poin       : nilai yang diberikan guru (0 s/d bobot soal)
    | $catatan    : feedback / komentar guru (opsional)
    |
    | Setelah koreksi, sesi dihitung ulang nilainya secara otomatis.
    |
    */
    public function koreksiEssay(float $poin, ?string $catatan = null): void
    {
        // Load soal jika belum
        $soal = $this->relationLoaded('soal')
            ? $this->soal
            : SoalUjian::find($this->soal_ujian_id);

        abort_if(! $soal, 404, 'Soal tidak ditemukan.');
        abort_if($soal->jenis_soal !== 'essay', 422, 'Koreksi manual hanya untuk soal essay.');

        // Clamp poin ke rentang valid
        $maxPoin = (float) $soal->bobot;
        $poin    = max(0, min($poin, $maxPoin));

        $this->update([
            'adalah_benar'    => $maxPoin > 0 && ($poin / $maxPoin) >= 0.6, // >= 60% bobot = benar
            'poin_didapat'    => $poin,
            'catatan_koreksi' => $catatan,
        ]);

        // Recalculate nilai sesi setelah koreksi
        $sesi = $this->relationLoaded('sesi')
            ? $this->sesi
            : SesiUjian::find($this->sesi_ujian_id);

        $sesi?->hitungNilai();
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Apakah jawaban ini sudah dikoreksi (baik auto maupun manual)?
     */
    public function sudahDikoreksi(): bool
    {
        return ! is_null($this->poin_didapat);
    }

    /**
     * Apakah jawaban ini adalah essay yang belum dikoreksi?
     */
    public function essayBelumDikoreksi(): bool
    {
        $soal = $this->relationLoaded('soal') ? $this->soal : null;

        return $soal?->jenis_soal === 'essay' && is_null($this->poin_didapat);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

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