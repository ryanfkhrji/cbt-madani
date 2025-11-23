<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTrNilai extends Model
{
    protected $fillable = [
        'id_trans',
        'id_soal',
        'pilihan',
        'jawaban_benar',
    ];
}
