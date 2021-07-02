<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_destinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("trip_id");
            $table->foreign("trip_id")->references("id")->on("trips")->onDelete("cascade");
            $table->unsignedBigInteger("start_destination_station_id");
            $table->foreign("start_destination_station_id")->references("id")->on("stations");
            $table->unsignedBigInteger("final_destination_station_id");
            $table->foreign("final_destination_station_id")->references("id")->on("stations");
            $table->unsignedBigInteger("booked_seats_count");
            $table->integer("order");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_destinations');
    }
}
