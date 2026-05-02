<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel: prestasi
     * Pencapaian / penghargaan sekolah maupun siswa.
     */
    public function up(): void
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();

            $table->string('judul');                                // Juara 1 LKS Nasional
            $table->text('deskripsi')->nullable();
            $table->enum('tingkat', [
                'sekolah', 'kecamatan', 'kabupaten', 'provinsi', 'nasional', 'internasional'
            ])->default('sekolah');
            $table->string('bidang')->nullable();                   // Akademik / Olahraga / Seni
            $table->string('nama_event')->nullable();               // LKS 2025
            $table->string('penyelenggara')->nullable();            // Kemendikbud
            $table->string('peringkat')->nullable();                // Juara 1 / Medali Emas
            $table->date('tanggal')->nullable();
            $table->year('tahun')->nullable();

            // ── Penerima Prestasi ─────────────────────────────────────
            $table->enum('tipe_penerima', ['sekolah', 'siswa', 'guru', 'tim'])->default('siswa');
            $table->string('nama_penerima')->nullable();            // nama siswa/tim
            $table->foreignId('siswa_id')->nullable()->constrained('siswa')->nullOnDelete();
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusan')->nullOnDelete();

            // ── Gambar ────────────────────────────────────────────────
            $table->string('foto_path')->nullable();
            $table->string('foto_url')->nullable();
            $table->string('sertifikat_path')->nullable();

            $table->boolean('is_published')->default(true);
            $table->boolean('is_featured')->default(false);        // tampilkan di beranda
            $table->unsignedSmallInteger('urutan')->default(0);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};