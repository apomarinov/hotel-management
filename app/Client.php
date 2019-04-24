<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    protected $hidden = ['pivot'];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }
}
