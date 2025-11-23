<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoalPilihan extends Model
{
    protected $fillable = ['id_ujian', 'soal_ujian_id', 'teks_pilihan', 'is_benar'];
}
