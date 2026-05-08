<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class SesiQr extends Model
{
    use HasFactory;

    protected $table = 'sesi_qr';

    protected $fillable = [
        'kelas_id',
        'mata_pelajaran_id',
        'jadwal_pelajaran_id',
        'guru_id',
        'dibuat_oleh',
        'kode_qr',
        'tanggal',
        'berlaku_mulai',
        'kadaluarsa_pada',
        'radius_meter',
        'latitude',
        'longitude',
        'jumlah_scan',
        'maks_scan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'         => 'date',
            'berlaku_mulai'   => 'datetime',
            'kadaluarsa_pada' => 'datetime',
            'latitude'        => 'decimal:8',
            'longitude'       => 'decimal:8',
            'jumlah_scan'     => 'integer',
            'maks_scan'       => 'integer',
            'is_active'       => 'boolean',
        ];
    }

    // ── Boot ──────────────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            // Auto-generate UUID sebagai kode QR jika belum ada
            $model->kode_qr ??= Str::uuid()->toString();

            // Isi tanggal dari berlaku_mulai jika tanggal kosong
            if (empty($model->tanggal) && $model->berlaku_mulai) {
                $model->tanggal = $model->berlaku_mulai->toDateString();
            }

            // Isi field dari jadwal jika jadwal_pelajaran_id ada,
            // ??= hanya mengisi jika field masih null (tidak override nilai dari controller)
            if ($model->jadwal_pelajaran_id) {
                $jadwal = JadwalPelajaran::find($model->jadwal_pelajaran_id);
                if ($jadwal) {
                    $model->guru_id           ??= $jadwal->guru_id;
                    $model->kelas_id          ??= $jadwal->kelas_id;
                    $model->mata_pelajaran_id ??= $jadwal->mata_pelajaran_id;
                }
            }
        });
    }

    // ── Business Logic ────────────────────────────────────────────────────────

    /**
     * Cek apakah sesi QR masih valid untuk di-scan.
     */
    public function isValid(): bool
    {
        if (! $this->is_active) {
            return false;
        }
        if (now()->isBefore($this->berlaku_mulai)) {
            return false;
        }
        if (now()->isAfter($this->kadaluarsa_pada)) {
            return false;
        }
        if ($this->maks_scan > 0 && $this->jumlah_scan >= $this->maks_scan) {
            return false;
        }
        return true;
    }

    public function isKadaluarsa(): bool
    {
        return now()->isAfter($this->kadaluarsa_pada);
    }

    public function nonaktifkan(): void
    {
        $this->update(['is_active' => false]);
    }

    /**
     * Hitung jarak antara koordinat sesi dan koordinat siswa (Haversine).
     * Mengembalikan jarak dalam meter, atau null jika GPS tidak dikonfigurasi.
     */
    public function hitungJarak(float $latSiswa, float $lngSiswa): ?float
    {
        if (! $this->latitude || ! $this->longitude) {
            return null;
        }

        $earthRadius = 6371000; // meter
        $dLat = deg2rad($latSiswa - (float) $this->latitude);
        $dLng = deg2rad($lngSiswa - (float) $this->longitude);

        $a = sin($dLat / 2) ** 2
           + cos(deg2rad((float) $this->latitude))
           * cos(deg2rad($latSiswa))
           * sin($dLng / 2) ** 2;

        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    public function dalamRadius(float $latSiswa, float $lngSiswa): bool
    {
        // Tanpa koordinat sesi = tidak ada validasi GPS → selalu valid
        if (! $this->latitude || ! $this->longitude) {
            return true;
        }

        $jarak = $this->hitungJarak($latSiswa, $lngSiswa);
        return $jarak !== null && $jarak <= $this->radius_meter;
    }

    /**
     * URL untuk di-embed di halaman QR / cetak.
     * Route: siswa.absensi.scan dengan parameter {kode}
     */
    public function getQrUrlAttribute(): string
    {
        return route('siswa.absensi.scan', ['kode' => $this->kode_qr]);
    }

    /**
     * Daftar siswa di kelas ini yang BELUM scan valid pada sesi ini.
     */
    public function siswaYangBelumScan()
    {
        $sudahScanIds = $this->riwayatScan()
            ->where('status', RiwayatScanQr::STATUS_VALID)
            ->pluck('siswa_id');

        return Siswa::where('kelas_id', $this->kelas_id)
            ->whereNotIn('id', $sudahScanIds)
            ->get();
    }

    /**
     * Increment jumlah_scan secara atomic (menghindari race condition).
     */
    public function incrementScan(): void
    {
        $this->increment('jumlah_scan');
    }

    /**
     * Kembalikan timestamp millisecond untuk JavaScript countdown.
     * Menggantikan ->valueOf() yang tidak ada di Carbon.
     */
    public function getKadaluarsaTimestampMsAttribute(): int
    {
        return $this->kadaluarsa_pada->getTimestampMs();
    }

    // ── Relations ─────────────────────────────────────────────────────────────

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

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function riwayatScan(): HasMany
    {
        return $this->hasMany(RiwayatScanQr::class);
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMasihBerlaku($query)
    {
        return $query->aktif()
            ->where('berlaku_mulai', '<=', now())
            ->where('kadaluarsa_pada', '>=', now());
    }
}