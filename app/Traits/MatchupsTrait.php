<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Matchup;
use App\Models\Prediction;
use App\Models\PredictionDetail;

use App\Traits\PredictionsTrait;

trait MatchupsTrait {

    use PredictionsTrait;

    public function closeDay() {

        $date =  $this->getDate()->first();
        $new_date = date("Y-m-d",strtotime($date->date_current."+ 1 days"));
        DB::table('config')->where('status','Activo')->update(['date_current' => $new_date]);
        return $new_date;
    }

    public function getDate() {

        return DB::table('config')->where('status','Activo');
    }

    public function getResultsLive() {


        $date = $this->getDate()->first();
        $matchups = $this->getMatchups('game_date',$date->date_current)->get();
        $positions = $this->getPositions()->get();
        return ['matchups' =>$matchups, 'positions' =>$positions, 'date_current' => $date->date_current,
            'is_prediction' => false, 'method' => 'inLive'];
    }


    public function getMatchups($field="",$filter="") {
        // $predictions = $predictions->sortBy('game_date');
        // return $predictions->sortBy('stadium_id');
        if ($field != '') {
            return Matchup::with('stadium','teamA','teamB')->where($field,$filter);
        }
        return Matchup::with('stadium','teamA','teamB');
    }

    public function sortMatchups($predictions,$order,$desc = false) {
        // return $predictions->sortBy('teamA.group');
        $predictions = ($desc ? $predictions->sortByDesc($order) : $predictions->sortBy($order));

        return $predictions->values()->all();
    }

    public function filterMatchups($predictions,$field,$filter) {
        // return $predictions->sortBy('teamA.group');

        $predictions = $predictions->where($field,$filter);
        return $predictions->values()->all();
    }

    public function updatePoints(Request $request) {

        //OJO OBTENER VALORES DE PUNTOS EN EL CONFIG

        $predictions = PredictionDetail::where('matchup_id',$request->id)->get();
        $data = $request;
        foreach ($predictions as $key => $prediction) {
            $points = 0;
            if ($request->goals_team_a == $prediction->goals_team_a)
                $points ++;
            if ($request->goals_team_b == $prediction->goals_team_b)
                $points ++;
            if (($request->goals_team_a > $request->goals_team_b &&  $prediction->goals_team_a > $prediction->goals_team_b) ||
                ($request->goals_team_a < $request->goals_team_b &&  $prediction->goals_team_a < $prediction->goals_team_b) ||
                ($request->goals_team_a == $request->goals_team_b &&  $prediction->goals_team_a == $prediction->goals_team_b))
                $points += 3;
            $prediction->points = $points;
            $prediction->save();
        }
        return $predictions;
    }

}
