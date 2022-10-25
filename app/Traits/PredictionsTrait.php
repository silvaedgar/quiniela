<?php

namespace App\Traits;

use App\Models\Matchup;
use App\Models\Prediction;
use App\Models\User;


trait PredictionsTrait {

    public function getPositions() {
       return User::select('users.id','name')->selectRaw('sum(points) as points')->join('predictions','users.id','predictions.player_id')
            ->join('prediction_details','predictions.id','prediction_details.prediction_id')
            ->where('users.status','Activo')->where('predictions.status','Activo')
            ->groupBy('users.id','users.name')->orderBy('points','desc');
    }

    public function getUnique($array,$field) {
        $array = $array->unique($field);
        return $array->values()->all();
    }

    public function predictionMatchups() {

        return Prediction::with('players','predictionDetails','predictionDetails.matchup',
                'predictionDetails.matchup.stadium','predictionDetails.matchup.teamA',
                'predictionDetails.matchup.teamB');
    }

    public function predictionPlayers($id) {
// ojo cuando imprimo planilla quite el where que este activo en la busqueda por jugador
// porque puede registar pronostico sin estar activo
        if ($id == 0) // busca las predicciones de todos los jugadores
            return Prediction::with('players','predictionDetails','predictionDetails.matchup',
                    'predictionDetails.matchup.stadium','predictionDetails.matchup.teamA',
                    'predictionDetails.matchup.teamB')->where('status','Activo');


        return Prediction::with('predictionDetails','predictionDetails.matchup',
                'predictionDetails.matchup.stadium','predictionDetails.matchup.teamA',
                'predictionDetails.matchup.teamB')->where('player_id', $id);
    }

    public function createPredictions($player_id,$predictions,$uuid) {
        $prediction = Prediction::create(['player_id' => $player_id, 'uuid' => $uuid,
                'status' => auth()->user()->status]);
        return $prediction->predictionDetails()->createMany($predictions);
    }

    public function predictionsInactive($player_id) {
        return Prediction::where('player_id',$player_id)->update(['status'=>'Inactivo']);
    }

    public function loadMatchups() {

        $predictions = $this->getMatchups()->get();
        $predictions = $this->sortMatchups($predictions,['game_date','matchup_id']);
        return $predictions;
    }

    public function loadPredictions() {
        $player_id = auth()->user()->id;
        $response['is_prediction'] = false;
        $response['error'] = false; // usado para depurar nada mas
        $predictions = $this->predictionPlayers($player_id)->get();
        if (count ($predictions) == 0)  { // no esta creado el jugador
            $prediction = $this->loadMatchups();
        }
        else {
            $predictions = $this->sortMatchups($predictions,'id',true);
            if (count($predictions[0]->predictionDetails) <> 48)  { // creado el jugador sin prediction
                $prediction = $this->loadMatchups();
            }
            else {  // existe prediccion para el jugador
                $prediction =  $predictions[0]->predictionDetails;
                // $predictions = $this->sortMatchups($predictions,[['matchup.game_date'],['matchup_id','desc']]);
                $response['is_prediction'] = true;
                $response['uuid'] = $predictions[0]->uuid;
            }
        }

        $response['player_id'] = $player_id;
        $response['predictions'] = $prediction;

        return $response;
    }
}
