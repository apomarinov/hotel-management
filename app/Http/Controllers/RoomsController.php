<?php

namespace App\Http\Controllers;

use App\Room;

class RoomsController extends Controller
{
    public function index()
    {
        return view('rooms.index');
    }

    public function availableRooms()
    {
        $rooms = Room::with('amenityPackage')->has('reservations', '<', 1);

        if(request()->has('hotelId')) {
            $rooms->where('hotel_id', request()->get('hotelId'));
        }

        return $rooms->get()->makeHidden('amenity_package_id');
    }
}
