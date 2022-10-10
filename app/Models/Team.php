<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function matchupsTeamA(): HasMany
    {
        return $this->hasMany(Matchup::class, 'team_id_a', 'id');
    }

    public function matchupsTeamB(): HasMany
    {
        return $this->hasMany(Matchup::class, 'team_id_b', 'id');
    }

}
