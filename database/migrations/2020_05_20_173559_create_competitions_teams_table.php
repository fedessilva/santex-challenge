<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionsTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions_teams', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('competitionId')->unsigned();
            $table->bigInteger('teamId')->unsigned();
            $table->timestamps();

            $table->index('competitionId');
            $table->foreign( 'competitionId')->references('id')->on('competitions');
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
        Schema::dropIfExists('competitions_teams');
    }
}
