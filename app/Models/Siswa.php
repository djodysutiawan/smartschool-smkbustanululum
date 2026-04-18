<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'siswa';

    protected $fillable = [
        'pengguna_id', 'nis', 'nisn', 'nama_lengkap', 'jenis_kelamin',
        'tempat_lahir', 'tanggal_lahir', 'agama', 'alamat', 'no_hp', 'email', 'foto',
        'nama_ayah', 'pekerjaan_ayah', 'no_hp_ayah',
        'nama_ibu', 'pekerjaan_ibu', 'no_hp_ibu',
        'nama_wali', 'hubungan_wali', 'pekerjaan_wali', 'no_hp_wali',
        'kelas_id', 'tahun_ajaran_id', 'status', 'tanggal_masuk', 'tanggal_keluar',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir'  => 'date',
            'tanggal_masuk'  => 'date',
            'tanggal_keluar' => 'date',
        ];
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
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

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function orangTua()
    {
        return $this->belongsToMany(OrangTua::class, 'siswa_orang_tua', 'siswa_id', 'orang_tua_id')
            ->withPivot('hubungan', 'kontak_utama')
            ->withTimestamps();
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function nilaiMapel(int $mapelId, int $tahunAjaranId)
    {
        return $this->nilai()
            ->where('mata_pelajaran_id', $mapelId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->first();
    }

    public function getTotalPoinPelanggaranAttribute(): int
    {
        return $this->pelanggaran()
            ->where('status', '!=', 'dibatalkan')
            ->sum('poin') ?? 0;
    }

    public function getPersentaseKehadiranAttribute(): float
    {
        $total = $this->absensi()->count();
        if ($total === 0) return 100.0;
        $hadir = $this->absensi()->whereIn('status', ['hadir', 'telat'])->count();
        return round(($hadir / $total) * 100, 2);
    }
}