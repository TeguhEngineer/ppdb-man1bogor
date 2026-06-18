<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPribadi extends Model
{
    protected $table = 'data_pribadi';

    protected $guarded = ['id'];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
