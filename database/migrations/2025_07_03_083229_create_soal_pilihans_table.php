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
        Schema::create('soal_pilihans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('soal_ujian_id');
            $table->string('teks_pilihan');
            $table->boolean('is_benar')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_pilihans');
    }
};
