<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatScanQr extends Model
{
    use HasFactory;

    protected $table = 'riwayat_scan_qr';

    protected $fillable = [
        'sesi_qr_id', 'siswa_id', 'dipindai_pada',
        'latitude', 'longitude', 'hasil', 'ip_address', 'info_perangkat',
    ];

    protected function casts(): array
    {
        return [
            'dipindai_pada' => 'datetime',
            'latitude'      => 'decimal:8',
            'longitude'     => 'decimal:8',
        ];
    }

    public function isberhasil(): bool
    {
        return $this->hasil === 'berhasil';
    }

    public function hitungJarakMeter(float $latRef, float $lonRef): float
    {
        if (!$this->latitude || !$this->longitude) return PHP_FLOAT_MAX;
        $earthRadius = 6371000;
        $dLat = deg2rad($this->latitude - $latRef);
        $dLon = deg2rad($this->longitude - $lonRef);
        $a = sin($dLat/2)**2 + cos(deg2rad($latRef)) * cos(deg2rad($this->latitude)) * sin($dLon/2)**2;
        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    public function sesiQr()
    {
        return $this->belongsTo(SesiQr::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
