<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel sesi_gerbang
 * ─────────────────────────────────────────────────────────────────────────────
 * Satu baris = satu sesi buka/tutup gerbang.
 * Guru piket membuka sesi → alat scanner mengirim data selama sesi aktif
 * → guru piket menutup sesi.
 *
 * Dalam satu hari normalnya ada 2 sesi:
 *   - masuk  : pagi hari (siswa datang ke sekolah)
 *   - pulang : sore hari (siswa meninggalkan sekolah)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesi_gerbang', function (Blueprint $table) {
            $table->id();

            // Guru piket yang membuka sesi
            $table->foreignId('dibuka_oleh')
                  ->constrained('users')
                  ->restrictOnDelete();

            // Guru piket yang menutup sesi (bisa beda orang)
            $table->foreignId('ditutup_oleh')
                  ->nullable()
                  ->constrained('users')
                  ->restrictOnDelete();

            // Tipe sesi: masuk (pagi) atau pulang (sore)
            $table->enum('tipe', ['masuk', 'pulang'])->index();

            // Tanggal sesi berlangsung (terpisah dari waktu agar mudah di-query per hari)
            $table->date('tanggal')->index();

            // Waktu sesi dibuka dan ditutup
            $table->dateTime('dibuka_pada');
            $table->dateTime('ditutup_pada')->nullable();

            // Status sesi: aktif = masih berjalan, ditutup = sudah selesai
            $table->enum('status', ['aktif', 'ditutup'])->default('aktif')->index();

            // Catatan tambahan dari guru piket (misal: ada gangguan alat, dll.)
            $table->text('catatan')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Satu tipe sesi per tanggal tidak boleh aktif lebih dari sekali
            // (enforced di application layer, bukan DB constraint, agar lebih fleksibel)
            $table->index(['tanggal', 'tipe', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_gerbang');
    }
};