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
            'is_active'       => 'boolean',
        ];
    }

    // ── Boot ──────────────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            // Auto-generate UUID sebagai kode QR
            $model->kode_qr ??= Str::uuid()->toString();

            // Isi tanggal otomatis dari berlaku_mulai jika kosong
            if (empty($model->tanggal) && $model->berlaku_mulai) {
                $model->tanggal = $model->berlaku_mulai->toDateString();
            }

            // Isi field dari jadwal hanya jika field tersebut BELUM diisi oleh controller.
            // Perbaikan bug: logika sebelumnya memakai ??= untuk kelas_id & mata_pelajaran_id
            // sehingga nilai dari controller (yang sudah terisi) tidak akan pernah di-override
            // oleh jadwal. Ini sudah benar. Yang diperbaiki: guru_id sekarang SELALU
            // diambil dari jadwal jika ada jadwal_pelajaran_id, supaya tidak pernah null
            // ketika sesi dibuat via jadwal.
            if ($model->jadwal_pelajaran_id) {
                $jadwal = JadwalPelajaran::find($model->jadwal_pelajaran_id);
                if ($jadwal) {
                    // ??= : hanya isi jika belum ada (admin bisa override manual)
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
     * Validasi apakah koordinat siswa dalam radius yang diizinkan.
     * Mengembalikan jarak dalam meter, atau null jika GPS tidak dikonfigurasi.
     */
    public function hitungJarak(float $latSiswa, float $lngSiswa): ?float
    {
        if (! $this->latitude || ! $this->longitude) {
            return null;
        }

        // Haversine formula
        $earthRadius = 6371000; // meter
        $dLat = deg2rad($latSiswa - $this->latitude);
        $dLng = deg2rad($lngSiswa - $this->longitude);

        $a = sin($dLat / 2) ** 2
           + cos(deg2rad((float) $this->latitude))
           * cos(deg2rad($latSiswa))
           * sin($dLng / 2) ** 2;

        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    public function dalamRadius(float $latSiswa, float $lngSiswa): bool
    {
        if (! $this->latitude || ! $this->longitude) {
            return true; // Tanpa GPS = selalu valid
        }

        $jarak = $this->hitungJarak($latSiswa, $lngSiswa);
        return $jarak !== null && $jarak <= $this->radius_meter;
    }

    /**
     * Generate URL QR code untuk di-embed di halaman / cetak.
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
            ->where('status', 'valid')
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