<?php

use App\Hotel;
use App\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    private $rooms = [
        [
            'hotel_id' => 0,
            'floor' => 1,
            'number' => 111,
            'amenity_package_id' => 1
        ],
        [
            'hotel_id' => 0,
            'floor' => 1,
            'number' => 112,
            'amenity_package_id' => 1
        ],
        [
            'hotel_id' => 0,
            'floor' => 2,
            'number' => 211,
            'amenity_package_id' => 2
        ],
        [
            'hotel_id' => 0,
            'floor' => 2,
            'number' => 212,
            'amenity_package_id' => 2
        ],
        [
            'hotel_id' => 0,
            'floor' => 3,
            'number' => 311,
            'amenity_package_id' => 3
        ],
        [
            'hotel_id' => 0,
            'floor' => 4,
            'number' => 411,
            'amenity_package_id' => 4
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotelIds = Hotel::all()->pluck('id');

        foreach ($hotelIds as $id) {
            foreach ($this->rooms as $room) {
                $room['hotel_id'] = $id;
                Room::insert($room);
            }
        }
    }
}
