<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Exceptions\ConnectivityIssueException;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //
    function getImportLeague($leagueCode) {

        try {

            $leagueObj = Competition::where('code', $leagueCode)->first();
            if($leagueObj && count($leagueObj->teams)) return response()->json(['message'=> "League already imported"], 409);

            $result = Competition::import($leagueCode);
            if($result) {
                return response()->json(['message'=> "Successfully imported"], 201);
            } else {
                return response()->json(['message'=> "Not found"], 404);
            }

        } catch (ConnectivityIssueException $e) {

            return response()->json(['message'=> $e->getMessage()], 504);

        } catch (\Exception $e) {

            return response()->json(['message'=> "Server Error"], 504);
        }

    }

    public function getTotalPlayers($leagueCode) {

        try {

            $leagueObj = Competition::where('code', $leagueCode)->first();
            if($leagueObj && !count($leagueObj->teams)) return response()->json(['message'=> "Not found"], 404);

            return response()->json(['total'=> $leagueObj->getTotalPlayers()], 200);

        } catch (\Exception $e) {

            return response()->json(['message'=> "Server Error"], 504);
        }

    }
}
