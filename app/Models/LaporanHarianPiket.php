<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaporanHarianPiket extends Model
{
    protected $table = 'laporan_harian_piket';

    protected $fillable = [
        'dibuat_oleh',
        'tanggal',
        'catatan_umum',
        'rekap_absensi',     // JSON: snapshot absensi guru hari itu
        'kondisi_sekolah',
        'tamu_penting',
        'kejadian_khusus',
    ];

    protected $casts = [
        'tanggal'       => 'date',
        'rekap_absensi' => 'array',  // cast JSON → array otomatis
    ];

    // ─── Relasi ───────────────────────────────────────────────────────────────

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    /**
     * FIX: Relasi pelanggaran agar bisa dipakai withCount() di controller.
     * Relasi ini meng-query pelanggaran berdasarkan dicatat_oleh + tanggal.
     * Karena withCount() standar membutuhkan FK relasi, kita definisikan
     * relasi HasMany berdasarkan dicatat_oleh, lalu filter tanggal via
     * query scope di controller jika diperlukan.
     *
     * Untuk keperluan index (count per laporan), gunakan:
     *   LaporanHarianPiket::withCount(['pelanggaran'])->...
     * dengan kondisi bahwa tanggal pelanggaran = tanggal laporan,
     * ini di-handle via whereColumn() di relasi.
     */
    public function pelanggaran(): HasMany
    {
        return $this->hasMany(Pelanggaran::class, 'dicatat_oleh', 'dibuat_oleh')
                    ->whereColumn(
                        \Illuminate\Support\Facades\DB::raw('DATE(pelanggaran.tanggal)'),
                        '=',
                        \Illuminate\Support\Facades\DB::raw('DATE(laporan_harian_piket.tanggal)')
                    );
    }

    // ─── Accessor ─────────────────────────────────────────────────────────────

    /**
     * Tanggal dalam format Indonesia: "Senin, 20 April 2026"
     */
    public function getTanggalFormattedAttribute(): string
    {
        return $this->tanggal
            ? $this->tanggal->translatedFormat('l, d F Y')
            : '-';
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Ambil semua izin keluar siswa pada hari yang sama dengan laporan ini.
     */
    public function getIzinKeluarSiswa()
    {
        return IzinKeluarSiswa::with(['siswa.kelas', 'diprosesOleh'])
            ->whereDate('tanggal', $this->tanggal)
            ->orderBy('jam_keluar')
            ->get();
    }

    /**
     * Ringkasan statistik izin keluar siswa untuk hari laporan ini.
     */
    public function getRingkasanIzinKeluar(): array
    {
        $izin = $this->getIzinKeluarSiswa();

        return [
            'total'         => $izin->count(),
            'disetujui'     => $izin->filter(fn($i) => in_array($i->status, [
                                    IzinKeluarSiswa::STATUS_DISETUJUI,
                                    IzinKeluarSiswa::STATUS_SUDAH_KEMBALI,
                               ]))->count(),
            'ditolak'       => $izin->filter(fn($i) =>
                                    $i->status === IzinKeluarSiswa::STATUS_DITOLAK
                               )->count(),
            'belum_kembali' => $izin->filter(fn($i) =>
                                    $i->status === IzinKeluarSiswa::STATUS_DISETUJUI
                               )->count(),
            'sudah_kembali' => $izin->filter(fn($i) =>
                                    $i->status === IzinKeluarSiswa::STATUS_SUDAH_KEMBALI
                               )->count(),
        ];
    }
}