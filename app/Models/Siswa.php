<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'siswa';

    protected $fillable = [
        'pengguna_id',
        'nis',
        'nisn',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'no_hp',
        'email',
        'foto',
        'nama_ayah',
        'pekerjaan_ayah',
        'no_hp_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'no_hp_ibu',
        'nama_wali',
        'hubungan_wali',
        'pekerjaan_wali',
        'no_hp_wali',
        'kelas_id',
        'tahun_ajaran_id',
        'status',
        'tanggal_masuk',
        'tanggal_keluar',
        // CATATAN: tanggal_lulus tidak ada di tabel siswa berdasarkan migrasi.
        // Jika ingin menambahkan, tambahkan migrasi:
        // $table->date('tanggal_lulus')->nullable()->after('tanggal_keluar');
        // Lalu uncomment baris berikut:
        'tanggal_lulus',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir'  => 'date',
            'tanggal_masuk'  => 'date',
            'tanggal_keluar' => 'date',
            'tanggal_lulus'  => 'date',
        ];
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeLulus($query)
    {
        return $query->where('status', 'lulus');
    }

    public function scopePindah($query)
    {
        return $query->where('status', 'pindah');
    }

    public function scopeKeluar($query)
    {
        return $query->where('status', 'keluar');
    }

    // ── Accessors / Helpers ───────────────────────────────────────────────────

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    public function isLulus(): bool
    {
        return $this->status === 'lulus';
    }

    public function getFotoUrlAttribute(): string
    {
        return $this->foto
            ? asset('storage/' . $this->foto)
            : asset('images/default-siswa.png');
    }

    public function getUmurAttribute(): ?int
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'aktif'       => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif',
            'lulus'       => 'Lulus',
            'pindah'      => 'Pindah',
            'keluar'      => 'Keluar',
            default       => ucfirst($this->status),
        };
    }

    public function getLabelJenisKelaminAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getTotalPoinPelanggaranAttribute(): int
    {
        return $this->pelanggaran()
            ->where('status', '!=', 'dibatalkan')
            ->sum('poin') ?? 0;
    }

    /**
     * Persentase kehadiran dihitung dari seluruh absensi siswa.
     * Jika ingin filter per tahun ajaran, gunakan persentaseKehadiranTahunAjaran().
     */
    public function getPersentaseKehadiranAttribute(): float
    {
        $total = $this->absensi()->count();
        if ($total === 0) return 100.0;
        $hadir = $this->absensi()->whereIn('status', ['hadir', 'telat'])->count();
        return round(($hadir / $total) * 100, 2);
    }

    /**
     * Persentase kehadiran untuk tahun ajaran tertentu.
     * Karena tabel absensi tidak punya kolom tahun_ajaran_id,
     * kita filter via kelas yang berada di tahun ajaran tersebut.
     */
    public function persentaseKehadiranTahunAjaran(int $tahunAjaranId): float
    {
        $kelasIds = Kelas::where('tahun_ajaran_id', $tahunAjaranId)->pluck('id');

        $total = $this->absensi()->whereIn('kelas_id', $kelasIds)->count();
        if ($total === 0) return 0.0;

        $hadir = $this->absensi()
            ->whereIn('kelas_id', $kelasIds)
            ->whereIn('status', ['hadir', 'telat'])
            ->count();

        return round(($hadir / $total) * 100, 2);
    }

    /**
     * Ambil nilai rata-rata untuk tahun ajaran tertentu.
     */
    public function nilaiMapel(int $mapelId, int $tahunAjaranId): ?Nilai
    {
        return $this->nilai()
            ->where('mata_pelajaran_id', $mapelId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->first();
    }

    /**
     * Helper: ambil scan masuk hari ini (jika ada).
     */
    public function scanMasukHariIni(): ?AbsensiGerbang
    {
        return $this->absensiGerbang()
                    ->where('tanggal_scan', now()->toDateString())
                    ->where('tipe', 'masuk')
                    ->whereIn('status', ['normal', 'manual', 'koreksi'])
                    ->latest('waktu_scan')
                    ->first();
    }

    /**
     * Helper: ambil scan pulang hari ini (jika ada).
     */
    public function scanPulangHariIni(): ?AbsensiGerbang
    {
        return $this->absensiGerbang()
                    ->where('tanggal_scan', now()->toDateString())
                    ->where('tipe', 'pulang')
                    ->whereIn('status', ['normal', 'manual', 'koreksi'])
                    ->latest('waktu_scan')
                    ->first();
    }

    /**
     * Persentase kehadiran gerbang (masuk) untuk periode tertentu.
     * Menghitung berapa hari sekolah siswa ini sudah scan masuk.
     *
     * @param  string  $dari    Format: Y-m-d
     * @param  string  $sampai  Format: Y-m-d
     */
    public function persentaseKehadiranGerbang(string $dari, string $sampai): float
    {
        // Hitung total hari sesi gerbang masuk yang sudah ditutup di periode ini
        $totalHari = SesiGerbang::where('tipe', 'masuk')
                                 ->whereBetween('tanggal', [$dari, $sampai])
                                 ->where('status', 'ditutup')
                                 ->distinct('tanggal')
                                 ->count('tanggal');

        if ($totalHari === 0) return 0.0;

        $hariHadir = $this->absensiGerbang()
                          ->where('tipe', 'masuk')
                          ->whereBetween('tanggal_scan', [$dari, $sampai])
                          ->whereIn('status', ['normal', 'manual', 'koreksi'])
                          ->distinct('tanggal_scan')
                          ->count('tanggal_scan');

        return round(($hariHadir / $totalHari) * 100, 2);
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function orangTua(): BelongsToMany
    {
        return $this->belongsToMany(OrangTua::class, 'siswa_orang_tua', 'siswa_id', 'orang_tua_id')
            ->withPivot('hubungan', 'kontak_utama')
            ->withTimestamps();
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function pelanggaran(): HasMany
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function pengumpulanTugas(): HasMany
    {
        return $this->hasMany(PengumpulanTugas::class);
    }

    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    /**
     * Relasi ke riwayat perpindahan kelas siswa.
     * Mencakup semua tahun ajaran dan semua kelas yang pernah diikuti.
     */
    public function riwayatKelas(): HasMany
    {
        return $this->hasMany(RiwayatKelasSiswa::class);
    }

    /**
     * Riwayat kelas yang sedang aktif (status_akhir = aktif).
     */
    public function riwayatKelasAktif(): HasMany
    {
        return $this->hasMany(RiwayatKelasSiswa::class)
            ->where('status_akhir', 'aktif');
    }

    /**
     * Detail kenaikan kelas yang pernah diproses untuk siswa ini.
     */
    public function kenaikanKelasDetail(): HasMany
    {
        return $this->hasMany(KenaikanKelasDetail::class);
    }

    // ── Relations: Absensi Gerbang ────────────────────────────────────────────

    /**
     * Semua barcode gerbang milik siswa ini (termasuk riwayat lama).
     */
    public function barcodeGerbang(): HasMany
    {
        return $this->hasMany(BarcodeGerbang::class);
    }

    /**
     * Barcode gerbang yang sedang aktif saat ini.
     * Gunakan: $siswa->barcodeAktif
     */
    public function barcodeAktif(): HasOne
    {
        return $this->hasOne(BarcodeGerbang::class)
                    ->where('is_aktif', true)
                    ->latestOfMany('id');
    }

    /**
     * Semua log scan absensi gerbang milik siswa ini.
     */
    public function absensiGerbang(): HasMany
    {
        return $this->hasMany(AbsensiGerbang::class);
    }

    /**
     * Log scan absensi gerbang yang valid saja (bukan duplikat).
     */
    public function absensiGerbangValid(): HasMany
    {
        return $this->hasMany(AbsensiGerbang::class)
                    ->whereIn('status', ['normal', 'manual', 'koreksi']);
    }
}