<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('point_team_goals'); // puntos por acertar los goles cada equipo
            $table->tinyInteger('point_matchup_result');  // puntos por acertar el resultado
            $table->date('date_current');  // dia del torneo
            $table->enum('status', ['Activo', 'Inactivo'])->default('Inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config');
    }
}
