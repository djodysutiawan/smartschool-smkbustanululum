<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiUjian extends Model
{
    use HasFactory;

    protected $table = 'sesi_ujian';

    protected $fillable = [
        'ujian_id',
        'siswa_id',
        'mulai_pada',
        'selesai_pada',
        'batas_waktu_pada',
        'status',
        'nilai_akhir',
        'total_benar',
        'total_salah',
        'total_kosong',
        'lulus',
    ];

    protected function casts(): array
    {
        return [
            'mulai_pada'       => 'datetime',
            'selesai_pada'     => 'datetime',
            'batas_waktu_pada' => 'datetime',
            'nilai_akhir'      => 'decimal:2',
            'lulus'            => 'boolean',
        ];
    }

    // ── Scopes ────────────────────────────────────────────────────

    public function scopeBerlangsung($query)
    {
        return $query->where('status', 'berlangsung');
    }

    public function scopeSelesai($query)
    {
        return $query->whereIn('status', ['selesai', 'habis_waktu']);
    }

    // ── Accessors / Helpers ───────────────────────────────────────

    public function isHabisWaktu(): bool
    {
        return $this->batas_waktu_pada && Carbon::now()->gt($this->batas_waktu_pada);
    }

    public function getSisaDetikAttribute(): int
    {
        if (! $this->batas_waktu_pada || $this->status !== 'berlangsung') return 0;
        return max(0, (int) Carbon::now()->diffInSeconds($this->batas_waktu_pada, false));
    }

    /**
     * Mulai sesi: set waktu mulai & batas waktu berdasarkan durasi ujian.
     */
    public function mulai(): void
    {
        $now = Carbon::now();
        $this->update([
            'status'           => 'berlangsung',
            'mulai_pada'       => $now,
            'batas_waktu_pada' => $now->copy()->addMinutes($this->ujian->durasi_menit),
        ]);
    }

    /**
     * Selesaikan sesi dan hitung nilai secara otomatis.
     */
    public function selesaikan(bool $habisWaktu = false): void
    {
        $this->hitungNilai();
        $this->update([
            'status'       => $habisWaktu ? 'habis_waktu' : 'selesai',
            'selesai_pada' => Carbon::now(),
        ]);
    }

    /**
     * Hitung nilai otomatis dari jawaban yang sudah masuk.
     *
     * FIX [Critical]: Essay yang belum dikoreksi (poin_didapat = null, adalah_benar = null)
     * sebelumnya masuk ke bucket "kosong" di dalam foreach, lalu $kosong ditimpa ulang
     * dengan formula (totalSoal - benar - salah). Akibatnya essay pending ikut terhitung
     * sebagai "salah" karena `adalah_benar` null membuat cabang else ($salah++) terpanggil.
     *
     * Perbaikan:
     * 1. Tambahkan cabang khusus essay pending: jenis_soal = essay DAN poin_didapat null.
     * 2. Hapus variabel $kosong di dalam foreach (dead code — langsung ditimpa di bawah).
     * 3. Hitung $kosong satu kali di akhir: soal yang sama sekali belum dijawab
     *    (tidak ada baris di jawaban_siswa) + essay pending yang ada baris tapi belum dikoreksi
     *    keduanya masuk kosong, bukan salah.
     */
    public function hitungNilai(): void
    {
        $jawabans = $this->jawaban()->with('soal')->get();

        $totalBobot  = $this->ujian->soal()->sum('bobot');
        $totalSoal   = $this->ujian->soal()->count();
        $poinDidapat = 0;
        $benar       = 0;
        $salah       = 0;
        // Essay pending (ada jawaban tersimpan tapi belum dikoreksi guru)
        $essayPending = 0;

        foreach ($jawabans as $j) {
            // Essay yang belum dikoreksi — jangan masukkan ke salah
            if (
                $j->soal
                && $j->soal->jenis_soal === 'essay'
                && is_null($j->poin_didapat)
            ) {
                $essayPending++;
                continue;
            }

            if ($j->adalah_benar === null) {
                // Jawaban ada tapi status benar/salah belum ditentukan (seharusnya tidak terjadi
                // untuk soal non-essay, tapi kita handle agar tidak crash)
                continue;
            }

            if ($j->adalah_benar) {
                $benar++;
                $poinDidapat += (float) $j->poin_didapat;
            } else {
                $salah++;
            }
        }

        // Soal yang tidak punya baris jawaban sama sekali = benar-benar kosong
        $tidakDijawab = $totalSoal - $jawabans->count();

        // kosong = tidak dijawab sama sekali + essay pending (belum dikoreksi)
        $kosong = $tidakDijawab + $essayPending;

        $nilaiAkhir = $totalBobot > 0
            ? round(($poinDidapat / $totalBobot) * 100, 2)
            : 0;

        $this->update([
            'total_benar'  => $benar,
            'total_salah'  => $salah,
            'total_kosong' => $kosong,
            'nilai_akhir'  => $nilaiAkhir,
            'lulus'        => $nilaiAkhir >= $this->ujian->nilai_kkm,
        ]);
    }

    // ── Relationships ─────────────────────────────────────────────

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanSiswa::class);
    }
}