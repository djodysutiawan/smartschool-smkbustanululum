<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalPelajaran extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pelajaran';

    protected $fillable = [
        'tahun_ajaran_id',
        'guru_id',
        'mata_pelajaran_id',
        'kelas_id',
        'ruang_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'pertemuan_ke',
        'sumber_jadwal',
        'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeHari($query, string $hari)
    {
        return $query->where('hari', $hari);
    }

    public function scopeHariIni($query)
    {
        $hariIndo = [
            'Sunday'    => 'minggu',
            'Monday'    => 'senin',
            'Tuesday'   => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday'  => 'kamis',
            'Friday'    => 'jumat',
            'Saturday'  => 'sabtu',
        ];
        return $query->where('hari', $hariIndo[now()->format('l')] ?? 'senin');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getDurasiMenitAttribute(): int
    {
        return (int) \Carbon\Carbon::parse($this->jam_mulai)
                                   ->diffInMinutes($this->jam_selesai);
    }

    public function getLabelAttribute(): string
    {
        return ucfirst($this->hari)
            . ' ' . substr($this->jam_mulai, 0, 5)
            . '–' . substr($this->jam_selesai, 0, 5);
    }

    // ── Business Logic ────────────────────────────────────────────────────────

    /**
     * Cek apakah jadwal ini sedang berlangsung saat ini.
     */
    public function isSedangBerlangsung(): bool
    {
        $hariIndo = [
            'Sunday'    => 'minggu',
            'Monday'    => 'senin',
            'Tuesday'   => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday'  => 'kamis',
            'Friday'    => 'jumat',
            'Saturday'  => 'sabtu',
        ];
        $hariIni = $hariIndo[now()->format('l')] ?? '';
        if ($this->hari !== $hariIni) return false;

        $now = now()->format('H:i');
        return $now >= substr($this->jam_mulai, 0, 5)
            && $now <= substr($this->jam_selesai, 0, 5);
    }

    /**
     * Cek apakah sudah ada sesi QR aktif untuk jadwal ini hari ini.
     */
    public function hasSesiQrAktifHariIni(): bool
    {
        return $this->sesiQr()
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->exists();
    }

    /**
     * Ambil sesi QR aktif hari ini (jika ada).
     */
    public function getSesiQrAktifHariIni(): ?SesiQr
    {
        return $this->sesiQr()
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->latest()
            ->first();
    }

    /**
     * Hitung total pertemuan yang sudah terjadi (ada sesi QR atau absensi).
     */
    public function getTotalPertemuanAttribute(): int
    {
        return $this->sesiQr()->count();
    }

    /**
     * Hitung persentase kehadiran kelas untuk jadwal ini.
     */
    public function getPersentaseKehadiranKelasAttribute(): float
    {
        $total  = $this->absensi()->count();
        $hadir  = $this->absensi()->whereIn('status', ['hadir', 'telat'])->count();
        return $total > 0 ? round($hadir / $total * 100, 1) : 0;
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(Ruang::class);
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function sesiQr(): HasMany
    {
        return $this->hasMany(SesiQr::class);
    }

    public function jurnal(): HasMany
    {
        return $this->hasMany(JurnalMengajar::class);
    }
}