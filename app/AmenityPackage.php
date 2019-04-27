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

    public function getByAttributeIds($ids)
    {
        return self::with('attributes')
                    ->whereHas('attributes', function ($query) use ($ids) {
                        $query->whereIn('attribute_id', $ids);
                    }, count($ids))->get();
    }
}
