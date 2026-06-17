<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuPesertaUjian extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function jadwalUjian()
    {
        return $this->belongsTo(JadwalUjian::class);
    }
}
