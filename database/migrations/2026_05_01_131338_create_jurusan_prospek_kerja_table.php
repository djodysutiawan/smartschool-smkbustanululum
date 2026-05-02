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
        // ── Prospek Kerja ──────────────────────────────────────────────
        Schema::create('jurusan_prospek_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')->constrained('jurusan')->cascadeOnDelete();

            $table->string('jabatan');                              // Web Developer
            $table->string('bidang_industri')->nullable();          // IT & Digital
            $table->text('deskripsi')->nullable();
            $table->string('ikon')->nullable();
            $table->unsignedSmallInteger('urutan')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan_prospek_kerja');
    }
};
