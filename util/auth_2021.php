<?php
class Auth{
	
    public function __construct(){
        $log = false;
        $pas = false;
        $id_zavodu = Session::get('race_id');
        switch($id_zavodu){
            case 2:
                $log = 'sikland_winter_race';
                $pas = 'k45qvKlW25';
            break;
            case 3:
                $log = 'perun';
                $pas = 'k45qvL3kqKa23';
            break;
            case 4:
                $log = 'novojicinsky_pulmaraton';
                $pas = 'Lk5UwMji';
            break;
            case 6:
                $log = 'priborsky_beh';
                $pas = '5UjOuei';
            break;
            case 19:
                $log = 'nachodska24';
                $pas = 'e2PfFVTEzjn';
            break;
            case 13: // cc_hoby
                $log = 'cc_hobby';
                $pas = '2022';
            break;
            case 7: // 3xtop
                $log = 'bikepoint';
                $pas = '0948777670';
            break;
            case 20: // zatopek
                $log = 'brkez';
                $pas = '54qwTweLoeO3Q4';
            break;
            case 26: // belsky okruh
                $log = 'belsky_okruh';
                $pas = 'Vwk9Pw7q6Ue';
            break;

            case 34: // welzl
                $log = 'welzl';
                $pas = 'XLk5qKHwGtswt';
            break;
            case 11: // 3xtop
                $log = '3xtop';
                $pas = 'KoweLo54S';
            break;
            case 18: // 24sokolov
                $log = 'sokolov';
                $pas = '32MqwLqJ3Q4';
            break;
            case 37: // linda
                $log = 'linda';
                $pas = '32MqJie44';
            break;
            case 35: // biatlonubri
                $log = 'biatlon_zubri';
                $pas = '5mqU2LLqOujQ4';
            break;
            case 40: // vetrky
                $log = 'vetrkovice';
                $pas = '5Qt42LLqK5Q4';
            break;

            case 24: // roznovsky krpal
                $log = 'krpal';
                $pas = '5Qt5pLLqKoI4';
            break;

            case 42: // roznovsky krpal
                $log = 'harta_mtb';
                $pas = 'low54he4N';
            break;
            case 43:  // osecany
                $log = 'osecanska_slapka';
                $pas = 'k5adqKHwKowt';
            break;
            case 47:  // poho50
                $log = 'poho50';
                $pas = 'k5adKoWwKowt';
            break;
            case 48:  // cupitalek
                $log = 'cupitalek';
                $pas = 'kaKoKjQ84t';
            break;
            case 49:  // darina
                $log = 'behnjparkem';
                $pas = 'Lkwo47Bjhe';
            break;


        }

        $log1 = 'skybedy';
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

