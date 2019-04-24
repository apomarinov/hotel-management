<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmenityPackageItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amenity_package_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('amenity_package_id');
            $table->unsignedInteger('item_id');
            $table->smallInteger('quantity');
            $table->unique(['item_id', 'amenity_package_id']);

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('amenity_package_id')->references('id')->on('amenity_packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amenity_package_item');
    }
}
