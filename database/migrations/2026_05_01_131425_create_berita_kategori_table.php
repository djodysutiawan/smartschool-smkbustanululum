<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel: berita_kategori & berita_publik
     *
     * CATATAN: Berbeda dengan tabel `pengumuman` yang sudah ada (internal/notifikasi untuk user login),
     * tabel ini khusus untuk konten PUBLIK yang tampil di website/landing page:
     *  - Berita sekolah
     *  - Artikel / blog sekolah
     *  - Pengumuman publik (PPDB, kegiatan terbuka, dll)
     */
    public function up(): void
    {
        // ── Kategori Berita ────────────────────────────────────────────
        Schema::create('berita_kategori', function (Blueprint $table) {
            $table->id();

            $table->string('nama');                                 // Berita, Pengumuman, Kegiatan
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('warna')->nullable();                    // hex / Tailwind class untuk badge
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('urutan')->default(0);

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('berita_publik');
        Schema::dropIfExists('berita_kategori');
    }
};