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
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi');
            $table->string('path_lampiran')->nullable();
            $table->enum('target_role', [
                'semua',
                'guru',
                'siswa',
                'orang_tua',
                'guru_piket'
            ])->default('semua');
            $table->foreignId('dibuat_oleh')->constrained('users')->restrictOnDelete();
            $table->timestamp('dipublikasikan_pada')->nullable();
            $table->timestamp('kadaluarsa_pada')->nullable();
            $table->boolean('dipinned')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};
