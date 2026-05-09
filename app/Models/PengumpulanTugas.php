<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PengumpulanTugas extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_tugas';

    /**
     * Status enum yang valid.
     * Catatan: STATUS_BELUM umumnya tidak ada sebagai record di tabel —
     * siswa yang belum kumpul tidak memiliki row sama sekali.
     * Konstanta ini dipakai untuk query/filter dari luar (misal Tugas model).
     */
    const STATUS_BELUM       = 'belum_dikumpulkan';
    const STATUS_DIKUMPULKAN = 'dikumpulkan';
    const STATUS_TERLAMBAT   = 'terlambat';
    const STATUS_DINILAI     = 'sudah_dinilai';

    /**
     * Jenis pengumpulan yang valid — harus sinkron dengan Tugas::JENIS_PENGUMPULAN
     * dan TugasController::JENIS_PENGUMPULAN.
     */
    const JENIS_VALID = ['file', 'teks', 'link', 'foto'];

    /**
     * FIX: Nama kolom diselaraskan dengan yang dipakai controller & view.
     * Kolom DB yang dipakai:
     *   - jenis_pengumpulan  (bukan ada di model lama — WAJIB ditambah ke migrasi/DB)
     *   - konten_teks        (sebelumnya: jawaban_teks)
     *   - link_pengumpulan   (sebelumnya: url_link)
     *   - file_pengumpulan   (sebelumnya: path_file)
     *   - catatan            (sebelumnya: tidak ada — WAJIB ditambah ke migrasi/DB)
     *   - nilai, umpan_balik, status, dikumpulkan_pada, dinilai_pada (tidak berubah)
     *
     * JIKA nama kolom DB tidak bisa diubah, rename di sini dan sesuaikan
     * controller + view menggunakan nama kolom DB yang lama.
     */
    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'jenis_pengumpulan',   // file | teks | link | foto
        'konten_teks',         // jawaban teks (jika jenis = teks)
        'link_pengumpulan',    // URL/link (jika jenis = link)
        'file_pengumpulan',    // path file di storage (jika jenis = file/foto)
        'catatan',             // catatan tambahan dari siswa (opsional)
        'nilai',
        'umpan_balik',
        'status',
        'dikumpulkan_pada',
        'dinilai_pada',
    ];

    protected function casts(): array
    {
        return [
            'nilai'           => 'decimal:2',
            'dikumpulkan_pada'=> 'datetime',
            'dinilai_pada'    => 'datetime',
            // FIX: cast FK ke integer agar perbandingan tidak mismatch string vs int
            'tugas_id'        => 'integer',
            'siswa_id'        => 'integer',
        ];
    }

    // ── Business Logic ─────────────────────────────────────────────────────────

    /**
     * Cek apakah pengumpulan ini terlambat berdasarkan batas_waktu tugas.
     *
     * FIX: Jika dipanggil dalam loop (misal collection), pastikan relasi tugas
     * sudah di-eager load sebelumnya dengan ->with('tugas') untuk hindari N+1.
     */
    public function isTerlambat(): bool
    {
        if (! $this->dikumpulkan_pada) {
            return false;
        }

        // Gunakan relasi yang sudah di-load jika ada, hindari query tambahan
        $tugas = $this->relationLoaded('tugas')
            ? $this->tugas
            : $this->load('tugas')->tugas;

        if (! $tugas || ! $tugas->batas_waktu) {
            return false;
        }

        return $this->dikumpulkan_pada->isAfter($tugas->batas_waktu);
    }

    /**
     * Beri nilai pada pengumpulan ini.
     * Otomatis set status ke sudah_dinilai dan catat waktu penilaian.
     *
     * FIX: Validasi nilai tidak melebihi nilai_maksimal tugas dilakukan
     * di level controller/service, bukan di sini — model tidak fetch relasi
     * untuk validasi domain agar tetap lean.
     */
    public function beriNilai(float $nilai, ?string $umpanBalik = null): void
    {
        $this->update([
            'nilai'        => $nilai,
            'umpan_balik'  => $umpanBalik,
            'status'       => self::STATUS_DINILAI,
            'dinilai_pada' => now(),
        ]);
    }

    /**
     * Reset penilaian (kembalikan ke status sebelum dinilai).
     *
     * FIX: isTerlambat() bisa trigger lazy load — panggil sebelum update
     * agar hasilnya konsisten dan tidak ada query di tengah transaksi update.
     */
    public function kembalikanPenilaian(): void
    {
        // Evaluasi dulu sebelum update agar tidak ada lazy load di tengah jalan
        $statusSebelum = $this->isTerlambat()
            ? self::STATUS_TERLAMBAT
            : self::STATUS_DIKUMPULKAN;

        $this->update([
            'nilai'        => null,
            'umpan_balik'  => null,
            'status'       => $statusSebelum,
            'dinilai_pada' => null,
        ]);
    }

    public function sudahDinilai(): bool
    {
        return $this->status === self::STATUS_DINILAI;
    }

    /**
     * Hapus file fisik dari storage jika ada.
     * Panggil sebelum delete record agar tidak ada file orphan.
     */
    public function hapusFile(): void
    {
        if ($this->file_pengumpulan && Storage::disk('public')->exists($this->file_pengumpulan)) {
            Storage::disk('public')->delete($this->file_pengumpulan);
        }
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /**
     * FIX: Nama kolom file sekarang file_pengumpulan (bukan path_file).
     */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file_pengumpulan
            ? asset('storage/' . $this->file_pengumpulan)
            : null;
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_BELUM       => 'Belum Dikumpulkan',
            self::STATUS_DIKUMPULKAN => 'Dikumpulkan',
            self::STATUS_TERLAMBAT   => 'Terlambat',
            self::STATUS_DINILAI     => 'Sudah Dinilai',
            default                  => ucfirst(str_replace('_', ' ', $this->status ?? '')),
        };
    }

    /**
     * FIX: Accessor label jenis untuk konsistensi tampilan di view.
     */
    public function getLabelJenisAttribute(): string
    {
        return match ($this->jenis_pengumpulan) {
            'file' => 'File',
            'foto' => 'Foto',
            'teks' => 'Teks',
            'link' => 'Link',
            default => ucfirst($this->jenis_pengumpulan ?? '-'),
        };
    }

    // ── Relationships ──────────────────────────────────────────────────────────

    public function tugas(): BelongsTo
    {
        return $this->belongsTo(Tugas::class);
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}