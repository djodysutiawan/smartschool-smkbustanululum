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
        Schema::create('ketersediaan_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru')->cascadeOnDelete();
            $table->enum('hari', ['senin','selasa','rabu','kamis','jumat','sabtu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->boolean('tersedia')->default(true);
            $table->timestamps();
 
            $table->unique(['guru_id', 'hari', 'jam_mulai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ketersediaan_guru');
    }
};
