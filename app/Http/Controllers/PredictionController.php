<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Matchup;
use App\Models\Player;
use App\Models\Prediction;
use App\Models\Uuid;

use App\Http\Requests\StorePredictionRequest;

use App\Traits\CreateDataTrait;
use App\Traits\PredictionsTrait;
use App\Traits\MatchupsTrait;
use App\Traits\LogsTrait;
use Carbon\Carbon;
use PDF;

class PredictionController extends Controller
{
    use CreateDataTrait, PredictionsTrait, MatchupsTrait, LogsTrait;


    public function index()
    {
        $response = $this->loadPredictions();
        $date  = $this->getDate()->first();
        $date_current = new Carbon($date->date_current);
        $date_init = new Carbon("2022-11-21");


        if (Matchup::where('status','Proceso')->orWhere('status','Finalizado')->first() || $date_current >= $date_init )
            $response['init'] = true;

        if (!$response['error']) {
            // $response['config'] = $this->getDate();
            $response['method'] = 'prediction';
            $response['header'] = 'Pronosticos de la Quiniela. Participante: '.auth()->user()->name;
            return view('predictions.index',compact('response'));
        }
        return $response; // para depurar y muestra el JSON en pantalla
    }

    public function create()
    {
        //
    }

    public function store(StorePredictionRequest $request)
    {
        $player_id = auth()->user()->id;
        $prediction = $this->predictionPlayers($player_id)->first();
        DB::beginTransaction();
        try {

        // DB::transaction(function () use ($request,$prediction) {
             $uuid = $this->createUuid();
            if ($prediction)  //si tiene predicciones
                $this->predictionsInactive($player_id); // inactiva las predicciones

            foreach ($request->matchup_id as $key => $value) {
                $predictions[] = array("matchup_id"=>$request->matchup_id[$key],
                    "goals_team_a"=>$request->goals_team_a[$key],"goals_team_b"=>$request->goals_team_b[$key]);
            }
            $prediction = $this->createPredictions($player_id,$predictions,$uuid);  // crea una nueva prediccion
            DB::commit();
        // });
        } catch (\Throwable $th) {
            DB::rollback();
            return  $th;
        }
        // genera el print de la jugada
        return $this->print($request->player_id);
    }

    public function print($player_id) {

        // $predictions = $this->predictionPlayers($player_id)->where('status','Activo')->get();
        // $predictions = $this->sortMatchups($predictions,[['game_date'],['matchup_id','desc']]);
        // para ordenar descendentemente pero no se porque
        // $predictions = $this->sortMatchups($predictions,'id',true);
        $response = $this->loadPredictions();
        // return $response;

        $log = $this->generateLog('print',['prediction' => $response['predictions'][0]->prediction_id,'uuid' => $response['uuid']]);
        $file = "quiniela".auth()->user()->name.".pdf";

        $pdf = PDF::loadView('predictions.print',['predictions' =>$response['predictions'], 'uuid' => $response['uuid']]);
        // $pdf->save($file); // lo graba en el public de la aplicacion
        return $pdf->download($file);
        // return $pdf->stream("pronostico.pdf");
    }
}
