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
        Schema::create('siswa_orang_tua', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('orang_tua_id')->constrained('orang_tua')->cascadeOnDelete();
            $table->enum('hubungan', ['ayah', 'ibu', 'wali', 'orang_tua'])->default('orang_tua');
            $table->boolean('kontak_utama')->default(false);
            $table->timestamps();
            $table->unique(['siswa_id', 'orang_tua_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_orang_tua');
    }
};
