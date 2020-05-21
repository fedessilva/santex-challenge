<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionTeam extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'competitions_teams';
    protected $fillable = [
        'competitionId',
        'teamId',
    ];
    
}
