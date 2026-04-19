<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsensiGuru extends Model
{
    use HasFactory;

    protected $table = 'absensi_guru';

    protected $fillable = [
        'guru_id',
        'dicatat_oleh',
        'jadwal_piket_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'metode',
        'keterangan',
        'path_surat_izin',
    ];

    protected $casts = [
        'tanggal'    => 'date',
        'jam_masuk'  => 'datetime:H:i',
        'jam_keluar' => 'datetime:H:i',
    ];

    // ─── Konstanta ────────────────────────────────────────────────────────────

    const STATUS_LIST = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];
    const METODE_LIST = ['manual', 'qr'];

    const LABEL_STATUS = [
        'hadir' => 'Hadir',
        'telat' => 'Telat',
        'izin'  => 'Izin',
        'sakit' => 'Sakit',
        'alfa'  => 'Alfa',
    ];

    const BADGE_STATUS = [
        'hadir' => 'success',
        'telat' => 'warning',
        'izin'  => 'info',
        'sakit' => 'secondary',
        'alfa'  => 'danger',
    ];

    // ─── Relasi ───────────────────────────────────────────────────────────────

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function pencatat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }

    public function jadwalPiket(): BelongsTo
    {
        return $this->belongsTo(JadwalPiketGuru::class, 'jadwal_piket_id');
    }

    // ─── Scope ────────────────────────────────────────────────────────────────

    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal', today());
    }

    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal', now()->month)
                     ->whereYear('tanggal', now()->year);
    }

    public function scopeHadir($query)
    {
        return $query->whereIn('status', ['hadir', 'telat']);
    }

    public function scopeTidakHadir($query)
    {
        return $query->whereIn('status', ['izin', 'sakit', 'alfa']);
    }

    // ─── Accessor ─────────────────────────────────────────────────────────────

    public function getLabelStatusAttribute(): string
    {
        return self::LABEL_STATUS[$this->status] ?? $this->status;
    }

    public function getBadgeStatusAttribute(): string
    {
        return self::BADGE_STATUS[$this->status] ?? 'secondary';
    }
}