<?php

use App\AmenityPackage;
use App\Attribute;
use App\Item;
use Illuminate\Database\Seeder;

class AmenityPackageSeeder extends Seeder
{
    private $packages = [
        [
            'name' => 'Standard'
        ],
        [
            'name' => 'Delux'
        ],
        [
            'name' => 'Premium'
        ],
        [
            'name' => 'Suite'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $viewAttributeIds = Attribute::where('type', 'view')->get()->pluck('id');
        $miscAttributeIds = Attribute::where('type', 'misc')->get()->pluck('id');
        $techAttributeIds = Attribute::where('type', 'tech')->get()->pluck('id');
        $furnitureAttributeIds = Attribute::where('type', 'furniture')->get()->pluck('id');

        foreach ($this->packages as $p) {
            AmenityPackage::insert($p);
            $p = AmenityPackage::where('name', $p['name'])->first();

            $p->attributes()->attach($viewAttributeIds->random());
            $p->attributes()->attach($miscAttributeIds->random(3));
            $p->attributes()->attach($techAttributeIds->random(2));
            $p->attributes()->attach($furnitureAttributeIds->random(3)->toArray(), ['quantity' => 1]);
        }
    }
}
