<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPiket extends Model
{
    use HasFactory;

    protected $table = 'log_piket';

    protected $fillable = [
        'pengguna_id', 'guru_id', 'tanggal', 'shift', 'masuk_pada', 'keluar_pada', 'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'    => 'date',
            'masuk_pada' => 'datetime',
            'keluar_pada'=> 'datetime',
        ];
    }

    public function getDurasiAttribute(): ?int
    {
        if (!$this->masuk_pada || !$this->keluar_pada) return null;
        return (int) $this->masuk_pada->diffInMinutes($this->keluar_pada);
    }

    public function isSedangBertugas(): bool
    {
        return $this->masuk_pada && !$this->keluar_pada;
    }

    public function checkOut(): void
    {
        $this->update(['keluar_pada' => now()]);
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
