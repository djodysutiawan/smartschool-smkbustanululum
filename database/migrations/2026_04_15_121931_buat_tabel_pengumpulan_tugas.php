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
        Schema::create('pengumpulan_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_id')->constrained('tugas')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->string('path_file')->nullable();
            $table->text('jawaban_teks')->nullable();
            $table->string('url_link')->nullable();
            $table->decimal('nilai', 5, 2)->nullable();
            $table->text('umpan_balik')->nullable();       // feedback guru
            $table->enum('status', [
                'belum_dikumpulkan',
                'dikumpulkan',
                'terlambat',
                'dinilai'
            ])->default('belum_dikumpulkan');
            $table->timestamp('dikumpulkan_pada')->nullable();
            $table->timestamp('dinilai_pada')->nullable();
            $table->timestamps();
 
            $table->unique(['tugas_id', 'siswa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_tugas');
    }
};
