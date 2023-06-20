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

