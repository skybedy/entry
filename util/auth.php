<?php
class Auth{
	
    public function __construct(){
	    $log_admin = 'skybedy';
		$log = false;
		$pas = false;
		$pas_admin = 'mk1313life';
		$id_zavodu = Session::get('race_id');
		switch($id_zavodu){
                    case 1:
			$log = 'sikland_winter_trophy';
			$pas = 'k4lk5vKp785';
                    break;
                    case 2:
			$log = 'aktivitytour';
			$pas = 'XcvmxL3sWKHwe3';
                    break;
                    case 3:
			$log = 'mosty_skalka';
			$pas = 'XcxwEW5WKOwK';
                    break;
                    case 4:
			$log = 'perun';
			$pas = 'k45qvL3kqKa23';
                    break;
                    case 5:
			$log = '24mtbbikejam';
			$pas = 'e2PfFVTEzjnZavYNkF2u';
                    break;
                    case 6:
			$log = 'nachodska24';
			$pas = 'Vwk9Pw7q6XB9';
                    break;
                    case 9:
			$log = 'beskydsky_biatlon';
			$pas = 'e2PfFVLkiwzjnZKwuiF2u';
                    break;
                    case 10:
			$log = 'alis_run';
			$pas = 'JomwVwk9PN9EkcLjZ3f8';
                    break;
                    case 11:
			$log = 'aktivitytour';
			$pas = 'XcvmxL3sWKHwe3';
                    break;
                    case 12: // 
                        $log = 'novojicinsky_pulmaraton';
                        $pas = 'lKfTVgiKRSKf3TludMr1';
                    break;	
                    case 15: // zatopek
                        $log = 'brkez';
                        $pas = '54qwTweLoeO3Q4';
                    break;
                    case 18: // vankac
                        $log = 'vankac_race';
                        $pas = '32MqwweLqJ3Q4';
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

