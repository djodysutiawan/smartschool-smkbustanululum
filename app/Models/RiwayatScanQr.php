<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatScanQr extends Model
{
    use HasFactory;

    protected $table = 'riwayat_scan_qr';

    /*
    |--------------------------------------------------------------------------
    | SKEMA KOLOM TABEL riwayat_scan_qr  (sesuai DB screenshot)
    |--------------------------------------------------------------------------
    | id           bigint PK
    | sesi_qr_id   bigint FK → sesi_qr.id
    | siswa_id     bigint FK → siswa.id
    | absensi_id   bigint FK → absensi.id (nullable)
    | di_scan_pada timestamp                        ← nama kolom ASLI di DB
    | latitude     decimal(10,8) nullable
    | longitude    decimal(11,8) nullable
    | jarak_meter  smallint(5) nullable
    | hasil        enum('berhasil','gagal_kadaluarsa','gagal_lokasi','gagal_duplikat')
    | status       enum('valid','ditolak_radius','ditolak_kadaluarsa',
    |                   'ditolak_nonaktif','ditolak_duplikat','ditolak_bukan_anggota')
    | keterangan   varchar(255) nullable
    | ip_address   varchar(45) nullable
    | user_agent   text nullable
    | created_at   timestamp
    | updated_at   timestamp
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'sesi_qr_id',
        'siswa_id',
        'absensi_id',
        'di_scan_pada',
        'latitude',
        'longitude',
        'jarak_meter',
        'hasil',
        'status',
        'keterangan',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'latitude'     => 'decimal:8',
            'longitude'    => 'decimal:8',
            'jarak_meter'  => 'float',
            'di_scan_pada' => 'datetime',
        ];
    }

    // ── Konstanta Status ──────────────────────────────────────────────────────

    public const STATUS_VALID                 = 'valid';
    public const STATUS_DITOLAK_RADIUS        = 'ditolak_radius';
    public const STATUS_DITOLAK_KADALUARSA    = 'ditolak_kadaluarsa';
    public const STATUS_DITOLAK_NONAKTIF      = 'ditolak_nonaktif';
    public const STATUS_DITOLAK_DUPLIKAT      = 'ditolak_duplikat';
    public const STATUS_DITOLAK_BUKAN_ANGGOTA = 'ditolak_bukan_anggota';

    public static function statusList(): array
    {
        return [
            self::STATUS_VALID,
            self::STATUS_DITOLAK_RADIUS,
            self::STATUS_DITOLAK_KADALUARSA,
            self::STATUS_DITOLAK_NONAKTIF,
            self::STATUS_DITOLAK_DUPLIKAT,
            self::STATUS_DITOLAK_BUKAN_ANGGOTA,
        ];
    }

    // ── Accessor / Helper ─────────────────────────────────────────────────────

    /** Apakah scan ini valid/berhasil? */
    public function isValid(): bool
    {
        return $this->status === self::STATUS_VALID;
    }

    /** Alias isValid() — dipakai di view blade. */
    public function isBerhasil(): bool
    {
        return $this->isValid();
    }

    // ── Accessor untuk kolom HASIL (enum berhasil|gagal_*) ───────────────────

    /**
     * Label human-readable untuk kolom hasil.
     * Dipakai di view: $r->label_hasil
     */
    public function getLabelHasilAttribute(): string
    {
        return match ($this->hasil) {
            'berhasil'          => 'Berhasil',
            'gagal_kadaluarsa'  => 'Gagal – Kadaluarsa',
            'gagal_lokasi'      => 'Gagal – Lokasi',
            'gagal_duplikat'    => 'Gagal – Duplikat',
            default             => ucfirst(str_replace('_', ' ', $this->hasil ?? '-')),
        };
    }

    /**
     * Label singkat untuk kolom hasil (dipakai di PDF export).
     * Dipakai di view: $r->label_hasil_singkat
     */
    public function getLabelHasilSingkatAttribute(): string
    {
        return match ($this->hasil) {
            'berhasil'          => 'Berhasil',
            'gagal_kadaluarsa'  => 'Kadaluarsa',
            'gagal_lokasi'      => 'Lokasi',
            'gagal_duplikat'    => 'Duplikat',
            default             => ucfirst(str_replace('_', ' ', $this->hasil ?? '-')),
        };
    }

    /**
     * CSS badge class berdasarkan kolom hasil.
     * Dipakai di view: $r->badge_class_hasil
     */
    public function getBadgeClassHasilAttribute(): string
    {
        return match ($this->hasil) {
            'berhasil'          => 'badge-berhasil',
            'gagal_kadaluarsa'  => 'badge-gagal-kadaluarsa',
            'gagal_lokasi'      => 'badge-gagal-lokasi',
            'gagal_duplikat'    => 'badge-gagal-duplikat',
            default             => 'badge-default',
        };
    }

    // ── Accessor untuk kolom STATUS (enum valid|ditolak_*) ────────────────────

    /**
     * Label human-readable untuk kolom status.
     * Dipakai di view: $r->label_status
     */
    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_VALID                 => 'Valid',
            self::STATUS_DITOLAK_RADIUS        => 'Ditolak: Di luar radius',
            self::STATUS_DITOLAK_KADALUARSA    => 'Ditolak: QR kadaluarsa',
            self::STATUS_DITOLAK_NONAKTIF      => 'Ditolak: QR tidak aktif',
            self::STATUS_DITOLAK_DUPLIKAT      => 'Ditolak: Sudah scan',
            self::STATUS_DITOLAK_BUKAN_ANGGOTA => 'Ditolak: Bukan anggota kelas',
            default                            => ucfirst(str_replace('_', ' ', $this->status ?? '')),
        };
    }

    /**
     * CSS badge class berdasarkan kolom status.
     * Dipakai di view: $r->badge_class_status
     */
    public function getBadgeClassStatusAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_VALID                 => 'badge-valid',
            self::STATUS_DITOLAK_RADIUS        => 'badge-ditolak-radius',
            self::STATUS_DITOLAK_KADALUARSA    => 'badge-ditolak-kadaluarsa',
            self::STATUS_DITOLAK_NONAKTIF      => 'badge-ditolak-nonaktif',
            self::STATUS_DITOLAK_DUPLIKAT      => 'badge-ditolak-duplikat',
            self::STATUS_DITOLAK_BUKAN_ANGGOTA => 'badge-ditolak-bukan-anggota',
            default                            => 'badge-default',
        };
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function sesiQr(): BelongsTo
    {
        return $this->belongsTo(SesiQr::class);
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function absensi(): BelongsTo
    {
        return $this->belongsTo(Absensi::class);
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    // ── Scopes ────────────────────────────────────────────────────────────────

    /** Scope berdasarkan kolom STATUS */
    public function scopeValid($query)
    {
        return $query->where('status', self::STATUS_VALID);
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', '!=', self::STATUS_VALID);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /** Scope berdasarkan kolom HASIL */
    public function scopeBerhasil($query)
    {
        return $query->where('hasil', 'berhasil');
    }

    public function scopeGagal($query)
    {
        return $query->where('hasil', '!=', 'berhasil');
    }

    public function scopeByHasil($query, string $hasil)
    {
        return $query->where('hasil', $hasil);
    }
}