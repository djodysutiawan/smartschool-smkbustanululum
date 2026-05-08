<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IzinKeluarSiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'izin_keluar_siswa';

    protected $fillable = [
        'siswa_id',
        'tahun_ajaran_id',
        'tanggal',
        'jam_keluar',
        'jam_kembali',
        'jam_kembali_aktual',
        'tujuan',
        'kategori',
        'keterangan',
        'status',
        'diproses_oleh',
        'diproses_pada',
        'dicatat_kembali_oleh',
        'dicatat_kembali_pada',
        'catatan_piket',
        'nomor_surat',
    ];

    protected $casts = [
        'tanggal'              => 'date',
        'diproses_pada'        => 'datetime',
        'dicatat_kembali_pada' => 'datetime',
    ];

    // ─── Konstanta ────────────────────────────────────────────────────────────

    const STATUS_MENUNGGU      = 'menunggu';
    const STATUS_DISETUJUI     = 'disetujui';
    const STATUS_DITOLAK       = 'ditolak';
    const STATUS_SUDAH_KEMBALI = 'sudah_kembali';

    const KATEGORI_LIST = [
        'keperluan_keluarga' => 'Keperluan Keluarga',
        'berobat'            => 'Berobat / Kesehatan',
        'keperluan_sekolah'  => 'Keperluan Sekolah',
        'lainnya'            => 'Lainnya',
    ];

    const STATUS_LIST = [
        'menunggu'      => 'Menunggu',
        'disetujui'     => 'Disetujui',
        'ditolak'       => 'Ditolak',
        'sudah_kembali' => 'Sudah Kembali',
    ];

    // ─── Relasi ───────────────────────────────────────────────────────────────

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function diprosesOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    public function dicatatKembaliOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicatat_kembali_oleh');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal', today());
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU);
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', self::STATUS_DISETUJUI);
    }

    /**
     * Siswa yang sudah disetujui tapi belum tercatat kembali.
     */
    public function scopeBelumKembali($query)
    {
        return $query->where('status', self::STATUS_DISETUJUI);
    }

    public function scopeByTahunAjaran($query, $tahunAjaranId)
    {
        return $query->where('tahun_ajaran_id', $tahunAjaranId);
    }

    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal', now()->month)
                     ->whereYear('tanggal', now()->year);
    }

    public function scopeTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }

    // ─── Accessor ─────────────────────────────────────────────────────────────

    public function getKategoriLabelAttribute(): string
    {
        return self::KATEGORI_LIST[$this->kategori] ?? ucfirst($this->kategori);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LIST[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'menunggu'      => 'warning',
            'disetujui'     => 'success',
            'ditolak'       => 'danger',
            'sudah_kembali' => 'info',
            default         => 'secondary',
        };
    }

    /**
     * Durasi keluar dalam menit (hanya tersedia jika sudah kembali).
     */
    public function getDurasiMenitAttribute(): ?int
    {
        if (! $this->jam_keluar || ! $this->jam_kembali_aktual) {
            return null;
        }

        $keluar  = Carbon::createFromTimeString($this->jam_keluar);
        $kembali = Carbon::createFromTimeString($this->jam_kembali_aktual);

        // Jika kembali melewati tengah malam (edge case)
        if ($kembali->lt($keluar)) {
            $kembali->addDay();
        }

        return max(0, $keluar->diffInMinutes($kembali));
    }

    /**
     * Format durasi untuk tampilan: "1j 20m".
     */
    public function getDurasiFormattedAttribute(): string
    {
        $menit = $this->durasi_menit;
        if ($menit === null) return '-';

        $jam  = intdiv($menit, 60);
        $sisa = $menit % 60;

        if ($jam > 0 && $sisa > 0) return "{$jam}j {$sisa}m";
        if ($jam > 0)               return "{$jam}j";
        return "{$sisa}m";
    }

    // ─── Helper: Status Check ─────────────────────────────────────────────────

    public function isMenunggu(): bool     { return $this->status === self::STATUS_MENUNGGU; }
    public function isDisetujui(): bool    { return $this->status === self::STATUS_DISETUJUI; }
    public function isDitolak(): bool      { return $this->status === self::STATUS_DITOLAK; }
    public function isSudahKembali(): bool { return $this->status === self::STATUS_SUDAH_KEMBALI; }

    // ─── Generate Nomor Surat ─────────────────────────────────────────────────

    /**
     * Format: IZN/YYYY/MM/XXXX
     *
     * Dipanggil di dalam DB::transaction() dari controller (setujui)
     * sehingga penguncian baris (lockForUpdate) benar-benar efektif
     * dan nomor urut tidak pernah dobel meski ada request bersamaan.
     */
    public static function generateNomorSurat(): string
    {
        $tahun = now()->format('Y');
        $bulan = now()->format('m');

        // Lock baris terakhir yang punya nomor surat di bulan ini
        // agar tidak ada dua proses yang mendapat urutan yang sama.
        $urutan = static::whereYear('created_at', $tahun)
                        ->whereMonth('created_at', $bulan)
                        ->whereNotNull('nomor_surat')
                        ->lockForUpdate()   // ← kunci baris selama transaksi
                        ->count() + 1;

        return sprintf('IZN/%s/%s/%04d', $tahun, $bulan, $urutan);
    }

    // ─── Static Helper untuk Laporan ─────────────────────────────────────────

    /**
     * Ringkasan statistik bulan ini — dipakai ReportController::index().
     */
    public static function getStatsBulanIni(): array
    {
        $base = static::bulanIni();

        return [
            'total'    => (clone $base)->count(),
            'disetujui' => (clone $base)->whereIn('status', [
                                self::STATUS_DISETUJUI,
                                self::STATUS_SUDAH_KEMBALI,
                           ])->count(),
            'ditolak'  => (clone $base)->where('status', self::STATUS_DITOLAK)->count(),
            'menunggu' => (clone $base)->where('status', self::STATUS_MENUNGGU)->count(),
        ];
    }
}