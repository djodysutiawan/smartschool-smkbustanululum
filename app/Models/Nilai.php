<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id',
        'guru_id',
        'kelas_id',
        'tahun_ajaran_id',
        'nilai_tugas',
        'nilai_harian',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'predikat',
        'catatan',
    ];

    // FIX #1: Gunakan 'float' bukan 'decimal:2' karena decimal:2 mengembalikan
    // string di Eloquent, bukan float. Ini menyebabkan perbandingan numerik
    // di hitungNilaiAkhir() dan tentukanPredikat() bisa tidak akurat.
    // Format tampilan (2 desimal) ditangani di view / accessor, bukan di cast.
    protected function casts(): array
    {
        return [
            'nilai_tugas'  => 'float',
            'nilai_harian' => 'float',
            'nilai_uts'    => 'float',
            'nilai_uas'    => 'float',
            'nilai_akhir'  => 'float',
        ];
    }

    // ── Booted ─────────────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            // FIX #2: Hanya jalankan kalkulasi jika setidaknya satu komponen
            // nilai di-set. Ini mencegah nilai_akhir = 0 dan predikat = 'E'
            // pada record yang baru dibuat tanpa nilai apapun.
            if ($model->adaKomponenNilai()) {
                $model->hitungNilaiAkhir();
                $model->tentukanPredikat();
            }
        });
    }

    // ── Business Logic ─────────────────────────────────────────────────────────

    /**
     * Cek apakah setidaknya satu komponen nilai sudah diisi.
     */
    public function adaKomponenNilai(): bool
    {
        return ! is_null($this->nilai_tugas)
            || ! is_null($this->nilai_harian)
            || ! is_null($this->nilai_uts)
            || ! is_null($this->nilai_uas);
    }

    /**
     * Hitung nilai akhir dengan bobot:
     * Tugas 20% | Harian 30% | UTS 20% | UAS 30%
     *
     * FIX #3: Komponen null tidak dihitung dalam pembagi bobot sehingga
     * nilai parsial tidak mendistorsi rata-rata ke bawah secara tidak adil.
     * Contoh: jika hanya tugas (20%) dan harian (30%) diisi → dibagi 50, bukan 100.
     *
     * Jika semua null (sudah divalidasi di booted), set nilai_akhir = null.
     */
    public function hitungNilaiAkhir(): void
    {
        $komponenBobot = [
            'nilai_tugas'  => 0.20,
            'nilai_harian' => 0.30,
            'nilai_uts'    => 0.20,
            'nilai_uas'    => 0.30,
        ];

        $totalBobot  = 0;
        $totalNilai  = 0;

        foreach ($komponenBobot as $field => $bobot) {
            if (! is_null($this->{$field})) {
                // FIX #4: Clamp nilai ke range 0–100 agar tidak ada nilai negatif
                // atau di atas 100 yang merusak kalkulasi
                $v = max(0, min(100, (float) $this->{$field}));
                $totalNilai += $v * $bobot;
                $totalBobot += $bobot;
            }
        }

        if ($totalBobot == 0) {
            $this->nilai_akhir = null;
            return;
        }

        // Normalisasi: jika tidak semua komponen diisi, proporsi ulang
        $this->nilai_akhir = round($totalNilai / $totalBobot * 100 / 100, 2);

        // NOTE: Jika preferensi bisnis adalah menghitung bobot penuh
        // (komponen kosong = 0), ganti dengan:
        // $this->nilai_akhir = round($totalNilai, 2);
        // dan hapus logika $totalBobot di atas.
    }

    /**
     * Tentukan predikat berdasarkan nilai_akhir.
     *
     * FIX #5: Guard null — jika nilai_akhir null, set predikat null
     * (bukan 'E') agar membedakan antara "belum dinilai" dan "nilai buruk".
     */
    public function tentukanPredikat(): void
    {
        if (is_null($this->nilai_akhir)) {
            $this->predikat = null;
            return;
        }

        $nilai = (float) $this->nilai_akhir;

        $this->predikat = match (true) {
            $nilai >= 90 => 'A',
            $nilai >= 80 => 'B',
            $nilai >= 70 => 'C',
            $nilai >= 60 => 'D',
            default      => 'E',
        };
    }

    /**
     * Apakah nilai ini lulus (nilai_akhir >= KKM)?
     *
     * FIX #6: Jika nilai_akhir null, anggap tidak lulus (false),
     * bukan throw error saat cast null ke float.
     */
    public function isLulus(int $kkm = 70): bool
    {
        if (is_null($this->nilai_akhir)) {
            return false;
        }

        return (float) $this->nilai_akhir >= $kkm;
    }

    // ── Accessors ──────────────────────────────────────────────────────────────

    /**
     * Accessor untuk nilai akhir yang sudah diformat (2 desimal).
     * Gunakan $nilai->nilai_akhir_formatted di view untuk tampilan.
     */
    public function getNilaiAkhirFormattedAttribute(): string
    {
        return is_null($this->nilai_akhir)
            ? '—'
            : number_format((float) $this->nilai_akhir, 2);
    }

    /**
     * Kembalikan class CSS predikat (untuk badge warna di view).
     */
    public function getPredikatClassAttribute(): string
    {
        return 'pred-' . ($this->predikat ?? 'null');
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeByPredikat($query, string $predikat)
    {
        return $query->where('predikat', $predikat);
    }

    /**
     * FIX #7: Tambah scope lulus agar query KKM tidak hard-coded di controller.
     */
    public function scopeLulus($query, int $kkm = 70)
    {
        return $query->where('nilai_akhir', '>=', $kkm);
    }

    public function scopeBelumLulus($query, int $kkm = 70)
    {
        return $query->where('nilai_akhir', '<', $kkm);
    }

    // ── Relationships ──────────────────────────────────────────────────────────

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}