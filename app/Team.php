<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'externalId',
        'name',
        'tla',
        'shortName',
        'areaName',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'externalId',
    ];

    /**
     * The competitions that belong to the team.
     */
    public function competitions()
    {
        return $this->belongsToMany('App\Competition', 'competitions_teams', 'teamId', 'competitionId');
    }

    /**
     * Get the players for the team.
     */
    public function players()
    {
        return $this->belongsToMany('App\Player', 'teams_players', 'teamId', 'playerId');
    }
    
}
