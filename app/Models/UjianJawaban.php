<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UjianJawaban extends Model
{
    protected $fillable = [
        'id_user',
        'id_ujian',
        'id_soal',
        'jawaban',
        'jawaban_benar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal');
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'id_ujian');
    }
}
