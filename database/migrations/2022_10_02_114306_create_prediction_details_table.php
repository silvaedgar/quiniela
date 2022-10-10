<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePredictionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prediction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prediction_id');
            $table->unsignedBigInteger('matchup_id');
            $table->tinyInteger('goals_team_a');
            $table->tinyInteger('goals_team_b');
            $table->tinyInteger('points')->default(0);

            $table->timestamps();

            $table->foreign('prediction_id')->references('id')->on('predictions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('matchup_id')->references('id')->on('matchups')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prediction_details');
    }
}
