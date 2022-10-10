<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Stadiums;
use App\Models\Matchup;


class MatchupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = "calendario.txt";
        $fp = fopen($file,"r");
        $line_number = 0;
        $game = [];
        while (!feof($fp)) {
            $line = trim(fgets($fp));

            switch ($line_number) {
                case 0:
                    $oldDate = strtotime($line);
                    $newDate = date('Y-m-d',$oldDate);
                    $game['game_date'] = $newDate;
                    break;
                 case 1:
                    $stadium =  Stadiums::where('name',$line)->first();
                        $game['stadium_id'] = $stadium->id;
                        break;
                case 2:
                    $team_a = Team::where('name',$line)->first();
                    $game['team_id_a'] = $team_a->id;
                    break;
                default:
                    $team_b = Team::where('name',$line)->first();
                    $game['team_id_b'] = $team_b->id;
                    Matchup::create($game);
            }
            $line_number++;
            if ($line_number > 3)
                $line_number = 0;
        }
        fclose($fp);
    }
}

