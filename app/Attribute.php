<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $hidden = ['pivot'];

    /**
     * AmenityPackages relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function amenityPackages()
    {
        return $this->belongsToMany(AmenityPackage::class);
    }
}
