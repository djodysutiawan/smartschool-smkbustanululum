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
        // ── Link Cepat ─────────────────────────────────────────────────
        Schema::create('link_cepat', function (Blueprint $table) {
            $table->id();

            $table->string('label');                                // Pendaftaran / PPDB
            $table->string('url');
            $table->string('ikon')->nullable();                     // nama ikon
            $table->string('warna')->nullable();                    // hex / Tailwind
            $table->boolean('buka_tab_baru')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('urutan')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_cepat');
    }
};
