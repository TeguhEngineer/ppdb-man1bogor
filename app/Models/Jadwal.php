<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $guarded = ['id'];

    public function jalur()
    {
        return $this->belongsTo(Jalur::class);
    }
}
