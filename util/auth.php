<?php
class Auth{
	
    public function __construct(){
        $log_admin = 'skybedy';
        $log = false;
        $pas = false;
        $pas_admin = 'mk1313life';
        $id_zavodu = Session::get('race_id');
        switch($id_zavodu){
            case 5:
                $log = 'perun';
                $pas = 'k45qvL3kqKa23';
            break;
            case 7: // biatlonubri
                $log = 'biatlon_zubri';
                $pas = '5mqU2LLqOujQ4';
            break;
            case 11: // BRKEZ
                $log = 'brkez';
                $pas = '54qwTweLoeO3Q4';
            break;
            case 13: // 3xtop
                $log = '3xtop';
                $pas = 'KoweLo54S';
            break;
            case 20: // 3xtop
                $log = 'bikepoint';
                $pas = '0948777670';
            break;
            case 21: // 24sokolov
                $log = 'sokolov';
                $pas = '32MqwLqJ3Q4';
            break;
            case 26: // pribor
                $log = 'priborsky_beh';
                $pas = '4llloQJLk';
            break;
            case 28:
                $log = 'nachodska24';
                $pas = 'Vwk9Pw7q6XB9';
            break;
    




        }

        $log1 = 'skybedy';
        $pas1 = 'CfyKsL2YVO2ZoxruYGYO';

        if(!isset($_SERVER['PHP_AUTH_USER'])){
            header('WWW-Authenticate: Basic realm="TimeChip - administrace prihlasek"');
            header('HTTP/1.0 401 Unauthorized');
            exit;
        }
        else{
            if($_SERVER['PHP_AUTH_USER'] != ($log) || $_SERVER['PHP_AUTH_PW'] != ($pas)){
               if($_SERVER['PHP_AUTH_USER'] != ($log1) || $_SERVER['PHP_AUTH_PW'] != ($pas1)){  
                    Header("HTTP/1.1 401 Unauthorized");
                    Header("WWW-Authenticate: Basic realm=\"TimeChip - administrace prihlasek\"");
                    die("Bylo zadano spatne jmeno nebo heslo a tak to zkuste znovu, nebo nas kontaktujte na timechip@timechip.cz");
               }
            }
        }
   }
}	

