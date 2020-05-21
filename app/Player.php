<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'externalId',
        'name',
        'position',
        'dateOfBirth',
        'countryOfBirth',
        'nationality',
        'role'
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
     * Get the team that owns the player.
     */
    public function team()
    {
        return $this->belongsToMany('App\Team', 'teams_players',  'playerId','teamId');
    }
    
}
