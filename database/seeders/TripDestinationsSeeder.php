<?php

namespace Database\Seeders;

use App\Models\Station;
use App\Models\Trip;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TripDestinationsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $tripDestinations = [];
        $stations = Station::all()->toArray();
        $trips = Trip::pluck("id");
        foreach ($trips as $tripId) {
            $order = 1;
            foreach ($stations as $index => $station) {
                if ($index == count($stations) - 1) {
                    break;
                }
                $tripDestinations [] = [
                    "trip_id" => $tripId,
                    "start_destination_station_id" => $station["id"],
                    "final_destination_station_id" => $stations[$index + 1]["id"],
                    "booked_seats_count" => 0,
                    "order" => $order++
                ];
            }
        }
        DB::table("trip_destinations")->insert($tripDestinations);
    }
}
