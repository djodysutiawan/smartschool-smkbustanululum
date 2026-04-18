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
        Schema::create('sesi_qr', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->nullable()->constrained('mata_pelajaran')->nullOnDelete();
            $table->foreignId('dibuat_oleh')->constrained('users')->cascadeOnDelete();
            $table->string('kode_qr')->unique();
            $table->date('tanggal');
            $table->timestamp('berlaku_mulai');
            $table->timestamp('kadaluarsa_pada');
            $table->integer('radius_meter')->nullable(); // batasan jarak GPS
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_qr');
    }
};
