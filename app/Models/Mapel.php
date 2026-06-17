<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $guarded = ['id'];

    public function jalurs()
    {
        return $this->belongsToMany(Jalur::class, 'jalur_mapel')
            ->withPivot('urutan')
            ->withTimestamps()
            ->orderByPivot('urutan');
    }
}
