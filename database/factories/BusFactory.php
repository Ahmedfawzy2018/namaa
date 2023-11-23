<?php

namespace Database\Factories;

use App\Enums\BusTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(5, true),
            'capacity' => 20,
            'type' => BusTypeEnum::LONG_ROUTE,
        ];
    }
}
