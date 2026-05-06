<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guru extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guru';

    protected $fillable = [
        'pengguna_id', 'nip', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir',
        'tanggal_lahir', 'alamat', 'no_hp', 'email', 'foto',
        'pendidikan_terakhir', 'jurusan_pendidikan', 'universitas', 'tahun_lulus',
        'status_kepegawaian', 'tanggal_masuk', 'adalah_guru_piket', 'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir'     => 'date',
            'tanggal_masuk'     => 'date',
            'adalah_guru_piket' => 'boolean',
        ];
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopePiket($query)
    {
        return $query->where('adalah_guru_piket', true);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    public function getFotoUrlAttribute(): string
    {
        return $this->foto
            ? asset('storage/' . $this->foto)
            : asset('images/default-guru.png');
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
            'cuti'        => 'Cuti',
            default       => ucfirst($this->status),
        };
    }

    public function getLabelStatusKepegawaianAttribute(): string
    {
        return match ($this->status_kepegawaian) {
            'pns'     => 'PNS',
            'p3k'     => 'P3K',
            'honorer' => 'Honorer',
            'gtty'    => 'GTTY',
            default   => strtoupper($this->status_kepegawaian),
        };
    }

    // ── Business Logic ────────────────────────────────────────────────────────

    /**
     * Cek apakah guru tersedia di jam tertentu.
     *
     * FIX: versi lama menggunakan jam_mulai <= jamMulai AND jam_selesai >= jamSelesai
     * yang artinya slot harus MENCAKUP penuh rentang jam.
     * Itu benar untuk cek "apakah slot ketersediaan mencakup jam jadwal".
     *
     * Parameter opsional:
     * - $mapelId: cek ketersediaan untuk mapel spesifik
     * - $jurusanId: cek ketersediaan untuk jurusan spesifik
     * - $tanggal: cek ketersediaan yang berlaku pada tanggal itu (untuk slot temporer)
     */
    public function isTersediaHari(
        string $hari,
        string $jamMulai,
        string $jamSelesai,
        ?int $mapelId = null,
        ?int $jurusanId = null,
        ?string $tanggal = null,
    ): bool {
        $query = $this->ketersediaan()
            ->where('hari', $hari)
            ->where('tersedia', true)
            // Slot harus MENCAKUP jam yang dibutuhkan
            ->where('jam_mulai', '<=', $jamMulai)
            ->where('jam_selesai', '>=', $jamSelesai);

        // Filter berlaku pada tanggal (temporer vs permanen)
        if ($tanggal) {
            $query->berlakuPada($tanggal);
        }

        // Filter mapel (null di slot = berlaku untuk semua mapel)
        if ($mapelId) {
            $query->untukMapel($mapelId);
        }

        // Filter jurusan (null di slot = berlaku untuk semua jurusan)
        if ($jurusanId) {
            $query->untukJurusan($jurusanId);
        }

        return $query->exists();
    }

    /**
     * Cek apakah guru sudah punya jadwal bentrok di hari & jam tertentu.
     * Menggunakan overlap logic yang benar:
     * jadwal_mulai < jamSelesai AND jadwal_selesai > jamMulai
     */
    public function isJadwalBentrok(
        string $hari,
        string $jamMulai,
        string $jamSelesai,
        int $tahunAjaranId,
        ?int $excludeJadwalId = null,
    ): bool {
        $query = $this->jadwalPelajaran()
            ->where('hari', $hari)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('is_active', true)
            ->where('jam_mulai', '<', $jamSelesai)
            ->where('jam_selesai', '>', $jamMulai);

        if ($excludeJadwalId) {
            $query->where('id', '!=', $excludeJadwalId);
        }

        return $query->exists();
    }

    /**
     * Ambil semua mata pelajaran yang diampu guru ini.
     * Lewat tabel pivot guru_mata_pelajaran (data statis/kompetensi).
     */
    public function getMapelDiampuAttribute()
    {
        return $this->mataPelajaran()
            ->where('guru_mata_pelajaran.is_active', true)
            ->get();
    }

    /**
     * Ambil mapel yang AKTIF diajarkan guru ini (dari jadwal semester berjalan).
     */
    public function getMapelAktifAttribute()
    {
        return MataPelajaran::whereHas('jadwalPelajaran', function ($q) {
            $q->where('guru_id', $this->id)
              ->where('is_active', true)
              ->whereHas('tahunAjaran', fn($q2) => $q2->where('status', 'aktif'));
        })->get();
    }

    /**
     * Ambil jurusan yang diajar guru ini (dari jadwal aktif → kelas → jurusan).
     */
    public function getJurusanDiajarAttribute()
    {
        return Jurusan::whereHas('kelas.jadwalPelajaran', function ($q) {
            $q->where('guru_id', $this->id)
              ->where('is_active', true);
        })->distinct()->get();
    }

    /**
     * Ringkasan jadwal guru: berapa kelas, mapel, jam per minggu.
     */
    public function getRingkasanJadwalAttribute(): array
    {
        $jadwal = $this->jadwalPelajaran()
            ->aktif()
            ->whereHas('tahunAjaran', fn($q) => $q->where('status', 'aktif'))
            ->with(['mataPelajaran', 'kelas.jurusan'])
            ->get();

        return [
            'total_jam_per_minggu' => $jadwal->count(),
            'total_kelas'          => $jadwal->unique('kelas_id')->count(),
            'total_mapel'          => $jadwal->unique('mata_pelajaran_id')->count(),
            'kelas_diajar'         => $jadwal->unique('kelas_id')->map(fn($j) => $j->kelas)->filter(),
            'mapel_diajar'         => $jadwal->unique('mata_pelajaran_id')->map(fn($j) => $j->mataPelajaran)->filter(),
        ];
    }

    // ── Relations ─────────────────────────────────────────────────────────────

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function kelasWali(): HasMany
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }

    public function ketersediaan(): HasMany
    {
        return $this->hasMany(KetersediaanGuru::class);
    }

    public function jadwalPelajaran(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class);
    }

    /**
     * Mata pelajaran yang resmi diampu guru ini (pivot statis).
     * Berbeda dari jadwal yang bisa berubah tiap semester.
     */
    public function mataPelajaran(): BelongsToMany
    {
        return $this->belongsToMany(MataPelajaran::class, 'guru_mata_pelajaran')
                    ->withPivot(['jurusan_id', 'jam_per_minggu', 'is_mapel_utama', 'is_active'])
                    ->withTimestamps();
    }

    /**
     * Jurusan yang menjadi tanggung jawab mengajar guru ini (via pivot mapel).
     */
    public function jurusan(): BelongsToMany
    {
        return $this->belongsToMany(Jurusan::class, 'guru_mata_pelajaran')
                    ->withPivot(['mata_pelajaran_id', 'is_active'])
                    ->distinct();
    }

    public function jadwalPiket(): HasMany
    {
        return $this->hasMany(JadwalPiketGuru::class);
    }

    public function logPiket(): HasMany
    {
        return $this->hasMany(LogPiket::class);
    }

    public function materi(): HasMany
    {
        return $this->hasMany(Materi::class);
    }

    public function tugas(): HasMany
    {
        return $this->hasMany(Tugas::class);
    }

    public function jurnal(): HasMany
    {
        return $this->hasMany(JurnalMengajar::class);
    }

    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    public function absensiGuru(): HasMany
    {
        return $this->hasMany(AbsensiGuru::class);
    }

    public function absensiHariIni(): HasOne
    {
        return $this->hasOne(AbsensiGuru::class, 'guru_id')
                    ->whereDate('tanggal', today());
    }
}