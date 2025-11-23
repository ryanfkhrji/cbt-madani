<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransSoal extends Model
{
    protected $fillable = [
        'id_user',
        'id_kelas',
        'id_ujian',
        'jum_soal',
        'benar',
        'salah',
        'score'
        
    ];
    public function User():BelongsTo {
        return $this->belongsTo(Ujian::class,'id_user','id');
    }
    public function Ujian():BelongsTo{
        return $this->belongsTo(Ujian::class,'id_ujian','id');
    }
    public function kelas():BelongsTo {
        return $this->belongsTo(Kelas::class,'id_kelas','id');
    }
}
