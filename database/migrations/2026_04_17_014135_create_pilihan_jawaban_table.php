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
        Schema::create('pilihan_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soal_ujian_id')->constrained('soal_ujian')->cascadeOnDelete();
            $table->char('kode_pilihan', 1);    // A, B, C, D, E
            $table->text('teks_pilihan');
            $table->string('gambar_pilihan')->nullable();
            $table->boolean('adalah_benar')->default(false);
            $table->timestamps();
 
            $table->index('soal_ujian_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilihan_jawaban');
    }
};
