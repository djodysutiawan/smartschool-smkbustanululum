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
 * Satu baris = satu event scan barcode siswa di gerbang sekolah.
 *
 * Status record:
 *   normal   → scan valid, pertama kali siswa scan di sesi ini
 *   duplikat → siswa sudah scan sebelumnya di sesi yang sama (diabaikan sistem)
 *   koreksi  → tipe scan diubah oleh admin/piket (misal: masuk → pulang)
 *   manual   → diinput guru piket secara manual (alat rusak / siswa lupa bawa ID)
 *
 * @property int         $id
 * @property int         $sesi_gerbang_id
 * @property int|null    $siswa_id
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

    /** Hanya scan dengan status normal */
    public function scopeNormal($query)
    {
        return $query->where('status', 'normal');
    }

    /** Hanya scan yang valid (dipakai untuk rekap kehadiran) */
    public function scopeValid($query)
    {
        return $query->whereIn('status', ['normal', 'manual', 'koreksi']);
    }

    /** Hanya scan duplikat */
    public function scopeDuplikat($query)
    {
        return $query->where('status', 'duplikat');
    }

    /** Hanya input manual */
    public function scopeManual($query)
    {
        return $query->where('is_manual', true);
    }

    /** Filter tipe masuk */
    public function scopeMasuk($query)
    {
        return $query->where('tipe', 'masuk');
    }

    /** Filter tipe pulang */
    public function scopePulang($query)
    {
        return $query->where('tipe', 'pulang');
    }

    /** Filter berdasarkan tanggal */
    public function scopeTanggal($query, string $tanggal)
    {
        return $query->where('tanggal_scan', $tanggal);
    }

    /** Filter hari ini */
    public function scopeHariIni($query)
    {
        return $query->where('tanggal_scan', now()->toDateString());
    }

    /** Filter rentang tanggal */
    public function scopePeriode($query, string $dari, string $sampai)
    {
        return $query->whereBetween('tanggal_scan', [$dari, $sampai]);
    }

    /** Filter berdasarkan kelas siswa */
    public function scopeKelas($query, int $kelasId)
    {
        return $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $kelasId));
    }

    /**
     * Scan terbaru yang masuk sesi tertentu (untuk live monitor).
     * Gunakan: AbsensiGerbang::sesiAktif($sesiId)->latest('waktu_scan')->get()
     */
    public function scopeSesiAktif($query, int $sesiGerbangId)
    {
        return $query->where('sesi_gerbang_id', $sesiGerbangId);
    }

    // ── Static Helpers ────────────────────────────────────────────────────────

    /**
     * Rekam scan dari alat. Otomatis deteksi duplikat.
     *
     * @param  SesiGerbang    $sesi
     * @param  string         $kodeScan   Nilai mentah dari alat
     * @param  \Carbon\Carbon|null $waktu Null = gunakan now()
     * @return static
     */
    public static function rekamScan(
        SesiGerbang $sesi,
        string $kodeScan,
        ?\Carbon\Carbon $waktu = null
    ): static {
        $waktu ??= now();

        // Cari barcode yang cocok
        $barcode = BarcodeGerbang::where('kode', $kodeScan)
                                  ->aktif()
                                  ->first();

        $siswa = $barcode?->siswa;

        // Deteksi duplikat — apakah siswa ini sudah scan valid di sesi yang sama?
        $isDuplikat = $siswa && static::where('sesi_gerbang_id', $sesi->id)
                                      ->where('siswa_id', $siswa->id)
                                      ->where('tipe', $sesi->tipe)
                                      ->whereIn('status', ['normal', 'manual', 'koreksi'])
                                      ->exists();

        return static::create([
            'sesi_gerbang_id'    => $sesi->id,
            'siswa_id'           => $siswa?->id,
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
     * Input manual oleh guru piket.
     *
     * @param  SesiGerbang $sesi
     * @param  Siswa       $siswa
     * @param  int         $inputOleh  user_id guru piket
     * @param  string|null $catatan
     * @param  string|null $tipe       null = ikuti tipe sesi
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
     * Koreksi tipe scan (misalnya: salah pilih masuk padahal pulang).
     * Membuat record baru dengan status 'koreksi' dan menandai record ini.
     *
     * @param  int         $inputOleh  user_id yang melakukan koreksi
     * @param  string      $tipeBaru   masuk|pulang
     * @param  string|null $catatan
     * @return static  Record koreksi yang baru dibuat
     */
    public function koreksi(int $inputOleh, string $tipeBaru, ?string $catatan = null): static
    {
        // Soft-delete record lama (tetap tersimpan sebagai riwayat)
        $this->update(['catatan' => '[DIKOREKSI] ' . ($catatan ?? '')]);

        return static::create([
            'sesi_gerbang_id'    => $this->sesi_gerbang_id,
            'siswa_id'           => $this->siswa_id,
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
        return $this->siswa_id !== null;
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

    public function barcodeGerbang(): BelongsTo
    {
        return $this->belongsTo(BarcodeGerbang::class);
    }

    /** User (guru piket) yang melakukan input manual atau koreksi */
    public function inputOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'input_oleh');
    }

    /** Record asli yang dikoreksi oleh record ini */
    public function koreksiDari(): BelongsTo
    {
        return $this->belongsTo(AbsensiGerbang::class, 'koreksi_dari_id');
    }

    /** Record koreksi yang dibuat dari record ini (jika ada) */
    public function hasilKoreksi(): HasOne
    {
        return $this->hasOne(AbsensiGerbang::class, 'koreksi_dari_id');
    }
}