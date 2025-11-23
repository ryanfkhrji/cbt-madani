<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DraftSoal extends Model
{
    protected $fillable = [
        'id_ujian',
        'id_kelas',
        'id_siswa'
    ];

    public function ujian(): BelongsTo
    {
        return $this->belongsTo(Ujian::class, 'id_ujian', 'id');
    }
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }
}
