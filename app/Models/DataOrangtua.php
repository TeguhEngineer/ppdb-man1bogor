<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataOrangtua extends Model
{
    protected $table = 'data_orangtua';

    protected $guarded = ['id'];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
