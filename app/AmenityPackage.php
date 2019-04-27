<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmenityPackage extends Model
{
    protected $guarded = [];

    protected $hidden = ['pivot'];

    /**
     * Attributes relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    /**
     * Get AmenityPackages by Attribute ids
     *
     * @param $ids
     * @return AmenityPackage[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getByAttributeIds($ids)
    {
        return self::with('attributes')
                    ->whereHas('attributes', function ($query) use ($ids) {
                        $query->whereIn('attribute_id', $ids);
                    }, count($ids))->get();
    }
}
