<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_players', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('teamId')->unsigned();
            $table->bigInteger('playerId')->unsigned();
            $table->timestamps();

            $table->index('playerId');
            $table->foreign( 'playerId')->references('id')->on('players');
            $table->index('teamId');
            $table->foreign( 'teamId')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams_players');
    }
}
