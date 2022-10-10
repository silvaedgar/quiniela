<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Prediction extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['player_id','uuid','status'];

    protected static $logAttributes = ['player_id','uuid','status'];

    /**
     * Get the user that owns the Prediction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function players() {
        return $this->belongsTo(User::class, 'player_id', 'id');
    }

    public function predictionDetails() {
        return $this->hasMany(PredictionDetail::class, 'prediction_id', 'id');
    }



}
