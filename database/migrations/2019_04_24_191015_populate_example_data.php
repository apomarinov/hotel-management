<?php

use App\Attribute;
use App\Item;
use App\ReservationStatus;
use App\Room;
use Illuminate\Database\Migrations\Migration;

class PopulateExampleData extends Migration
{
    private $data = [
        Attribute::class => [
            [
                'type' => 'view',
                'value' => 'Pool Side'
            ],
            [
                'type' => 'view',
                'value' => 'Rooftop'
            ],
            [
                'type' => 'view',
                'value' => 'Garden'
            ],
            [
                'type' => 'misc',
                'value' => 'Pet Friendly'
            ],
            [
                'type' => 'misc',
                'value' => 'WiFi'
            ],
            [
                'type' => 'misc',
                'value' => 'Romantic Lights'
            ],
        ],
        Item::class => [
            [
                'name' => 'Bathtub'
            ],
            [
                'name' => 'TV'
            ],
            [
                'name' => 'PS 4'
            ],
            [
                'name' => 'Air Conditioner'
            ],
            [
                'name' => 'Wardrobe'
            ],
            [
                'name' => 'Fridge'
            ],
            [
                'name' => 'Single Bed'
            ],
            [
                'name' => 'King Size Bed'
            ],
            [
                'name' => 'Sofa'
            ]
        ],
        ReservationStatus::class => [
            [
                'type' => 'Payed'
            ],
            [
                'type' => 'On Hold'
            ],
            [
                'type' => 'Cancelled'
            ],
            [
                'type' => 'Ended'
            ]
        ]
    ];


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->data as $class => $items) {
            foreach ($items as $fields) {
                $class::insert($fields);
            }
        }
    }
}
