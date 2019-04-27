<?php

use App\AmenityPackage;
use App\Hotel;
use App\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotelIds = Hotel::all()->pluck('id');
        $maxPackageId = AmenityPackage::max('id');

        $data = [
            'hotel_id' => 0,
            'floor' => 1,
            'number' => '',
            'amenity_package_id' => 1
        ];

        // create rooms for each hotel
        $floors = 4;
        $roomsOnFloor = 5;

        foreach ($hotelIds as $id) {
            $room = $data;
            $room['hotel_id'] = $id;
            $room['number'] = $id;

            foreach (range(1, $floors) as $floor) {
                $room['number'] += $floor;
                $room['floor'] = $floor;

                foreach (range(1, $roomsOnFloor) as $number) {
                    $room['amenity_package_id'] = rand(1, $maxPackageId);
                    $room['number'] += $number;
                    Room::insert($room);
                }
            }
        }
    }
}
