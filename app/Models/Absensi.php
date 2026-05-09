<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'sesi_qr_id',
        'mata_pelajaran_id',
        'jadwal_pelajaran_id',
        'dicatat_oleh',
        'tanggal',
        'status',
        'metode',
        'jam_masuk',
        'jam_keluar',
        'keterangan',
        'path_surat_izin',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'    => 'date',
            'jam_masuk'  => 'datetime:H:i',
            'jam_keluar' => 'datetime:H:i',
        ];
    }

    // ── Enum constants ────────────────────────────────────────────────────────

    public const STATUS_HADIR = 'hadir';
    public const STATUS_TELAT = 'telat';
    public const STATUS_IZIN  = 'izin';
    public const STATUS_SAKIT = 'sakit';
    public const STATUS_ALFA  = 'alfa';

    public const METODE_MANUAL  = 'manual';
    public const METODE_QR      = 'qr';
    public const METODE_QR_SCAN = 'qr_scan';
    public const METODE_WAJAH   = 'wajah';
    public const METODE_RFID    = 'rfid';
    public const METODE_IMPORT  = 'import';

    public const METODE_ALL = ['manual', 'qr', 'qr_scan', 'wajah', 'rfid', 'import'];

    public const STATUS_DIHITUNG_HADIR = ['hadir', 'telat'];

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeHadir($query)
    {
        return $query->where('status', self::STATUS_HADIR);
    }

    public function scopeTelat($query)
    {
        return $query->where('status', self::STATUS_TELAT);
    }

    public function scopeAlfa($query)
    {
        return $query->where('status', self::STATUS_ALFA);
    }

    public function scopeIzin($query)
    {
        return $query->where('status', self::STATUS_IZIN);
    }

    public function scopeSakit($query)
    {
        return $query->where('status', self::STATUS_SAKIT);
    }

    public function scopeDihitungHadir($query)
    {
        return $query->whereIn('status', self::STATUS_DIHITUNG_HADIR);
    }

    /**
     * Filter berdasarkan tahun ajaran via join ke kelas.
     * PERBAIKAN: Gunakan fully-qualified class name agar tidak butuh use statement
     * di setiap tempat scope ini dipanggil. Tetap aman jika model Kelas ada di namespace App\Models.
     */
    public function scopeTahunAjaran($query, int $tahunAjaranId)
    {
        return $query->whereIn(
            'kelas_id',
            \App\Models\Kelas::where('tahun_ajaran_id', $tahunAjaranId)->pluck('id')
        );
    }

    public function scopeTanggal($query, string $tanggal)
    {
        return $query->where('tanggal', $tanggal);
    }

    public function scopePeriode($query, string $dari, string $sampai)
    {
        return $query->whereBetween('tanggal', [$dari, $sampai]);
    }

    // ── Accessors / Helpers ───────────────────────────────────────────────────

    public function isHadir(): bool
    {
        return in_array($this->status, self::STATUS_DIHITUNG_HADIR);
    }

    public function isAlfa(): bool
    {
        return $this->status === self::STATUS_ALFA;
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_HADIR => 'Hadir',
            self::STATUS_TELAT => 'Telat',
            self::STATUS_IZIN  => 'Izin',
            self::STATUS_SAKIT => 'Sakit',
            self::STATUS_ALFA  => 'Alfa',
            default            => ucfirst($this->status),
        };
    }

    public function getLabelMetodeAttribute(): string
    {
        return match ($this->metode) {
            self::METODE_MANUAL  => 'Manual',
            self::METODE_QR,
            self::METODE_QR_SCAN => 'Scan QR',
            self::METODE_WAJAH   => 'Pengenalan Wajah',
            self::METODE_RFID    => 'RFID',
            self::METODE_IMPORT  => 'Import',
            default              => ucfirst($this->metode ?? 'manual'),
        };
    }

    public function getPathSuratIzinUrlAttribute(): ?string
    {
        return $this->path_surat_izin
            ? asset('storage/' . $this->path_surat_izin)
            : null;
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function jadwalPelajaran(): BelongsTo
    {
        return $this->belongsTo(JadwalPelajaran::class);
    }

    public function sesiQr(): BelongsTo
    {
        return $this->belongsTo(SesiQr::class);
    }

    public function dicatatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}