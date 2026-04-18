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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');               // contoh: X RPL 1
            $table->string('tingkat', 5);               // X, XI, XII
            $table->string('jurusan');
            $table->string('kode_kelas', 15)->unique(); // RPL-X-1
            $table->foreignId('wali_kelas_id')
                ->nullable()
                ->constrained('guru')
                ->nullOnDelete();
            $table->foreignId('ruang_id')
                ->nullable()
                ->constrained('ruang')
                ->nullOnDelete();
            $table->foreignId('tahun_ajaran_id')
                ->nullable()
                ->constrained('tahun_ajaran')
                ->nullOnDelete();
            $table->integer('kapasitas_maks')->default(36);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
