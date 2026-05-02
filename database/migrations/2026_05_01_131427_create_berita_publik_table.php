<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ── Berita / Artikel Publik ────────────────────────────────────
        Schema::create('berita_publik', function (Blueprint $table) {
            $table->id();

            $table->foreignId('berita_kategori_id')->nullable()->constrained('berita_kategori')->nullOnDelete();

            // ── Konten ────────────────────────────────────────────────
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('ringkasan')->nullable();                  // untuk preview/meta
            $table->longText('konten');                             // isi artikel (HTML/Markdown)

            // ── Gambar ────────────────────────────────────────────────
            $table->string('thumbnail_path')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('thumbnail_alt')->nullable();

            // ── Meta & SEO ────────────────────────────────────────────
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('tags')->nullable();                     // comma-separated

            // ── Penulis & Status ──────────────────────────────────────
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_penulis')->nullable();             // override jika bukan user sistem
            $table->enum('status', ['draft', 'review', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('views')->default(0);

            $table->boolean('is_featured')->default(false);        // tampilkan di slider beranda
            $table->boolean('allow_comment')->default(false);

            $table->timestamps();

            $table->index('status');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_publik');
    }
};
