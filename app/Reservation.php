<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = [];

    protected $hidden = ['pivot'];

    protected $dates = [
        'date_from',
        'date_to'
    ];

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function status()
    {
        return $this->belongsTo(ReservationStatus::class, 'reservation_status_id');
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }
}
