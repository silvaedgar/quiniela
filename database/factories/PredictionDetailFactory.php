<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PredictionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'matchup_id' => $this->faker->unique()->numberBetween(1, 48),
            'goals_team_a' => $this->faker->randomElement([0, 1, 2, 3, 4]),
            'goals_team_b' => $this->faker->randomElement([0, 1, 2, 3, 4]),
        ];
    }
}
