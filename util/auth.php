<?php
class Auth{
	
    public function __construct(){
        $log = false;
        $pas = false;
        $id_zavodu = Session::get('race_id');
        switch($id_zavodu){
            case 1:
                $log = 'sikland_winter_race';
                $pas = 'k45qvKlW25';
            break;
            case 7:
                $log = 'novojicinsky_pulmaraton';
                $pas = 'behajicidroni2023';
            break;
            case 3:
                $log = 'priborsky_beh';
                $pas = 'kloFs54Uq54';
            break;
            case 8: // slezska harta
                $log = 'harta_mtb';
                $pas = 'low54he4N';
            break;
            case 5: // welzl
                $log = 'welzl';
                $pas = 'XLk5qKHwGtswt';
            break;
            case 10:
                $log = 'senovrun';
                $pas = 'e2PfFKtKj6';
            break;
            case 15: // zatopek
                $log = 'brkez';
                $pas = '54qwTweLoeO3Q4';
            break;
            case 16: // 3xtop
                $log = '3xtop';
                $pas = 'KoweLo54S';
            break;
            case 17: // vetrky
                $log = 'vetrkovice';
                $pas = '5Qt42LLqK5Q4';
            break;
            case 18: // biatlonubri
                $log = 'biatlon_zubri';
                $pas = '5mqU2LLqOujQ4';
            break;
            case 19: // biatlonubri
                $log = 'detmarovicka10';
                $pas = 'koq54Oiwe';
            break;

            

        }

        $log1 = 'timechip';
        $pas1 = '2004timechip2020';

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

