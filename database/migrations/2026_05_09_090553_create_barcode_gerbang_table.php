<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel barcode_gerbang
 * ─────────────────────────────────────────────────────────────────────────────
 * Menyimpan barcode TETAP per siswa yang digunakan untuk scan gerbang
 * (masuk pagi & pulang sore). Dipisah dari tabel `siswa` agar:
 *   - Barcode bisa di-regenerate tanpa mengubah data pokok siswa
 *   - Satu siswa hanya boleh punya SATU barcode aktif pada satu waktu
 *   - Riwayat barcode lama tetap tersimpan (is_aktif = false)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barcode_gerbang', function (Blueprint $table) {
            $table->id();

            // Satu siswa bisa punya banyak barcode (riwayat), tapi hanya 1 aktif
            $table->foreignId('siswa_id')
                  ->constrained('siswa')
                  ->cascadeOnDelete();

            // Nilai barcode unik — format bebas, misal: "SIS-00123-2024" atau UUID
            $table->string('kode', 100)->unique();

            // true = barcode ini yang saat ini digunakan alat scanner
            $table->boolean('is_aktif')->default(true)->index();

            // Kapan barcode ini mulai berlaku
            $table->date('berlaku_mulai');

            // Kapan barcode ini berakhir (null = tidak ada batas, berlaku terus)
            $table->date('berlaku_sampai')->nullable();

            // Catatan tambahan: alasan regenerasi, dll.
            $table->text('keterangan')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Composite index untuk query "barcode aktif milik siswa X"
            $table->index(['siswa_id', 'is_aktif']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barcode_gerbang');
    }
};