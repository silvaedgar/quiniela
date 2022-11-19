<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PredictionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'player_id' => $this->faker->unique()->numberBetween(2, 21),
            'uuid' => $this->faker->uuid(),
            'status' => 'Inactivo',
            //
        ];
    }
}
