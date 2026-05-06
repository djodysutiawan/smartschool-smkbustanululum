<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KenaikanKelasDetail extends Model
{
    use HasFactory;

    protected $table = 'kenaikan_kelas_detail';

    /**
     * Kolom-kolom sesuai struktur tabel di database:
     * id, kenaikan_kelas_id, siswa_id, kelas_asal_id, kelas_tujuan_id,
     * keputusan (enum: naik_kelas, tidak_naik, lulus),
     * rata_rata_nilai (decimal 5,2), total_hadir (smallint),
     * total_pertemuan (smallint), persentase_kehadiran (decimal 5,2),
     * memenuhi_syarat_nilai (tinyint/boolean),
     * memenuhi_syarat_kehadiran (tinyint/boolean),
     * catatan (text), created_at, updated_at
     */
    protected $fillable = [
        'kenaikan_kelas_id',
        'siswa_id',
        'kelas_asal_id',
        'kelas_tujuan_id',
        'keputusan',
        'rata_rata_nilai',
        'total_hadir',
        'total_pertemuan',
        'persentase_kehadiran',
        'memenuhi_syarat_nilai',
        'memenuhi_syarat_kehadiran',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            // TINYINT(1) di MySQL otomatis terbaca sebagai boolean di Laravel
            'memenuhi_syarat_nilai'     => 'boolean',
            'memenuhi_syarat_kehadiran' => 'boolean',
            // DECIMAL(5,2) — cast ke float agar bisa dihitung langsung
            'rata_rata_nilai'           => 'decimal:2',
            'persentase_kehadiran'      => 'decimal:2',
            // SMALLINT
            'total_hadir'               => 'integer',
            'total_pertemuan'           => 'integer',
        ];
    }

    // ── Enum constants ────────────────────────────────────────────────────────

    public const KEPUTUSAN_NAIK_KELAS = 'naik_kelas';
    public const KEPUTUSAN_TIDAK_NAIK = 'tidak_naik';
    public const KEPUTUSAN_LULUS      = 'lulus';

    // ── Accessors / Helpers ───────────────────────────────────────────────────

    public function isNaikKelas(): bool
    {
        return $this->keputusan === self::KEPUTUSAN_NAIK_KELAS;
    }

    public function isTidakNaik(): bool
    {
        return $this->keputusan === self::KEPUTUSAN_TIDAK_NAIK;
    }

    public function isLulus(): bool
    {
        return $this->keputusan === self::KEPUTUSAN_LULUS;
    }

    public function getLabelKeputusanAttribute(): string
    {
        return match ($this->keputusan) {
            self::KEPUTUSAN_NAIK_KELAS => 'Naik Kelas',
            self::KEPUTUSAN_TIDAK_NAIK => 'Tidak Naik',
            self::KEPUTUSAN_LULUS      => 'Lulus',
            default                    => ucfirst($this->keputusan),
        };
    }

    /**
     * True jika siswa memenuhi SEMUA syarat (nilai dan kehadiran).
     */
    public function memenuhiSemuaSyarat(): bool
    {
        return $this->memenuhi_syarat_nilai && $this->memenuhi_syarat_kehadiran;
    }

    /**
     * Persentase kehadiran dalam format string (misal: "85.50%").
     */
    public function getPersentaseKehadiranFormatAttribute(): string
    {
        return number_format((float) $this->persentase_kehadiran, 2) . '%';
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function kenaikanKelas(): BelongsTo
    {
        return $this->belongsTo(KenaikanKelas::class);
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelasAsal(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_asal_id');
    }

    /**
     * Kelas tujuan bisa null jika siswa tidak naik atau lulus
     * tanpa kelas tujuan yang ditentukan.
     */
    public function kelasTujuan(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_tujuan_id');
    }
}