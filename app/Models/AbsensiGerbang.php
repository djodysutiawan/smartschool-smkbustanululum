<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Model AbsensiGerbang
 * ─────────────────────────────────────────────────────────────────────────────
 * Satu baris = satu event scan barcode di gerbang sekolah.
 * Bisa untuk SISWA (siswa_id terisi) atau GURU (guru_id terisi).
 *
 * Status record:
 *   normal   → scan valid, pertama kali di sesi ini
 *   duplikat → sudah scan sebelumnya di sesi yang sama (diabaikan)
 *   koreksi  → tipe scan diubah oleh admin/piket
 *   manual   → diinput guru piket secara manual
 *
 * @property int         $id
 * @property int         $sesi_gerbang_id
 * @property int|null    $siswa_id
 * @property int|null    $guru_id
 * @property int|null    $barcode_gerbang_id
 * @property string      $kode_scan
 * @property string      $tipe             masuk|pulang
 * @property \Carbon\Carbon $waktu_scan
 * @property \Carbon\Carbon $tanggal_scan
 * @property string      $status           normal|duplikat|koreksi|manual
 * @property bool        $is_manual
 * @property int|null    $input_oleh
 * @property string|null $catatan
 * @property int|null    $koreksi_dari_id
 */
class AbsensiGerbang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'absensi_gerbang';

    protected $fillable = [
        'sesi_gerbang_id',
        'siswa_id',
        'guru_id',
        'barcode_gerbang_id',
        'kode_scan',
        'tipe',
        'waktu_scan',
        'tanggal_scan',
        'status',
        'is_manual',
        'input_oleh',
        'catatan',
        'koreksi_dari_id',
    ];

    protected function casts(): array
    {
        return [
            'waktu_scan'   => 'datetime',
            'tanggal_scan' => 'date',
            'is_manual'    => 'boolean',
        ];
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeNormal($query)
    {
        return $query->where('status', 'normal');
    }

    public function scopeValid($query)
    {
        return $query->whereIn('status', ['normal', 'manual', 'koreksi']);
    }

    public function scopeDuplikat($query)
    {
        return $query->where('status', 'duplikat');
    }

    public function scopeManual($query)
    {
        return $query->where('is_manual', true);
    }

    public function scopeMasuk($query)
    {
        return $query->where('tipe', 'masuk');
    }

    public function scopePulang($query)
    {
        return $query->where('tipe', 'pulang');
    }

    public function scopeTanggal($query, string $tanggal)
    {
        return $query->where('tanggal_scan', $tanggal);
    }

    public function scopeHariIni($query)
    {
        return $query->where('tanggal_scan', now()->toDateString());
    }

    public function scopePeriode($query, string $dari, string $sampai)
    {
        return $query->whereBetween('tanggal_scan', [$dari, $sampai]);
    }

    /** Filter berdasarkan kelas siswa. */
    public function scopeKelas($query, int $kelasId)
    {
        return $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $kelasId));
    }

    /** Hanya scan milik siswa. */
    public function scopeUntukSiswa($query)
    {
        return $query->whereNotNull('siswa_id')->whereNull('guru_id');
    }

    /** Hanya scan milik guru. */
    public function scopeUntukGuru($query)
    {
        return $query->whereNotNull('guru_id')->whereNull('siswa_id');
    }

    public function scopeSesiAktif($query, int $sesiGerbangId)
    {
        return $query->where('sesi_gerbang_id', $sesiGerbangId);
    }

    // ── Static Helpers ────────────────────────────────────────────────────────

    /**
     * Rekam scan dari alat. Otomatis deteksi duplikat.
     * Support scan barcode siswa DAN guru dalam satu method.
     *
     * @param  SesiGerbang         $sesi
     * @param  string              $kodeScan   Nilai mentah dari alat
     * @param  \Carbon\Carbon|null $waktu      Null = gunakan now()
     * @return static
     */
    public static function rekamScan(
        SesiGerbang $sesi,
        string $kodeScan,
        ?\Carbon\Carbon $waktu = null
    ): static {
        $waktu ??= now();

        // Cari barcode yang cocok (aktif, siswa atau guru)
        $barcode = BarcodeGerbang::where('kode', $kodeScan)
                                  ->aktif()
                                  ->first();

        $siswa = null;
        $guru  = null;
        $isDuplikat = false;

        if ($barcode) {
            if ($barcode->tipe_pemilik === 'siswa') {
                $siswa = $barcode->siswa;

                // Deteksi duplikat untuk siswa
                $isDuplikat = $siswa && static::where('sesi_gerbang_id', $sesi->id)
                                              ->where('siswa_id', $siswa->id)
                                              ->where('tipe', $sesi->tipe)
                                              ->whereIn('status', ['normal', 'manual', 'koreksi'])
                                              ->exists();
            } elseif ($barcode->tipe_pemilik === 'guru') {
                $guru = $barcode->guru;

                // Deteksi duplikat untuk guru
                $isDuplikat = $guru && static::where('sesi_gerbang_id', $sesi->id)
                                             ->where('guru_id', $guru->id)
                                             ->where('tipe', $sesi->tipe)
                                             ->whereIn('status', ['normal', 'manual', 'koreksi'])
                                             ->exists();
            }
        }

        return static::create([
            'sesi_gerbang_id'    => $sesi->id,
            'siswa_id'           => $siswa?->id,
            'guru_id'            => $guru?->id,
            'barcode_gerbang_id' => $barcode?->id,
            'kode_scan'          => $kodeScan,
            'tipe'               => $sesi->tipe,
            'waktu_scan'         => $waktu,
            'tanggal_scan'       => $waktu->toDateString(),
            'status'             => $isDuplikat ? 'duplikat' : 'normal',
            'is_manual'          => false,
        ]);
    }

    /**
     * Input manual oleh guru piket untuk SISWA.
     */
    public static function inputManual(
        SesiGerbang $sesi,
        Siswa $siswa,
        int $inputOleh,
        ?string $catatan = null,
        ?string $tipe = null,
    ): static {
        $barcode = BarcodeGerbang::where('siswa_id', $siswa->id)
                                  ->aktif()
                                  ->first();

        return static::create([
            'sesi_gerbang_id'    => $sesi->id,
            'siswa_id'           => $siswa->id,
            'guru_id'            => null,
            'barcode_gerbang_id' => $barcode?->id,
            'kode_scan'          => $barcode?->kode ?? 'MANUAL',
            'tipe'               => $tipe ?? $sesi->tipe,
            'waktu_scan'         => now(),
            'tanggal_scan'       => now()->toDateString(),
            'status'             => 'manual',
            'is_manual'          => true,
            'input_oleh'         => $inputOleh,
            'catatan'            => $catatan,
        ]);
    }

    /**
     * Input manual oleh guru piket untuk GURU.
     */
    public static function inputManualGuru(
        SesiGerbang $sesi,
        Guru $guru,
        int $inputOleh,
        ?string $catatan = null,
        ?string $tipe = null,
    ): static {
        $barcode = BarcodeGerbang::where('guru_id', $guru->id)
                                  ->aktif()
                                  ->first();

        return static::create([
            'sesi_gerbang_id'    => $sesi->id,
            'siswa_id'           => null,
            'guru_id'            => $guru->id,
            'barcode_gerbang_id' => $barcode?->id,
            'kode_scan'          => $barcode?->kode ?? 'MANUAL',
            'tipe'               => $tipe ?? $sesi->tipe,
            'waktu_scan'         => now(),
            'tanggal_scan'       => now()->toDateString(),
            'status'             => 'manual',
            'is_manual'          => true,
            'input_oleh'         => $inputOleh,
            'catatan'            => $catatan,
        ]);
    }

    /**
     * Koreksi tipe scan.
     */
    public function koreksi(int $inputOleh, string $tipeBaru, ?string $catatan = null): static
    {
        $this->update(['catatan' => '[DIKOREKSI] ' . ($catatan ?? '')]);

        return static::create([
            'sesi_gerbang_id'    => $this->sesi_gerbang_id,
            'siswa_id'           => $this->siswa_id,
            'guru_id'            => $this->guru_id,
            'barcode_gerbang_id' => $this->barcode_gerbang_id,
            'kode_scan'          => $this->kode_scan,
            'tipe'               => $tipeBaru,
            'waktu_scan'         => $this->waktu_scan,
            'tanggal_scan'       => $this->tanggal_scan,
            'status'             => 'koreksi',
            'is_manual'          => false,
            'input_oleh'         => $inputOleh,
            'catatan'            => $catatan,
            'koreksi_dari_id'    => $this->id,
        ]);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getLabelTipeAttribute(): string
    {
        return $this->tipe === 'masuk' ? 'Masuk' : 'Pulang';
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'normal'   => 'Normal',
            'duplikat' => 'Duplikat',
            'koreksi'  => 'Koreksi',
            'manual'   => 'Manual',
            default    => ucfirst($this->status),
        };
    }

    /** Apakah scan ini valid untuk dipakai dalam rekap kehadiran? */
    public function getIsValidAttribute(): bool
    {
        return in_array($this->status, ['normal', 'manual', 'koreksi']);
    }

    /** Apakah barcode scan ini dikenali sistem? */
    public function getDikenaliAttribute(): bool
    {
        return $this->siswa_id !== null || $this->guru_id !== null;
    }

    /** Tipe pemilik scan: 'siswa', 'guru', atau 'unknown'. */
    public function getTipePemilikAttribute(): string
    {
        if ($this->siswa_id !== null) return 'siswa';
        if ($this->guru_id  !== null) return 'guru';
        return 'unknown';
    }

    /** Nama pemilik (siswa atau guru). */
    public function getNamaPemilikAttribute(): string
    {
        if ($this->tipe_pemilik === 'siswa') return $this->siswa?->nama_lengkap ?? '—';
        if ($this->tipe_pemilik === 'guru')  return $this->guru?->nama_lengkap  ?? '—';
        return '—';
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function sesiGerbang(): BelongsTo
    {
        return $this->belongsTo(SesiGerbang::class);
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /** Guru yang melakukan scan (bukan guru piket yang input manual). */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function barcodeGerbang(): BelongsTo
    {
        return $this->belongsTo(BarcodeGerbang::class);
    }

    /** User (guru piket) yang melakukan input manual atau koreksi. */
    public function inputOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'input_oleh');
    }

    /** Record asli yang dikoreksi oleh record ini. */
    public function koreksiDari(): BelongsTo
    {
        return $this->belongsTo(AbsensiGerbang::class, 'koreksi_dari_id');
    }

    /** Record koreksi yang dibuat dari record ini (jika ada). */
    public function hasilKoreksi(): HasOne
    {
        return $this->hasOne(AbsensiGerbang::class, 'koreksi_dari_id');
    }
}