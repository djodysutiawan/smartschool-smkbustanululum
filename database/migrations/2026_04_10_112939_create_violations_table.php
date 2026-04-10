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
        Schema::create('violations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained();
            $table->foreignId('teacher_id')->constrained();

            $table->enum('kategori', ['ringan','sedang','berat']);
            $table->integer('poin');

            $table->text('deskripsi');
            $table->date('tanggal');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
