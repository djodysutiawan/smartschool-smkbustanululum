<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatKelasSiswa extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kelas_siswa';

    /**
     * Kolom-kolom sesuai struktur tabel di database:
     * id, siswa_id, kelas_id, tahun_ajaran_id, tingkat,
     * status_akhir, tanggal_masuk_kelas, tanggal_keluar_kelas,
     * keterangan, dicatat_oleh, created_at, updated_at
     */
    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tahun_ajaran_id',
        'tingkat',
        'status_akhir',
        'tanggal_masuk_kelas',
        'tanggal_keluar_kelas',
        'keterangan',
        'dicatat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_masuk_kelas'  => 'date',
            'tanggal_keluar_kelas' => 'date',
        ];
    }

    // ── Enum values untuk status_akhir ────────────────────────────────────────
    // Sesuai ENUM di tabel: 'naik_kelas','tidak_naik','lulus','pindah_keluar','dikeluarkan','aktif'

    public const STATUS_AKTIF         = 'aktif';
    public const STATUS_NAIK_KELAS    = 'naik_kelas';
    public const STATUS_TIDAK_NAIK    = 'tidak_naik';
    public const STATUS_LULUS         = 'lulus';
    public const STATUS_PINDAH_KELUAR = 'pindah_keluar';
    public const STATUS_DIKELUARKAN   = 'dikeluarkan';

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('status_akhir', self::STATUS_AKTIF);
    }

    public function scopeTahunAjaran($query, int $tahunAjaranId)
    {
        return $query->where('tahun_ajaran_id', $tahunAjaranId);
    }

    public function scopeTingkat($query, string $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }

    // ── Accessors / Helpers ───────────────────────────────────────────────────

    public function isAktif(): bool
    {
        return $this->status_akhir === self::STATUS_AKTIF;
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status_akhir) {
            self::STATUS_AKTIF         => 'Aktif',
            self::STATUS_NAIK_KELAS    => 'Naik Kelas',
            self::STATUS_TIDAK_NAIK    => 'Tidak Naik',
            self::STATUS_LULUS         => 'Lulus',
            self::STATUS_PINDAH_KELUAR => 'Pindah/Keluar',
            self::STATUS_DIKELUARKAN   => 'Dikeluarkan',
            default                    => ucfirst($this->status_akhir),
        };
    }

    public function getDurasiAttribute(): ?int
    {
        if (! $this->tanggal_masuk_kelas) return null;
        $selesai = $this->tanggal_keluar_kelas ?? now()->toDate();
        return $this->tanggal_masuk_kelas->diffInDays($selesai);
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    /**
     * User yang mencatat riwayat ini (admin/guru).
     */
    public function dicatatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}