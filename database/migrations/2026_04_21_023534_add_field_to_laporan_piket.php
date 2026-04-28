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
        Schema::table('laporan_harian_piket', function (Blueprint $table) {
            $table->text('kondisi_sekolah')->nullable();
            $table->text('tamu_penting')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_piket', function (Blueprint $table) {
            //
        });
    }
};
