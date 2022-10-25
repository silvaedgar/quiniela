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
        $pending_games = Matchup::with('stadium','teamA','teamB','goals')->where('status','<>','Finalizado')
                ->where('game_date',$date->date_current)->get();
        if (count($pending_games) > 0)
                    return "No se cerro el dia. Aun hay juegos Pendientes";

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
        if ($field != '') {
            return Matchup::with('stadium','teamA','teamB','goals')->where($field,$filter);
        }
        return Matchup::with('stadium','teamA','teamB','goals');
    }

    public function sortMatchups($predictions,$order,$desc = false) {
        // return $predictions->sortBy('teamA.group');
        $predictions = ($desc ? $predictions->sortByDesc($order) : $predictions->sortBy($order));

        return $predictions->values()->all();
    }

    // public function filterMatchups($predictions,$field,$filter) {

    //     $predictions = $predictions->where($field,$filter);
    //     return $predictions->values()->all();
    // }

    public function updatePoints(Request $request) {
        //OJO OBTENER VALORES DE PUNTOS EN EL CONFIG

        $config_points = $this->getDate()->first(); //obtiene la configuracion
        $predictions = PredictionDetail::where('matchup_id',$request->matchup_id)->get();
        $data = $request;
        foreach ($predictions as $key => $prediction) {
            $points = 0;
            if ($request->goals_team_a == $prediction->goals_team_a)
                $points += $config_points->point_team_goals;
            if ($request->goals_team_b == $prediction->goals_team_b)
                $points += $config_points->point_team_goals;
            if (($request->goals_team_a > $request->goals_team_b &&  $prediction->goals_team_a > $prediction->goals_team_b) ||
                ($request->goals_team_a < $request->goals_team_b &&  $prediction->goals_team_a < $prediction->goals_team_b) ||
                ($request->goals_team_a == $request->goals_team_b &&  $prediction->goals_team_a == $prediction->goals_team_b))
                $points += $config_points->point_matchup_result;
            $prediction->points = $points;
            $prediction->save();
        }
        return $predictions;
    }

}
