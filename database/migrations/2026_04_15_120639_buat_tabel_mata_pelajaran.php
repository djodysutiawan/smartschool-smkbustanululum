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
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mapel');
            $table->string('kode_mapel', 15)->unique();
            $table->enum('kelompok', ['normatif', 'adaptif', 'produktif', 'muatan_lokal', 'pengembangan_diri'])
                ->default('normatif');
            $table->integer('jam_per_minggu')->default(2);  // untuk penjadwalan otomatis
            $table->integer('durasi_per_sesi')->default(45); // menit per jam pelajaran
            $table->boolean('perlu_lab')->default(false);    // apakah butuh ruang lab khusus
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pelajaran');
    }
};
