<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\PredictionsTrait;
use App\Traits\MatchupsTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Matchup;
use App\Models\Config;

class MatchupController extends Controller
{
    use PredictionsTrait, MatchupsTrait;

    public function __construct() {
        // registrado en kernel de http controller
        $this->middleware('user.active');
        $this->middleware('role.admin')->except('resultsLive','positions');
    }

    public function resultsLive() {
        $response = $this->getResultsLive();
        $response['header'] = 'Partidos del Dia: '.date('d-m-Y',strtotime($response['date_current']));
        return view('matchups.index', compact('response'));
    }

    // results de
    public function results() {

        $date = $this->getDate()->first();
        if (!$date)
            return "Error no hay dias activo";
        $matchups = $this->getMatchups('game_date',$date->date_current)->get();
        $response = ['header' => 'Partidos del Dia: '.date('d-m-Y',strtotime($date->date_current)), 'is_prediction' => false, 'matchups' => $matchups,
            'date_current' => $date->date_current, 'method' =>'results'];
            // fields matchup usado para saber que mostrar en el sahred table matchup y si muestra o tiene input
        return view('matchups.games', compact('response'));
    }

    public function closeDate() {
        $date = $this->closeDay();
        return redirect('/home')->with(['message' => 'Cambiada Fecha de Juegos a: '.date('d-m-Y',strtotime($date))]);
    }
}
