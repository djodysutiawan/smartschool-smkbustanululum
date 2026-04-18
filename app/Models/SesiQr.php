<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SesiQr extends Model
{
    use HasFactory;

    protected $table = 'sesi_qr';

    protected $fillable = [
        'kelas_id', 'mata_pelajaran_id', 'dibuat_oleh', 'kode_qr',
        'tanggal', 'berlaku_mulai', 'kadaluarsa_pada', 'radius_meter', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'        => 'date',
            'berlaku_mulai'  => 'datetime',
            'kadaluarsa_pada'=> 'datetime',
            'is_active'      => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            $model->kode_qr ??= Str::uuid()->toString();
        });
    }

    public function isValid(): bool
    {
        return $this->is_active
            && now()->between($this->berlaku_mulai, $this->kadaluarsa_pada);
    }

    public function isKadaluarsa(): bool
    {
        return now()->isAfter($this->kadaluarsa_pada);
    }

    public function nonaktifkan(): void
    {
        $this->update(['is_active' => false]);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function riwayatScan()
    {
        return $this->hasMany(RiwayatScanQr::class);
    }
}
