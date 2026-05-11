<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPiketGuru extends Model
{
    use HasFactory;

    protected $table = 'jadwal_piket_guru';

    protected $fillable = [
        'guru_id',
        'tahun_ajaran_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'catatan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // ─── Hari mapping (Carbon dayOfWeek → nama hari Indonesia) ───────────────
    // Tidak bergantung pada locale system — aman di semua environment.

    private static array $hariMap = [
        0 => 'minggu',
        1 => 'senin',
        2 => 'selasa',
        3 => 'rabu',
        4 => 'kamis',
        5 => 'jumat',
        6 => 'sabtu',
    ];

    /**
     * Dapatkan nama hari Indonesia berdasarkan tanggal Carbon.
     * Fallback ke 'senin' jika dayOfWeek tidak dikenali (harusnya tidak terjadi).
     */
    public static function getNamaHari(?Carbon $tanggal = null): string
    {
        $tanggal ??= now();

        return self::$hariMap[$tanggal->dayOfWeek] ?? 'senin';
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeHari($query, string $hari)
    {
        return $query->where('hari', strtolower(trim($hari)));
    }

    // ─── Static helpers ───────────────────────────────────────────────────────

    /**
     * Ambil semua jadwal piket aktif untuk hari ini, eager-load guru.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getPiketHariIni()
    {
        $hari = self::getNamaHari(now());

        return static::aktif()
            ->hari($hari)
            ->with('guru')
            ->orderBy('jam_mulai')
            ->get();
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    /**
     * Durasi piket dalam menit.
     * Null jika jam_mulai atau jam_selesai kosong.
     */
    public function getDurasiMenitAttribute(): ?int
    {
        if (! $this->jam_mulai || ! $this->jam_selesai) {
            return null;
        }

        $mulai   = Carbon::parse($this->jam_mulai);
        $selesai = Carbon::parse($this->jam_selesai);

        $menit = (int) $mulai->diffInMinutes($selesai);

        // Jika selesai < mulai (melewati tengah malam), diffInMinutes masih benar
        // karena diffInMinutes selalu absolut — aman.
        return $menit;
    }

    /**
     * Durasi dalam format "Xj Ym" (ringkas, cocok untuk badge/chip).
     */
    public function getDurasiFormatPendekAttribute(): ?string
    {
        $menit = $this->durasiMenit;

        if ($menit === null) {
            return null;
        }

        $jam  = intdiv($menit, 60);
        $sisa = $menit % 60;

        if ($jam > 0 && $sisa > 0) {
            return "{$jam}j {$sisa}m";
        }

        return $jam > 0 ? "{$jam}j" : "{$sisa}m";
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}