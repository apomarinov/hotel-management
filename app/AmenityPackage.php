<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmenityPackage extends Model
{
    protected $guarded = [];

    protected $hidden = ['pivot'];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
