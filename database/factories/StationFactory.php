<?php

namespace Database\Factories;

use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

class StationFactory extends Factory
{
    protected $model = Station::class;

    public function definition()
    {
        return [
            "name" => $this->faker->randomElement(["cairo", "giza", "el-fayyum", "el-minya", "asyut"]),
        ];
    }
}
