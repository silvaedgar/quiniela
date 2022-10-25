<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_goals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('matchup_id');
            $table->unsignedBigInteger('team_id');
            $table->string('name_player', 50);
            $table->tinyInteger('minute');
            $table->timestamps();

            $table->foreign('matchup_id')->references('id')->on('matchups')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_goals');
    }
}
