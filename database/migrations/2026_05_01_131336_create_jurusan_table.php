<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel: jurusan
     * Informasi lengkap program keahlian / jurusan sekolah.
     */
    public function up(): void
    {
        Schema::create('jurusan', function (Blueprint $table) {
            $table->id();

            // ── Identitas ─────────────────────────────────────────────
            $table->string('nama');                                 // Teknik Komputer dan Jaringan
            $table->string('singkatan')->nullable();                // TKJ
            $table->string('slug')->unique();
            $table->string('kode_jurusan')->nullable();             // kode resmi dari kemendikbud
            $table->string('bidang_keahlian')->nullable();          // Teknologi Informasi & Komunikasi
            $table->string('program_keahlian')->nullable();
            $table->string('kompetensi_keahlian')->nullable();

            // ── Deskripsi ─────────────────────────────────────────────
            $table->text('deskripsi_singkat')->nullable();          // untuk card/preview
            $table->longText('deskripsi_lengkap')->nullable();      // halaman detail (HTML/Markdown)
            $table->text('tujuan_jurusan')->nullable();

            // ── Gambar ────────────────────────────────────────────────
            $table->string('foto_cover_path')->nullable();
            $table->string('foto_cover_url')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('logo_url')->nullable();

            // ── Informasi Operasional ─────────────────────────────────
            $table->tinyInteger('lama_belajar')->default(3);        // tahun
            $table->string('akreditasi', 5)->nullable();
            $table->unsignedSmallInteger('kapasitas_per_kelas')->nullable();
            $table->unsignedSmallInteger('jumlah_kelas_aktif')->nullable();
            $table->unsignedSmallInteger('total_siswa')->nullable(); // bisa dihitung dari tabel siswa

            // ── Kepala Jurusan ────────────────────────────────────────
            $table->string('nama_kajur')->nullable();
            $table->string('foto_kajur_path')->nullable();
            $table->string('foto_kajur_url')->nullable();

            // ── Status & Urutan ───────────────────────────────────────
            $table->boolean('is_published')->default(true);
            $table->boolean('is_penerimaan_buka')->default(true);   // apakah buka PPDB
            $table->unsignedSmallInteger('urutan')->default(0);

            // ── Relasi ke tabel kelas (opsional) ──────────────────────
            // jurusan.id akan direferensikan dari tabel kelas jika diperlukan

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusan');
    }
};