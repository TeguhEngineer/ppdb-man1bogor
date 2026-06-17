<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalUjian extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_ujian' => 'date',
        'tanggal_wawancara_btq' => 'date',
    ];

    public function jalur()
    {
        return $this->belongsTo(Jalur::class);
    }

    public function kartuPesertaUjians()
    {
        return $this->hasMany(KartuPesertaUjian::class);
    }
}
