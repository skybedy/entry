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
			$log = 'nachodska24';
			$pas = 'e2PfFVTEzjn';
                    break;
                    case 6:
			$log = 'belsky_okruh';
			$pas = 'Vwk9Pw7q6Ue';
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
                        $log = 'welzl';
                        $pas = 'lKfTVgiKRSKf3T';
                    break;	
                    case 15: // zatopek
                        $log = 'brkez';
                        $pas = '54qwTweLoeO3Q4';
                    break;
                    case 18: // 24sokolov
                        $log = 'sokolov';
                        $pas = '32MqwLqJ3Q4';
                    break;
                    case 21: // biatlonubri
                        $log = 'biatlon_zubri';
                        $pas = '5mqU2LLqOujQ4';
                    break;
                    case 22: // hlucin
                        $log = 'hlucinsky_pulmaraton';
                        $pas = '3dRsgq4Q7JdfWrGCJFyu';
                    break;
                    case 40: // cc_hoby
                        $log = 'cc_hobby';
                        $pas = '2020';
                    break;
                    case 47: // cc_hoby
                        $log = 'cc_hobby';
                        $pas = '2020';
                    break;
                    case 48: // cc_hoby
                        $log = 'cc_hobby';
                        $pas = '2020';
                    break;
                    case 23: // cc_hoby
                        $log = '3xtop';
                        $pas = 'KoweLo54S';
                    break;
                    case 27: // bbl
                        $log = 'bbl';
                        $pas = 'KoOkQLo54S4l';
                    break;
                    case 31: // zbluňk
                        $log = 'zblunk';
                        $pas = 'KoOgo4554H5W';
                    break;
                    case 32: // tauris
                        $log = 'bikepoint';
                        $pas = '0948777670';
                    break;
                    case 33:  // vetrkovice
                        $log = 'vetrkovice';
                        $pas = 'k4Koi5KHwe855qwr54';
                    break;
                    case 34:  // raca
                        $log = 'raca';
                        $pas = 'k3K4qKHwJi5qwr54';
                    break;
                    case 38:  // osecany
                        $log = 'osecanska_slapka';
                        $pas = 'k5adqKHwKowt';
                    break;
                    case 41:  // osecany
                        $log = 'zapomenute_hory';
                        $pas = 'k5adJuSwKKu0t';
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

