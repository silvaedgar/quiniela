<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Matchup extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['stadium_id','game_date','team_id_a','team_id_b'];

    protected static $logAttributes = ['stadium_id','game_date','team_id_a','team_id_b','goals_team_a','goals_team_b','status'];

    public function stadium() {
        return $this->belongsTo(Stadiums::class, 'stadium_id', 'id');
    }

    public function teamA() {
        return $this->belongsTo(Team::class, 'team_id_a', 'id');
    }

    public function teamB() {
        return $this->belongsTo(Team::class, 'team_id_b', 'id');
    }

    public function prediction() {
        return $this->hasMany(Prediction::class, 'matchup_id', 'id');
    }

    public function goals()
    {
        return $this->hasMany(PlayerGoal::class, 'matchup_id', 'id');
    }

}
