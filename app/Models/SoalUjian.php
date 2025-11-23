<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoalUjian extends Model
{
    protected $fillable = ['id_ujian', 'id_kategori_soal', 'soal', 'tipe', 'gambar', 'required', 'poin'];

    public function pilihan()
    {
        return $this->hasMany(SoalPilihan::class);
    }

    public function pasangan()
    {
        return $this->hasMany(SoalMenjodohkan::class);
    }
}
