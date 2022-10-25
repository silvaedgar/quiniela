<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerGoal extends Model
{
    use HasFactory;

    protected $fillable = ['matchup_id','team_id','name_player','minute'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'id', 'team_id');
    }

    public function matchup(): BelongsTo
    {
        return $this->belongsTo(Matchup::class, 'id', 'matchup_id');
    }
}
