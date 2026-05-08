<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id',
        'guru_id',
        'kelas_id',
        'tahun_ajaran_id',
        'nilai_tugas',
        'nilai_harian',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'predikat',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'nilai_tugas'  => 'decimal:2',
            'nilai_harian' => 'decimal:2',
            'nilai_uts'    => 'decimal:2',
            'nilai_uas'    => 'decimal:2',
            'nilai_akhir'  => 'decimal:2',
        ];
    }

    // ── Booted ─────────────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            $model->hitungNilaiAkhir();
            $model->tentukanPredikat();
        });
    }

    // ── Business Logic ─────────────────────────────────────────────────────────

    /**
     * Hitung nilai akhir dengan bobot:
     * Tugas 20% | Harian 30% | UTS 20% | UAS 30%
     */
    public function hitungNilaiAkhir(): void
    {
        $tugas  = (float) ($this->nilai_tugas  ?? 0);
        $harian = (float) ($this->nilai_harian ?? 0);
        $uts    = (float) ($this->nilai_uts    ?? 0);
        $uas    = (float) ($this->nilai_uas    ?? 0);

        $this->nilai_akhir = round(
            ($tugas * 0.20) + ($harian * 0.30) + ($uts * 0.20) + ($uas * 0.30),
            2
        );
    }

    public function tentukanPredikat(): void
    {
        $nilai = (float) ($this->nilai_akhir ?? 0);

        $this->predikat = match (true) {
            $nilai >= 90 => 'A',
            $nilai >= 80 => 'B',
            $nilai >= 70 => 'C',
            $nilai >= 60 => 'D',
            default      => 'E',
        };
    }

    /**
     * Apakah nilai ini lulus (nilai_akhir >= KKM)?
     */
    public function isLulus(int $kkm = 70): bool
    {
        return (float) ($this->nilai_akhir ?? 0) >= $kkm;
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeByPredikat($query, string $predikat)
    {
        return $query->where('predikat', $predikat);
    }

    // ── Relationships ──────────────────────────────────────────────────────────

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}