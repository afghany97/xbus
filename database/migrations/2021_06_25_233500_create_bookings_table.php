<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("trip_id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("start_destination_station_id");
            $table->unsignedBigInteger("final_destination_station_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->string("ticket");
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
        Schema::dropIfExists('bookings');
    }
}
