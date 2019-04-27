<?php

use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            HotelSeeder::class,
            AmenityPackageSeeder::class,
            RoomSeeder::class,
// Uncomment these seeders if you want example clients and reservations
//            ClientSeeder::class,
//            ReservationSeeder::class
        ]);
    }
}
