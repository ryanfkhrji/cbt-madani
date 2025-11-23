<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    protected $fillable = [
        'id_ujian',
        'nama_jadwal',
        'hari',
        'tanggal',
        'jam_in',
        'jam_out',
    ];

    public function ujian(): BelongsTo
    {
        return $this->belongsTo(Ujian::class, 'id_ujian', 'id');
    }
}
