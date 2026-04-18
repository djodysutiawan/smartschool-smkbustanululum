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
        Schema::create('soal_ujian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_id')->constrained('ujian')->cascadeOnDelete();
            $table->unsignedSmallInteger('nomor_soal');
            $table->enum('jenis_soal', ['pilihan_ganda', 'benar_salah', 'essay']);
            $table->text('pertanyaan');
            $table->string('gambar_soal')->nullable();
            $table->unsignedTinyInteger('bobot')->default(1);
            $table->json('metadata')->nullable();
            $table->timestamps();
 
            $table->unique(['ujian_id', 'nomor_soal']);
            $table->index('ujian_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_ujian');
    }
};
