<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel: galeri_foto
     * Koleksi foto sekolah, dikelompokkan per kategori/album.
     * Mendukung upload lokal & URL eksternal.
     */
    public function up(): void
    {
        Schema::create('galeri_foto', function (Blueprint $table) {
            $table->id();

            $table->foreignId('galeri_kategori_id')->nullable()->constrained('galeri_kategori')->nullOnDelete();

            $table->string('judul');                                // title foto
            $table->text('keterangan')->nullable();                 // caption / deskripsi
            $table->string('foto_path')->nullable();                // path upload lokal (storage)
            $table->string('foto_url')->nullable();                 // URL eksternal
            $table->string('foto_thumbnail_path')->nullable();      // thumbnail hasil crop/resize
            $table->string('alt_text')->nullable();                 // accessibility & SEO
            $table->string('sumber')->nullable();                   // kredit fotografer/sumber
            $table->date('tanggal_foto')->nullable();               // kapan foto diambil
            $table->boolean('is_published')->default(true);
            $table->boolean('is_featured')->default(false);         // ditampilkan di slider/highlight
            $table->unsignedSmallInteger('urutan')->default(0);     // sort order drag & drop

            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri_foto');
    }
};