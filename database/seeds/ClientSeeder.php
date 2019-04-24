<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     */


    public function run()
    {
        $faker = Faker\Factory::create();

        foreach (range(1, 20) as $index) {
            Client::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->unique()->e164PhoneNumber,
            ]);
        }
    }
}
