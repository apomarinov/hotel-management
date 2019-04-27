<?php

use App\Client;
use App\Hotel;
use App\Reservation;
use App\ReservationStatus;
use App\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // manipulate sample data
        $freeRooms = 5;
        $maxPersonCount = 8;
        $maxRoomCount = 3;
        $clientSeedCount = 20;
        $minDayStay = 2;
        $maxDayStay = 15;

        $faker = Faker\Factory::create();
        
        $clientIds = Client::all()->pluck('id');
        $roomIds = Room::all()->shuffle()->slice($freeRooms)->pluck('id');

        $firstHotelId = Hotel::min('id');
        $lastHotelId = Hotel::max('id');
        $firstReservationStatusId = ReservationStatus::min('id');
        $lastReservationStatusId = ReservationStatus::max('id');

        foreach (range(1, $clientSeedCount) as $index) {
            $dayBuffer = rand(-20, 20);
            $stay = rand($minDayStay, $maxDayStay) + $dayBuffer;

            // create reservation
            $reservation = Reservation::create([
                'hotel_id' => rand($firstHotelId, $lastHotelId),
                'date_from' => date('Y-m-d H:i:s', strtotime("$dayBuffer days")),
                'date_to' => date('Y-m-d H:i:s', strtotime("$stay days")),
                'notes' => $faker->realText(300),
                'reservation_status_id' => rand($firstReservationStatusId, $lastReservationStatusId)
            ]);

            // add clients to reservation
            $peopleCount = rand(1, $maxPersonCount);
            $reservation->clients()->attach($clientIds->random($peopleCount));

            // add rooms to reservation
            $roomCount = rand(1, $maxRoomCount);
            $reservation->rooms()->attach($roomIds->random($roomCount));
        }
    }
}

