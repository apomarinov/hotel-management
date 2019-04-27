<?php

namespace App\Http\Controllers;

use App\AmenityPackage;
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

        if(request()->has('attributes')) {
            $packageIds = (new AmenityPackage())->getByAttributeIds(request()->get('attributes'))->pluck('id')->toArray();
        }
        $packageId = request()->get('package_id') ?? 0;
        if($packageId) {
            $packageIds = [AmenityPackage::select()->where('id', $packageId)->first()->id ?? 0];
        }

        $hotelId = request()->get('hotel_id') ?? 0;
        if($hotelId) {
            $rooms->where('hotel_id', $hotelId);
        }
        if(!empty($packageIds)) {
            $rooms->whereIn('amenity_package_id', array_filter($packageIds));
        }

        return $rooms->orderBy('floor')->get()->makeHidden('amenity_package_id');
    }
}
