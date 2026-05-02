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
        // ── Fasilitas Jurusan ──────────────────────────────────────────
        Schema::create('jurusan_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')->constrained('jurusan')->cascadeOnDelete();

            $table->string('nama_fasilitas');                       // Lab Komputer
            $table->text('deskripsi')->nullable();
            $table->string('foto_path')->nullable();
            $table->string('foto_url')->nullable();
            $table->unsignedSmallInteger('jumlah')->nullable();
            $table->unsignedSmallInteger('urutan')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan_fasilitas');
    }
};
