<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Prediction;

trait PlayersTrait {

    use PredictionsTrait;

    public function activatePlayers(Request $request) {

        foreach ($request->activate_id as $key => $value) {
            User::where('id',$request->activate_id[$key])->update(['status' => 'Activo']);
            $prediction = $this->predictionPlayers($request->activate_id[$key])->get();
            $prediction = $this->sortMatchups($prediction,$prediction[0]->id);
            $index = count($prediction);
            Prediction::where('id',$prediction[$index-1]->id)->update(['status' => 'Activo']);
        }

        return ;

    }

}



