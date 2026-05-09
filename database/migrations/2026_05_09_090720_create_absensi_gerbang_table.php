<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel absensi_gerbang
 * ─────────────────────────────────────────────────────────────────────────────
 * Log scan barcode siswa di pos gerbang sekolah.
 * Satu baris = satu event scan (masuk atau pulang).
 *
 * Alur normal:
 *   Guru piket buka sesi → siswa tunjukkan barcode → alat scan → data masuk sini
 *
 * Alur manual:
 *   Jika alat rusak / siswa lupa bawa ID → guru piket input manual
 *   (is_manual = true, input_oleh = user_id guru piket)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi_gerbang', function (Blueprint $table) {
            $table->id();

            // Sesi gerbang tempat scan ini terjadi
            $table->foreignId('sesi_gerbang_id')
                  ->constrained('sesi_gerbang')
                  ->restrictOnDelete();

            // Siswa yang scan — nullable agar tetap bisa menyimpan data
            // jika barcode terbaca tapi siswa tidak ditemukan (kode asing)
            $table->foreignId('siswa_id')
                  ->nullable()
                  ->constrained('siswa')
                  ->nullOnDelete();

            // Barcode yang digunakan saat scan
            // Disimpan terpisah sebagai string agar riwayat tetap ada
            // meski barcode nanti di-regenerate
            $table->foreignId('barcode_gerbang_id')
                  ->nullable()
                  ->constrained('barcode_gerbang')
                  ->nullOnDelete();

            // Raw kode yang diterima dari alat scanner
            // Berguna untuk debug jika kode tidak dikenali sistem
            $table->string('kode_scan', 100)->index();

            // Tipe scan: masuk (pagi) atau pulang (sore)
            // Diisi otomatis dari tipe sesi, bisa dikoreksi manual
            $table->enum('tipe', ['masuk', 'pulang'])->index();

            // Waktu persis alat melakukan scan
            $table->dateTime('waktu_scan')->index();

            // Tanggal scan — denormalized dari waktu_scan untuk mempermudah
            // query rekap harian tanpa DATE() function
            $table->date('tanggal_scan')->index();

            // ── Status & Koreksi ──────────────────────────────────────────

            // normal   : scan valid pertama kali
            // duplikat : scan kedua+ pada sesi yang sama untuk siswa yang sama
            // koreksi  : tipe scan diubah oleh admin/piket setelah scan
            // manual   : diinput manual (bukan dari alat)
            $table->enum('status', ['normal', 'duplikat', 'koreksi', 'manual'])
                  ->default('normal')
                  ->index();

            // true jika record ini dibuat secara manual (bukan dari alat)
            $table->boolean('is_manual')->default(false)->index();

            // User yang melakukan input manual atau koreksi
            $table->foreignId('input_oleh')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Alasan koreksi / catatan manual
            $table->text('catatan')->nullable();

            // Jika ini record koreksi, simpan referensi ke record aslinya
            $table->foreignId('koreksi_dari_id')
                  ->nullable()
                  ->constrained('absensi_gerbang')
                  ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // ── Indexes untuk query umum ──────────────────────────────────

            // Rekap per siswa per tanggal
            $table->index(['siswa_id', 'tanggal_scan']);

            // Rekap per sesi
            $table->index(['sesi_gerbang_id', 'tipe']);

            // Live monitor — scan terbaru di sesi aktif
            $table->index(['sesi_gerbang_id', 'waktu_scan']);

            // Deteksi duplikat — siswa + sesi + tipe
            $table->index(['siswa_id', 'sesi_gerbang_id', 'tipe']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi_gerbang');
    }
};