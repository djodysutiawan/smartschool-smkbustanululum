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
        Schema::create('gedung', function (Blueprint $table) {
            $table->id();
            $table->string('kode_gedung', 10)->unique(); // contoh: GD-A
            $table->string('nama_gedung');
            $table->integer('jumlah_lantai')->default(1);
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gedung');
    }
};
