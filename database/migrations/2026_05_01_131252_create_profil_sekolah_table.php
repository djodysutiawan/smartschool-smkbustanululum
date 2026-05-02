<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel: profil_sekolah
     * Menyimpan seluruh identitas dan informasi umum sekolah.
     * Dirancang sebagai single-row (hanya 1 data aktif, id = 1).
     */
    public function up(): void
    {
        Schema::create('profil_sekolah', function (Blueprint $table) {
            $table->id();

            // ── Identitas Sekolah ──────────────────────────────────────
            $table->string('nama_sekolah');
            $table->string('singkatan')->nullable();                // SMK BU
            $table->string('npsn', 20)->nullable();                 // Nomor Pokok Sekolah Nasional
            $table->string('nss', 30)->nullable();                  // Nomor Statistik Sekolah
            $table->string('akreditasi', 5)->nullable();            // A / B / C
            $table->year('tahun_berdiri')->nullable();
            $table->string('status_sekolah')->default('Swasta');    // Negeri / Swasta
            $table->string('jenjang')->default('SMK');

            // ── Logo & Gambar ──────────────────────────────────────────
            $table->string('logo_path')->nullable();                // path file upload
            $table->string('logo_url')->nullable();                 // atau URL eksternal
            $table->string('favicon_path')->nullable();
            $table->string('cover_path')->nullable();               // foto sampul/banner utama
            $table->string('cover_url')->nullable();

            // ── Alamat ────────────────────────────────────────────────
            $table->text('alamat_lengkap')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('embed_maps_url')->nullable();           // embed Google Maps iframe src

            // ── Kontak ────────────────────────────────────────────────
            $table->string('telepon')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('fax')->nullable();
            $table->string('email_sekolah')->nullable();
            $table->string('website')->nullable();

            // ── Media Sosial ──────────────────────────────────────────
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('telegram_url')->nullable();

            // ── Kepala Sekolah ────────────────────────────────────────
            $table->string('nama_kepsek')->nullable();
            $table->string('nip_kepsek')->nullable();
            $table->string('foto_kepsek_path')->nullable();
            $table->string('foto_kepsek_url')->nullable();
            $table->text('sambutan_kepsek')->nullable();            // teks panjang sambutan

            // ── Teks Umum ─────────────────────────────────────────────
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();                       // bisa JSON array atau teks
            $table->text('tujuan_sekolah')->nullable();
            $table->text('sejarah_singkat')->nullable();
            $table->text('deskripsi_singkat')->nullable();          // untuk meta/SEO

            // ── SEO / Meta ────────────────────────────────────────────
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_sekolah');
    }
};