<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\PredictionsTrait;
use App\Traits\MatchupsTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Matchup;
use App\Models\Config;
use App\Models\PlayerGoal;
use App\Models\User;
use App\Models\Prediction;

class MatchupApiController extends Controller
{
    use MatchupsTrait, PredictionsTrait;

    public function processGoal(Request $request) {

        if ($request->team_id != 0 && $request->name_player != '') {
            PlayerGoal::create($request->all());
        }
        $points = $this->updatePoints($request);
        return Matchup::where('id',$request->matchup_id)->update([
            'goals_team_a' => $request->goals_team_a,
            'goals_team_b' => $request->goals_team_b,
            'status' => $request->status
            ]);

    }

    public function positions() {
        return $this->getResultsLive();
    }    //


    // los metodos siguiente se usaron solo de pruebas para aprender spring boot

    public function predicciones() {

        return Prediction::with('players','predictionDetails')->get();
    }
}
