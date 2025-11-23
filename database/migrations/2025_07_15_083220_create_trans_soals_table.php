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
        Schema::create('trans_soals', function (Blueprint $table) {
            $table->id();
            $table->integer('id_ujian');
            $table->integer('id_siswa');
            $table->integer('id_kelas');
            $table->string('jum_soal');
            $table->string('benar');
            $table->string('salah');
            $table->string('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_soals');
    }
};
