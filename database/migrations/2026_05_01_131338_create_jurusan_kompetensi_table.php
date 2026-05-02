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
        // ── Kompetensi ─────────────────────────────────────────────────
        Schema::create('jurusan_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')->constrained('jurusan')->cascadeOnDelete();

            $table->string('nama_kompetensi');                      // Desain UI/UX
            $table->text('deskripsi')->nullable();
            $table->string('ikon')->nullable();                     // nama icon (Heroicons/FontAwesome)
            $table->string('badge_warna')->nullable();              // warna Tailwind / hex
            $table->unsignedSmallInteger('urutan')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan_kompetensi');
    }
};
