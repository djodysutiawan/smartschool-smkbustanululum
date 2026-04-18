<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'siswa_id', 'mata_pelajaran_id', 'guru_id', 'kelas_id', 'tahun_ajaran_id',
        'nilai_tugas', 'nilai_harian', 'nilai_uts', 'nilai_uas', 'nilai_akhir', 'predikat', 'catatan',
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

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            $model->hitungNilaiAkhir();
            $model->tentukanPredikat();
        });
    }

    public function hitungNilaiAkhir(): void
    {
        $tugas   = $this->nilai_tugas  ?? 0;
        $harian  = $this->nilai_harian ?? 0;
        $uts     = $this->nilai_uts    ?? 0;
        $uas     = $this->nilai_uas    ?? 0;

        $this->nilai_akhir = round(($tugas * 0.2) + ($harian * 0.3) + ($uts * 0.2) + ($uas * 0.3), 2);
    }

    public function tentukanPredikat(): void
    {
        $nilai = $this->nilai_akhir ?? 0;
        $this->predikat = match (true) {
            $nilai >= 90 => 'A',
            $nilai >= 80 => 'B',
            $nilai >= 70 => 'C',
            $nilai >= 60 => 'D',
            default      => 'E',
        };
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
