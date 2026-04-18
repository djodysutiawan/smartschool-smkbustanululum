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
        Schema::create('log_piket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')
                ->constrained('users')
                ->cascadeOnDelete(); // akun piket bersama
            $table->foreignId('guru_id')
                ->constrained('guru')
                ->cascadeOnDelete(); // guru asli yang bertugas
            $table->date('tanggal');
            $table->enum('shift', ['pagi', 'siang', 'sore'])->default('pagi');
            $table->timestamp('masuk_pada')->nullable();
            $table->timestamp('keluar_pada')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_piket');
    }
};
