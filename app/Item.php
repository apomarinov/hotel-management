<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $hidden = ['pivot'];

    public function amenityPackage()
    {
        return $this->belongsToMany(AmenityPackage::class);
    }
}
