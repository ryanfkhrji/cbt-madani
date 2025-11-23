<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ujian extends Model
{
    protected $fillable = [
        'id_mapel',
        'nama_ujian',
        'jumlah_soal',
        'soal_acak',
        'jawaban_acak',
        'deskripsi'
    ];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id');
    }
    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'id_ujian', 'id');
    }
    // Ujian.php
    public function draftSoals() {
        return $this->hasMany(DraftSoal::class, 'id_ujian','id');
    }

}
