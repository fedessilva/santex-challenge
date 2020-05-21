<?php

namespace App\Console\Commands;

use App\Competition;
use App\Exceptions\ConnectivityIssueException;
use Illuminate\Console\Command;

class ImportByLeagueCode extends Command {

    protected $signature = 'import:league {leagueCode=0}';
    protected $description = 'Command description';

    public function handle() {

        $leagueCode = $this->argument( 'leagueCode' );
        echo "\nImporting ... ".$leagueCode."\n";
        try {
            $result = Competition::import($leagueCode);
            if($result) {
                echo "\nImported... ".$leagueCode."\n";
            } else {
                echo "\nNot Found... ".$leagueCode."\n";
            }

        } catch (\Exception $e) {
            echo "\n".$e->getMessage()."\n";
        }

    }

}
