<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matchups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stadium_id');
            $table->unsignedBigInteger('team_id_a');
            $table->unsignedBigInteger('team_id_b');
            $table->tinyInteger('goals_team_a')->default(0);
            $table->tinyInteger('goals_team_b')->default(0);
            $table->date('game_date');
            $table->enum('status', ['Pendiente', 'Proceso','Finalizado'])->default('Pendiente');
            $table->timestamps();

            $table->foreign('stadium_id')->references('id')->on('stadiums')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('team_id_a')->references('id')->on('teams')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('team_id_b')->references('id')->on('teams')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matchups');
    }
}
