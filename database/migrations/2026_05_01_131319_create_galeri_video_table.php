<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel: galeri_video
     * Koleksi video sekolah — mendukung upload file lokal ATAU link YouTube/platform lain.
     */
    public function up(): void
    {
        Schema::create('galeri_video', function (Blueprint $table) {
            $table->id();

            $table->foreignId('galeri_kategori_id')->nullable()->constrained('galeri_kategori')->nullOnDelete();

            $table->string('judul');                                // title video
            $table->text('deskripsi')->nullable();

            // ── Sumber Video (salah satu diisi) ───────────────────────
            $table->enum('tipe_sumber', ['upload', 'youtube', 'vimeo', 'url_lain'])->default('youtube');
            $table->string('video_path')->nullable();               // jika upload lokal
            $table->string('video_url')->nullable();                // URL asli (YouTube, Vimeo, dll)
            $table->string('video_embed_id')->nullable();           // YouTube video ID / Vimeo ID
            $table->string('video_embed_url')->nullable();          // URL embed siap pakai (digenerate otomatis)

            // ── Thumbnail ─────────────────────────────────────────────
            $table->string('thumbnail_path')->nullable();           // custom thumbnail upload
            $table->string('thumbnail_url')->nullable();            // atau URL (bisa dari YouTube API)

            // ── Meta ──────────────────────────────────────────────────
            $table->string('durasi')->nullable();                   // "10:32" format string
            $table->date('tanggal_video')->nullable();
            $table->string('sumber')->nullable();                   // kredit / channel
            $table->boolean('is_published')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedSmallInteger('urutan')->default(0);     // sort order drag & drop

            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri_video');
    }
};