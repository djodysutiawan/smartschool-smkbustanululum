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
        Schema::create('jawaban_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_ujian_id')->constrained('sesi_ujian')->cascadeOnDelete();
            $table->foreignId('soal_ujian_id')->constrained('soal_ujian')->cascadeOnDelete();
            // Untuk PG/benar-salah → pilihan_jawaban_id
            $table->foreignId('pilihan_jawaban_id')->nullable()
                  ->constrained('pilihan_jawaban')->nullOnDelete();
            // Untuk essay → teks jawaban bebas
            $table->text('jawaban_essay')->nullable();
            $table->boolean('adalah_benar')->nullable(); // null = belum dinilai (essay)
            $table->decimal('poin_didapat', 5, 2)->default(0);
            $table->text('catatan_koreksi')->nullable(); // untuk essay manual
            $table->timestamps();
 
            $table->unique(['sesi_ujian_id', 'soal_ujian_id']);
            $table->index('sesi_ujian_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswa');
    }
};
