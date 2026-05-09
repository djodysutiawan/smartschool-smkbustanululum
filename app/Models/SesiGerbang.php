<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model SesiGerbang
 * ─────────────────────────────────────────────────────────────────────────────
 * Satu sesi = satu periode buka gerbang (masuk atau pulang) dalam satu hari.
 * Guru piket membuka sesi → alat scanner mulai menerima scan → sesi ditutup.
 *
 * Satu hari normal: 2 sesi (masuk pagi + pulang sore).
 *
 * @property int         $id
 * @property int         $dibuka_oleh
 * @property int|null    $ditutup_oleh
 * @property string      $tipe          masuk|pulang
 * @property \Carbon\Carbon $tanggal
 * @property \Carbon\Carbon $dibuka_pada
 * @property \Carbon\Carbon|null $ditutup_pada
 * @property string      $status        aktif|ditutup
 * @property string|null $catatan
 */
class SesiGerbang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sesi_gerbang';

    protected $fillable = [
        'dibuka_oleh',
        'ditutup_oleh',
        'tipe',
        'tanggal',
        'dibuka_pada',
        'ditutup_pada',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'      => 'date',
            'dibuka_pada'  => 'datetime',
            'ditutup_pada' => 'datetime',
        ];
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    /** Sesi yang masih berjalan */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /** Sesi yang sudah ditutup */
    public function scopeDitutup($query)
    {
        return $query->where('status', 'ditutup');
    }

    /** Filter berdasarkan tipe */
    public function scopeMasuk($query)
    {
        return $query->where('tipe', 'masuk');
    }

    public function scopePulang($query)
    {
        return $query->where('tipe', 'pulang');
    }

    /** Sesi hari ini */
    public function scopeHariIni($query)
    {
        return $query->where('tanggal', now()->toDateString());
    }

    /** Sesi pada tanggal tertentu */
    public function scopeTanggal($query, string $tanggal)
    {
        return $query->where('tanggal', $tanggal);
    }

    /** Filter rentang tanggal */
    public function scopePeriode($query, string $dari, string $sampai)
    {
        return $query->whereBetween('tanggal', [$dari, $sampai]);
    }

    // ── Static Helpers ────────────────────────────────────────────────────────

    /**
     * Ambil sesi aktif saat ini (jika ada).
     * Prioritaskan yang paling baru dibuka.
     */
    public static function sesiAktifSekarang(): ?static
    {
        return static::aktif()
                     ->hariIni()
                     ->orderByDesc('dibuka_pada')
                     ->first();
    }

    /**
     * Apakah ada sesi aktif untuk tipe tertentu hari ini?
     */
    public static function adaSesiAktif(string $tipe): bool
    {
        return static::aktif()
                     ->hariIni()
                     ->where('tipe', $tipe)
                     ->exists();
    }

    // ── Actions ───────────────────────────────────────────────────────────────

    /**
     * Tutup sesi ini.
     *
     * @param  int  $ditutupOleh  user_id guru yang menutup
     * @param  string|null $catatan
     */
    public function tutup(int $ditutupOleh, ?string $catatan = null): bool
    {
        return $this->update([
            'status'       => 'ditutup',
            'ditutup_oleh' => $ditutupOleh,
            'ditutup_pada' => now(),
            'catatan'      => $catatan ?? $this->catatan,
        ]);
    }

    /**
     * Toggle tipe sesi: masuk ↔ pulang.
     * Hanya bisa dilakukan jika sesi masih aktif dan belum ada scan.
     *
     * @throws \RuntimeException jika sudah ada scan atau sesi sudah ditutup
     */
    public function toggleTipe(): bool
    {
        if ($this->status === 'ditutup') {
            throw new \RuntimeException('Sesi sudah ditutup, tipe tidak bisa diubah.');
        }

        if ($this->absensiGerbang()->exists()) {
            throw new \RuntimeException('Sudah ada data scan, tipe tidak bisa diubah.');
        }

        $this->tipe = $this->tipe === 'masuk' ? 'pulang' : 'masuk';
        return $this->save();
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getIsAktifAttribute(): bool
    {
        return $this->status === 'aktif';
    }

    public function getLabelTipeAttribute(): string
    {
        return $this->tipe === 'masuk' ? 'Masuk Pagi' : 'Pulang Sore';
    }

    public function getLabelStatusAttribute(): string
    {
        return $this->status === 'aktif' ? 'Aktif' : 'Ditutup';
    }

    /**
     * Durasi sesi dalam menit (null jika masih aktif).
     */
    public function getDurasiMenitAttribute(): ?int
    {
        if (! $this->ditutup_pada) return null;
        return (int) $this->dibuka_pada->diffInMinutes($this->ditutup_pada);
    }

    /**
     * Jumlah siswa yang sudah scan di sesi ini.
     * Hanya hitung status normal + manual (bukan duplikat).
     */
    public function getJumlahScanAttribute(): int
    {
        return $this->absensiGerbang()
                    ->whereIn('status', ['normal', 'manual', 'koreksi'])
                    ->count();
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function dibukaOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuka_oleh');
    }

    public function ditutupOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditutup_oleh');
    }

    /** Semua log scan dalam sesi ini */
    public function absensiGerbang(): HasMany
    {
        return $this->hasMany(AbsensiGerbang::class);
    }

    /** Hanya scan yang valid (bukan duplikat) */
    public function absensiValid(): HasMany
    {
        return $this->hasMany(AbsensiGerbang::class)
                    ->whereIn('status', ['normal', 'manual', 'koreksi']);
    }

    /** Scan duplikat dalam sesi ini */
    public function absensiDuplikat(): HasMany
    {
        return $this->hasMany(AbsensiGerbang::class)
                    ->where('status', 'duplikat');
    }
}