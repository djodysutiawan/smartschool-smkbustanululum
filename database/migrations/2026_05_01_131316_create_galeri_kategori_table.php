<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel: galeri_kategori
     * Kelompok / album untuk foto dan video gallery.
     */
    public function up(): void
    {
        Schema::create('galeri_kategori', function (Blueprint $table) {
            $table->id();

            $table->string('nama');                                 // nama album/kategori
            $table->string('slug')->unique();                       // untuk URL
            $table->text('deskripsi')->nullable();
            $table->string('thumbnail_path')->nullable();           // foto sampul album
            $table->string('thumbnail_url')->nullable();
            $table->enum('tipe', ['foto', 'video', 'semua'])->default('semua'); // filter tipe konten
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('urutan')->default(0);     // sort order drag & drop

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri_kategori');
    }
};