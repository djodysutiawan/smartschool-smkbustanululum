<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model ini DIASUMSIKAN sudah ada di project Anda.
 * Yang ditambahkan: accessor tanggalFormatted, dan catatan untuk
 * relasi ke IzinKeluarSiswa (via tanggal, bukan FK langsung).
 *
 * Sesuaikan $fillable dan $casts dengan kolom migrasi Anda yang asli.
 */
class LaporanHarianPiket extends Model
{
    protected $table = 'laporan_harian_piket';

    protected $fillable = [
        'dibuat_oleh',
        'tanggal',
        'catatan_umum',
        'rekap_absensi',    // JSON: snapshot absensi guru hari itu
        'kondisi_sekolah',
        'tamu_penting',
        'kejadian_khusus',
    ];

    protected $casts = [
        'tanggal'      => 'date',
        'rekap_absensi' => 'array',     // cast JSON → array otomatis
    ];

    // ─── Relasi ───────────────────────────────────────────────────────────────

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
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

    // ─── Helper: ambil izin keluar siswa pada hari yang sama ─────────────────
    //
    // Tidak dibuat sebagai relasi Eloquent resmi karena join-nya berbasis
    // kesamaan DATE (bukan FK). Gunakan method di controller / di view:
    //
    //   $izin = IzinKeluarSiswa::whereDate('tanggal', $laporan->tanggal)->get();
    //
    // Method di bawah ini tersedia sebagai shortcut jika perlu dipanggil
    // langsung dari objek laporan (misal: di blade atau di job queue).

    public function getIzinKeluarSiswa()
    {
        return IzinKeluarSiswa::with(['siswa.kelas', 'diprosesOleh'])
            ->whereDate('tanggal', $this->tanggal)
            ->orderBy('jam_keluar')
            ->get();
    }

    public function getRingkasanIzinKeluar(): array
    {
        $izin = $this->getIzinKeluarSiswa();

        return [
            'total'         => $izin->count(),
            'disetujui'     => $izin->whereIn('status', [
                                    IzinKeluarSiswa::STATUS_DISETUJUI,
                                    IzinKeluarSiswa::STATUS_SUDAH_KEMBALI,
                               ])->count(),
            'ditolak'       => $izin->where('status', IzinKeluarSiswa::STATUS_DITOLAK)->count(),
            'belum_kembali' => $izin->where('status', IzinKeluarSiswa::STATUS_DISETUJUI)->count(),
        ];
    }
}