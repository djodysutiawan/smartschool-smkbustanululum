<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel pendukung tampilan publik:
     *  - slider_beranda  : banner/hero slider di halaman utama
     *  - link_cepat      : tombol/link cepat yang tampil di beranda atau sidebar
     *  - agenda_sekolah  : kalender kegiatan / agenda publik sekolah
     */
    public function up(): void
    {
        // ── Slider Beranda ─────────────────────────────────────────────
        Schema::create('slider_beranda', function (Blueprint $table) {
            $table->id();

            $table->string('judul')->nullable();
            $table->text('subjudul')->nullable();
            $table->string('foto_path')->nullable();
            $table->string('foto_url')->nullable();
            $table->string('foto_alt')->nullable();
            $table->string('tombol_label')->nullable();             // teks tombol CTA
            $table->string('tombol_url')->nullable();               // link tujuan tombol
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('urutan')->default(0);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_sekolah');
        Schema::dropIfExists('link_cepat');
        Schema::dropIfExists('slider_beranda');
    }
};