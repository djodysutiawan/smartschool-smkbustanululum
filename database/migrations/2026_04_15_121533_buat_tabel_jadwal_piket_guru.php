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
        Schema::create('jadwal_piket_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->cascadeOnDelete();
            $table->enum('hari', ['senin','selasa','rabu','kamis','jumat','sabtu']);
            $table->time('jam_mulai')->default('07:00:00');
            $table->time('jam_selesai')->default('14:00:00');
            $table->text('catatan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['guru_id', 'hari', 'tahun_ajaran_id'], 'uq_piket_guru_hari');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_piket_guru');
    }
};
