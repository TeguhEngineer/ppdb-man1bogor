<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiodataDataWali extends Model
{
    protected $guarded = ['id'];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
