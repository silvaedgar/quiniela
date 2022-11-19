<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PredictionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($j = 0; $j < 20; $j++) {
            $predictions = [];
            for ($i = 1; $i < 49; $i++) {
                $predictions[] = ['matchup_id' => $i, 'goals_team_a' => mt_rand(0, 4), 'goals_team_b' => mt_rand(0, 4)];
            }
            $prediction = \App\Models\Prediction::factory()->create();
            $prediction->predictionDetails()->createMany($predictions);
        }
    }
}
