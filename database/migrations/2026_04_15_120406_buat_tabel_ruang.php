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
        Schema::create('ruang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gedung_id')->constrained('gedung')->cascadeOnDelete();
            $table->string('kode_ruang', 15)->unique(); // contoh: R-101, LAB-01
            $table->string('nama_ruang');
            $table->integer('lantai');
            $table->enum('jenis_ruang', [
                'kelas',
                'laboratorium_komputer',
                'laboratorium_ipa',
                'laboratorium_bahasa',
                'aula',
                'perpustakaan',
                'ruang_praktik',
                'lainnya'
            ])->default('kelas');
            $table->integer('kapasitas')->default(30); // jumlah kursi
            $table->boolean('ada_proyektor')->default(false);
            $table->boolean('ada_ac')->default(false);
            $table->boolean('ada_wifi')->default(false);
            $table->boolean('ada_komputer')->default(false);
            $table->text('fasilitas_lain')->nullable();
            $table->enum('status', ['tersedia', 'tidak_tersedia', 'perbaikan'])->default('tersedia');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruang');
    }
};
