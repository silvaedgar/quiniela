<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config')->insert([
            'point_team_goals' => 1,
            'point_matchup_result' => 3,
            'date_current' => "2022-11-21",
            'status' => 'Activo'
        ]);

        //
    }
}
