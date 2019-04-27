<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    protected $hidden = ['pivot'];

    /**
     * AmenityPackage relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function amenityPackage()
    {
        return $this->belongsTo(AmenityPackage::class);
    }

    /**
     * Hotel relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Reservations relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }
}
