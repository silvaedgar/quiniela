<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PredictionDetail extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['prediction_id','matchup_id','goals_team_a','goals_team_b'];

    protected static $logFillable = true;  // log a todos los que estan en el fillable

    // protected static $logAttributes = ['player_id','matchup_id','goals_team_a','goals_team_b'];
    // log por atributo

    public function matchup() {
        return $this->belongsTo(Matchup::class, 'matchup_id', 'id');
    }

    public function prediction() {
        return $this->belongsTo(Prediction::class, 'prediction_id', 'id');
    }
}
