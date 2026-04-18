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
        Schema::create('sesi_ujian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_id')->constrained('ujian')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->timestamp('mulai_pada')->nullable();
            $table->timestamp('selesai_pada')->nullable();
            $table->timestamp('batas_waktu_pada')->nullable(); // mulai + durasi_menit
            $table->enum('status', ['belum_mulai', 'berlangsung', 'selesai', 'habis_waktu'])
                  ->default('belum_mulai');
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->unsignedSmallInteger('total_benar')->default(0);
            $table->unsignedSmallInteger('total_salah')->default(0);
            $table->unsignedSmallInteger('total_kosong')->default(0);
            $table->boolean('lulus')->default(false);
            $table->timestamps();
 
            $table->unique(['ujian_id', 'siswa_id']); // satu siswa satu sesi per ujian
            $table->index(['ujian_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_ujian');
    }
};
