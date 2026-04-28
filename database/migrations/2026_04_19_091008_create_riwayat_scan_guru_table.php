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
        Schema::create('riwayat_scan_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_qr_guru_id')
                  ->constrained('sesi_qr_guru')
                  ->cascadeOnDelete();
            $table->foreignId('guru_id')
                  ->constrained('guru')
                  ->cascadeOnDelete();
            $table->timestamp('dipindai_pada')->useCurrent();
            $table->enum('hasil', [
                'berhasil',
                'gagal_kadaluarsa',
                'gagal_lokasi',
                'gagal_duplikat',
            ]);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('info_perangkat')->nullable();
            $table->timestamps();
 
            $table->index(['guru_id', 'dipindai_pada']);
            $table->index('sesi_qr_guru_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_scan_guru');
    }
};
