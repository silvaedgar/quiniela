<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadiums extends Model
{
    use HasFactory;

    public function matchups() {
        return $this->hasMany(Matchup::class, 'stadium_id', 'id');
    }

}
