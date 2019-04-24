<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = [];

    protected $hidden = ['pivot'];

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }
}
