<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatScanGuru extends Model
{
    use HasFactory;

    protected $table = 'riwayat_scan_guru';

    protected $fillable = [
        'sesi_qr_guru_id',
        'guru_id',
        'dipindai_pada',
        'hasil',
        'latitude',
        'longitude',
        'ip_address',
        'info_perangkat',
    ];

    protected $casts = [
        'dipindai_pada' => 'datetime',
        'latitude'      => 'decimal:7',
        'longitude'     => 'decimal:7',
    ];

    // ─── Konstanta ────────────────────────────────────────────────────────────

    const HASIL_LIST = [
        'berhasil',
        'gagal_kadaluarsa',
        'gagal_lokasi',
        'gagal_duplikat',
    ];

    const LABEL_HASIL = [
        'berhasil'          => 'Berhasil',
        'gagal_kadaluarsa'  => 'Gagal - Kadaluarsa',
        'gagal_lokasi'      => 'Gagal - Lokasi',
        'gagal_duplikat'    => 'Gagal - Duplikat',
    ];

    const BADGE_HASIL = [
        'berhasil'         => 'success',
        'gagal_kadaluarsa' => 'warning',
        'gagal_lokasi'     => 'danger',
        'gagal_duplikat'   => 'secondary',
    ];

    // ─── Relasi ───────────────────────────────────────────────────────────────

    public function sesiQrGuru(): BelongsTo
    {
        return $this->belongsTo(SesiQrGuru::class, 'sesi_qr_guru_id');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    // ─── Scope ────────────────────────────────────────────────────────────────

    public function scopeBerhasil($query)
    {
        return $query->where('hasil', 'berhasil');
    }

    public function scopeHariIni($query)
    {
        return $query->whereDate('dipindai_pada', today());
    }

    // ─── Accessor ─────────────────────────────────────────────────────────────

    public function getLabelHasilAttribute(): string
    {
        return self::LABEL_HASIL[$this->hasil] ?? $this->hasil;
    }

    public function getBadgeHasilAttribute(): string
    {
        return self::BADGE_HASIL[$this->hasil] ?? 'secondary';
    }
}