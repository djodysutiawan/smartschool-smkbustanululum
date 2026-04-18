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
        Schema::create('kategori_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->text('deskripsi')->nullable();
            $table->enum('tingkat', ['ringan', 'sedang', 'berat'])->default('ringan');
            $table->unsignedSmallInteger('poin_default')->default(5);
            $table->unsignedSmallInteger('batas_poin')->nullable(); // poin max untuk kategori ini
            $table->string('warna', 30)->nullable();   // untuk tampilan UI (hex / nama)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_pelanggaran');
    }
};
