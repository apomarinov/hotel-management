<?php

use App\Attribute;
use App\Item;
use App\ReservationStatus;
use Illuminate\Database\Migrations\Migration;

class PopulateBaseData extends Migration
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
            [
                'type' => 'misc',
                'value' => 'Bathtub'
            ],
            [
                'type' => 'tech',
                'value' => 'TV'
            ],
            [
                'type' => 'tech',
                'value' => 'PS 4'
            ],
            [
                'type' => 'tech',
                'value' => 'Air Conditioner'
            ],
            [
                'type' => 'furniture',
                'value' => 'Wardrobe'
            ],
            [
                'type' => 'tech',
                'value' => 'Fridge'
            ],
            [
                'type' => 'furniture',
                'value' => 'Single Bed'
            ],
            [
                'type' => 'furniture',
                'value' => 'King Size Bed'
            ],
            [
                'type' => 'furniture',
                'value' => 'Sofa'
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
