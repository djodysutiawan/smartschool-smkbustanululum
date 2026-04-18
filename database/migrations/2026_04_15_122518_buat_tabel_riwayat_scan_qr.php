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
        Schema::create('riwayat_scan_qr', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_qr_id')->constrained('sesi_qr')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->timestamp('dipindai_pada');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('hasil', ['berhasil', 'gagal_kadaluarsa', 'gagal_lokasi', 'gagal_duplikat']);
            $table->string('ip_address', 45)->nullable();
            $table->text('info_perangkat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_scan_qr');
    }
};
