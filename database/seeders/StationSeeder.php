<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach (["cairo", "giza", "el-fayyum", "el-minya", "asyut"] as $station) {
            Station::factory()->create(["name" => $station]);
        }
    }
}

