<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\PredictionsTrait;
use App\Traits\MatchupsTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Matchup;
use App\Models\Config;

class MatchupApiController extends Controller
{
    use MatchupsTrait, PredictionsTrait;

    public function processGoal(Request $request) {

        $points = $this->updatePoints($request);
        return Matchup::where('id',$request->id)->update([
            'goals_team_a' => $request->goals_team_a,
            'goals_team_b' => $request->goals_team_b,
            'status' => $request->status
            ]);

    }

    public function positions() {
        return $this->getResultsLive();
    }    //
}
