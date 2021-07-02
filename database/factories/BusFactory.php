<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusFactory extends Factory
{

    protected $model = Bus::class;

    public function definition()
    {
        return [
            "driver_id" => Driver::factory()->create()->id,
            "number" => $this->faker->randomNumber(6),
            "capacity" => 12
        ];
    }
}
