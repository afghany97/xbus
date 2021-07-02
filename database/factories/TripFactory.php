<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition()
    {
        return [
            "bus_id" => Bus::factory()->create()->id,
            "number" => $this->faker->randomNumber(6),
            "description" => $this->faker->sentence
        ];
    }
}

