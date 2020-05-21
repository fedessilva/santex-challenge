<?php

namespace App;

use App\Exceptions\ConnectivityIssueException;
use Carbon\Carbon;
use Grambas\FootballData\Facades\FootballDataFacade;
use Illuminate\Database\Eloquent\Model;


class Competition extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'externalId',
        'name',
        'code',
        'areaName',
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
     * The teams that belong to a competition.
     */
    public function teams()
    {
        return $this->belongsToMany('App\Team', 'competitions_teams', 'competitionId', 'teamId');
    }

    public static function import($leagueCode) {

        try {

            self::getLeagues();

            $leagueObj = Competition::where('code', $leagueCode)->first();
            if (!$leagueObj) return false;

            self::getLeagueTeams($leagueObj);


            $competitions_teams = $leagueObj->teams;
            if ($competitions_teams) {
                foreach ($competitions_teams as $ck => $competition_team) {
                    self::getTeam($competition_team);
                }
            }

            return true;

        } catch (\Exception $exception) {

            throw new ConnectivityIssueException('Server Error');

        }

    }

    public function getTotalPlayers() {

        $players = 0;
        foreach ($this->teams as $key => $team) {
            $players += $team->players->where('role', 'PLAYER')->count();
        }

        return $players;
    }

    private static function getLeagues() {

        try {

            $leagues = FootballDataFacade::getLeagues();
            foreach($leagues as $kl => $league) {
                $data = [
                    'externalId' => $league->id,
                    'name'       => $league->name,
                    'code'       => $league->code,
                    'areaName'   => $league->area ? $league->area->name : '-',
                ];
                Competition::updateOrCreate(['externalId' => $league->id],$data);
            }

        } catch (\Exception $e) {

            if($e->getCode() == 429) {

                $headers_response = $e->getResponse()->getHeaders();
                $time_to_wait = $headers_response['X-RequestCounter-Reset'];
                sleep($time_to_wait[0]+1);
                return self::getLeagues();

            } else {

                throw new ConnectivityIssueException();

            }

        }
    }

    private static function getLeagueTeams($leagueObj) {

        try {

            $teams = FootballDataFacade::getLeagueTeams($leagueObj->externalId, []);
            if($teams) {
                foreach($teams as $kt => $team) {
                    $data = [
                        'externalId'=> $team->id,
                        'name'      => $team->name,
                        'tla'       => $team->tla,
                        'shortName' => $team->shortName,
                        'areaName'  => $team->area ? $team->area->name : '-',
                        'email'     => $team->email
                    ];
                    $inserted_team = Team::updateOrCreate(['externalId' => $team->id], $data);
                    CompetitionTeam::updateOrCreate(['competitionId' => $leagueObj->id, 'teamId' => $inserted_team->id]);
                }
            }

        } catch (\Exception $e) {

            if($e->getCode() == 429) {

                $headers_response = $e->getResponse()->getHeaders();
                $time_to_wait = $headers_response['X-RequestCounter-Reset'];
                sleep($time_to_wait[0]+1);
                return self::getLeagueTeams($leagueObj);

            } else {
                throw new ConnectivityIssueException();
            }

        }
    }

    private static function getTeam($competition_team) {

        try {

            $team_data = FootballDataFacade::getTeam($competition_team->externalId);
            if($team_data && isset($team_data['squad'])) {

                foreach($team_data['squad'] as $tdk => $player) {
                    $data = [
                        'externalId'    => $player->id,
                        'name'          => $player->name,
                        'position'      => $player->position,
                        'dateOfBirth'   => Carbon::parse($player->dateOfBirth)->format('Y-m-d'),
                        'countryOfBirth'=> $player->countryOfBirth,
                        'nationality'   => $player->nationality,
                        'role'          => $player->role,
                    ];
                    $playerObj = Player::updateOrCreate(['externalId' => $player->id], $data);
                    TeamPlayer::updateOrCreate(['teamId' => $competition_team->id, 'playerId' => $playerObj->id]);
                }
            }

        } catch (\Exception $e) {

            if($e->getCode() == 429) {

                $headers_response = $e->getResponse()->getHeaders();
                $time_to_wait = $headers_response['X-RequestCounter-Reset'];
                sleep($time_to_wait[0]+1);
                return self::getTeam($competition_team);

            } else {
                throw new ConnectivityIssueException();
            }

        }
    }
}

