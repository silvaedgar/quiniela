<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Mail\SendMail;
use App\Models\User;

use App\Traits\PredictionsTrait;
use App\Traits\MatchupsTrait;
use App\Traits\PlayersTrait;
use PDF;


class PlayerController extends Controller
{
    use PredictionsTrait, MatchupsTrait, PlayersTrait;

    public function __construct() {
        // registrado en kernel de http controller
        $this->middleware('user.active');
        $this->middleware('role.admin')->except('index','position');
    }

    public function index()
    {
        $players = $this->predictionPlayers(0)->get();
        $players = $this->sortMatchups($players,'players.name');
        $positions = $this->getPositions()->get();
        foreach ($players as $index => $player) {
            foreach ($positions as $index1 => $position) {
                if ($players[$index]->player_id == $position->id ) {
                    $players[$index]['position'] = $index1 + 1;
                    $players[$index]['points'] = $position->points;
                }
            }

        }
        $response = ['header' => 'Jugadores Participantes', 'is_prediction' => false, 'players' => $players];
        return view('players.index', compact('response'));
    }

    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            $users_activate = $this->activatePlayers($request);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        return redirect('/home')->with(['message' => 'Se activaron los Usarios'.$users_activate]);

            // dd(request()->all());
    }

    public function activate()
    {
        $players = User::where('status','Inactivo')->get();
        $response = ['header' => 'Jugadores sin Activar', 'is_prediction' => false, 'players' => $players];
        return view('players.activate', compact('response'));
    }

    public function sendEmail() {
        $response['positions'] = $this->getPositions()->get();
        $response['current_date'] = $this->getDate()->first();
        Mail::to(['silvaed72@gmail.com','admin@quiniela.com'])->send(new SendMail($response));
         $message = "Correos Enviados";
        return redirect('/home')->with(['message' => 'Correos Enviados']);
    }

    public function position() {

        $response['positions'] = $this->getPositions()->get();
        $response['current_date'] = $this->getDate()->first();
        $response['current_time'] = now();

        $pdf = PDF::loadView('players.positions',['positionPlayers' =>$response]);
        return $pdf->download('positions'.$response['current_date']->date_current.".pdf");

    }
}
