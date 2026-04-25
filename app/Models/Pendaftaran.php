<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jalur()
    {
        return $this->belongsTo(Jalur::class);
    }

    public function biodata()
    {
        return $this->hasOne(Biodata::class);
    }

    public function berkas()
    {
        return $this->hasOne(Berkas::class);
    }

    public function pengumumans()
    {
        return $this->hasMany(Pengumuman::class);
    }
}
