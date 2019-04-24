<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $hidden = ['pivot'];

    public function amenityPackages()
    {
        return $this->belongsToMany(AmenityPackage::class);
    }
}
