<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamPlayer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'teams_players';
    protected $fillable = [
        'teamId',
        'playerId'
    ];
    
}
