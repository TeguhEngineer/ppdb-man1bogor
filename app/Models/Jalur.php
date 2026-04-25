<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jalur extends Model
{
    protected $guarded = ['id'];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function jadwal()
    {
        return $this->hasOne(Jadwal::class);
    }
}
