<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'pivot'
    ];

    protected $casts = [
        'phone' => 'integer',
    ];

    /**
     * Reservations relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }

    /**
     * Reservation Hotel relationship
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function hotel()
    {
        return $this->hasOneThrough(Reservation::class, Hotel::class);
    }
}
