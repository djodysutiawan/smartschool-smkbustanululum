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

    // ─── Hari mapping (Carbon/PHP dayOfWeek → nama hari Indonesia) ────────────
    // Diperlukan karena Carbon::dayName bergantung pada locale system yang tidak
    // selalu bisa di-set secara konsisten di semua environment.

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
     * Dapatkan nama hari Indonesia berdasarkan tanggal.
     */
    public static function getNamaHari(?Carbon $tanggal = null): string
    {
        $tanggal = $tanggal ?? now();
        return self::$hariMap[$tanggal->dayOfWeek] ?? 'senin';
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeHari($query, string $hari)
    {
        return $query->where('hari', $hari);
    }

    // ─── Static helpers ───────────────────────────────────────────────────────

    /**
     * Ambil jadwal piket yang aktif untuk hari ini.
     * Menggunakan mapping manual agar tidak bergantung locale Carbon.
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
     */
    public function getDurasiMenitAttribute(): ?int
    {
        if (! $this->jam_mulai || ! $this->jam_selesai) {
            return null;
        }
        $mulai   = Carbon::parse($this->jam_mulai);
        $selesai = Carbon::parse($this->jam_selesai);
        return (int) $mulai->diffInMinutes($selesai);
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