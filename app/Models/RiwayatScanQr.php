<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatScanQr extends Model
{
    use HasFactory;

    protected $table = 'riwayat_scan_qr';

    protected $fillable = [
        'sesi_qr_id',
        'siswa_id',
        'absensi_id',
        'latitude',
        'longitude',
        'jarak_meter',
        'status',
        'keterangan',
        'user_agent',
        'di_scan_pada',
    ];

    protected function casts(): array
    {
        return [
            'latitude'    => 'decimal:8',
            'longitude'   => 'decimal:8',
            'di_scan_pada'=> 'datetime',
        ];
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function isValid(): bool
    {
        return $this->status === 'valid';
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'valid'                  => 'Berhasil',
            'ditolak_radius'         => 'Ditolak: Di luar radius',
            'ditolak_kadaluarsa'     => 'Ditolak: QR kadaluarsa',
            'ditolak_nonaktif'       => 'Ditolak: QR tidak aktif',
            'ditolak_duplikat'       => 'Ditolak: Sudah scan',
            'ditolak_bukan_anggota'  => 'Ditolak: Bukan anggota kelas',
            default                  => ucfirst($this->status),
        };
    }

    public function isBerhasil(): bool
    {
        return $this->status === 'valid';
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
}