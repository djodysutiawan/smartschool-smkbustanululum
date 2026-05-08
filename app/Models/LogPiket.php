<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPiket extends Model
{
    use HasFactory;

    protected $table = 'log_piket';

    protected $fillable = [
        'pengguna_id',
        'guru_id',
        'tanggal',
        'shift',
        'masuk_pada',
        'keluar_pada',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'     => 'date',
            'masuk_pada'  => 'datetime',
            'keluar_pada' => 'datetime',
        ];
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    /**
     * Durasi bertugas dalam menit.
     * Null jika belum check-out atau belum check-in.
     */
    public function getDurasiAttribute(): ?int
    {
        if (! $this->masuk_pada || ! $this->keluar_pada) {
            return null;
        }
        return (int) $this->masuk_pada->diffInMinutes($this->keluar_pada);
    }

    /**
     * Durasi dalam format H jam M menit (human-readable).
     */
    public function getDurasiFormatAttribute(): ?string
    {
        $menit = $this->durasi;
        if ($menit === null) {
            return null;
        }
        $jam   = intdiv($menit, 60);
        $sisa  = $menit % 60;
        return $jam > 0 ? "{$jam} jam {$sisa} menit" : "{$sisa} menit";
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Apakah guru sedang bertugas (sudah check-in, belum check-out).
     */
    public function isSedangBertugas(): bool
    {
        return (bool) $this->masuk_pada && ! $this->keluar_pada;
    }

    /**
     * Catat check-out dengan waktu sekarang.
     */
    public function checkOut(): void
    {
        if (! $this->masuk_pada) {
            throw new \LogicException('Guru belum melakukan check-in.');
        }
        if ($this->keluar_pada) {
            throw new \LogicException('Guru sudah melakukan check-out sebelumnya.');
        }
        $this->update(['keluar_pada' => now()]);
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}