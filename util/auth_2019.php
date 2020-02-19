<?php
class Auth{
	
    public function __construct(){
	    $log_admin = 'skybedy';
		$log = false;
		$pas = false;
		$pas_admin = 'mk1313life';
		$id_zavodu = Session::get('race_id');
		switch($id_zavodu){
                    case 44: // Praděd
                        $log = 'praded';
                        $pas = 'EQEqeHWNaCgEz0zQne4e';
			break;	
                    case 46: //Mosty - Skalka
			$log = 'mosty_skalka';
			$pas = '2utMeRXdGb3t5wt91Dkp';
                    break;
                    case 7:
			$log = 'sikland_winter_trophy';
			$pas = 'k4lk5vKp785';
                    break;
                    case 22:
			$log = 'sokolovska24';
			$pas = 'k4lk5vKp8wq5Js';
                    break;
                    case 64:
			$log = 'aktivitytour';
			$pas = 'XcvmxL3sWKHwe3';
                    break;
                    case 49:
			$log = 'perun';
			$pas = 'k45qvL3kqKa23';
                    break;
                    case 42: // 24mtb
                        $log = 'bikepoint13';
                        $pas = '0948777670';
                    break;
                    case 63: // 
                        $log = 'novojicinsky_pulmaraton';
                        $pas = 'lKfTVgiKRSKf3TludMr1';
                    break;	

                    case 38: // cube
                        $log = 'bikepoint13';
                        $pas = '0948777670';
                    break;	
                    case 29:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;
                    case 30:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;
                    case 31:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;
                    case 32:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;
                    case 54:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;
                    case 33:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;
                    case 36:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;
                    case 34:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;
                    case 47:
			$log = 'alis_run';
			$pas = 'JomwVwk9PN9EkcLjZ3f8';
                    break;
                    case 61:
			$log = 'ocelacky_triatlon';
			$pas = 'Vrbice2019';
                    break;
                    case 58:
			$log = 'nachodska24';
			$pas = 'Vwk9Pw7q6XB9';
                    break;
                    case 60:  // vetrkovice
                        $log = 'vetrkovice';
                        $pas = 'k4Koi5KHwe855qwr54';
                    break;

                    case 62: // hlucin
                        $log = 'hlucinsky_pulmaraton';
                        $pas = '3dRsgq4Q7JdfWrGCJFyu';
                    break;
                    case 84: // cc hobby
                        $log = 'cc_hobby';
                        $pas = 'bfH4gVdpEjdu8VA8xKDu';
                    break;
                    case 99: // cc hobby
                        $log = 'cc_hobby';
                        $pas = 'bfH4gVdpEjdu8VA8xKDu';
                    break;
                    case 89: // cc hobby
                        $log = 'cc_hobby';
                        $pas = 'bfH4gVdpEjdu8VA8xKDu';
                    break;
                    case 75: // cc hobby
                        $log = 'bikepoint13';
                        $pas = '0948777670';
                    break;
                    case 56: // belsky_okruh
                        $log = 'belsky_okruh';
                        $pas = '5WNoWgq5478ko4xsJkQwe';
                    break;    
                    case 80: // bbl
                        $log = 'bbl';
                        $pas = '5W7Ngq547Jhwe4xsJkQwe';
                    break;
                    case 51: // Májový bobr
                        $log = 'majovy_bobr';
                        $pas = 'jW5NgqJkqhwe4xsJIkoW';
                    break;
                    case 78: // casovka_lysa
                        $log = 'casovka_lysa';
                        $pas = 'ENXHOO0fxzTwDnUQDuCT';
                    break;
                    case 101: // BLATICKO
                        $log = 'bikepoint15';
                        $pas = '0948777670';
                    break;
                    case 102: 
                        $log = 'raca_beh';
                        $pas = 'ENXKmk0fKuwDnUQDuW5';
                    break;
                    case 106: // Beskydsky biatlon
                        $log = 'beskydsky_biatlon';
                        $pas = '1aUTEnYMCJyqsRaf8eWd';
                    break;
                    case 100: // zatopek
                        $log = 'brkem';
                        $pas = '54qwetuLoe354';
                    break;
                    case 65:
			$log = 'aktivitytour';
			$pas = 'XcvmxL3sWKHwe3';
                    break;
                    case 68:
			$log = 'aktivitytour';
			$pas = 'XcvmxL3sWKHwe3';
                    break;
                    case 66:
			$log = 'aktivitytour';
			$pas = 'XcvmxL3sWKHwe3';
                    case 67:
			$log = 'aktivitytour';
			$pas = 'XcvmxL3sWKHwe3';
                    break;
                    case 69:
			$log = 'aktivitytour';
			$pas = 'XcvmxL3sWKHwe3';
                    break;
                    break;
                    case 60:
			$log = 'vetrkovice';
			$pas = 'Xcv6KqL3sJuwHwe3';
                    break;
                    case 117: // slapka
                        $log = 'osecanska_slapka';
                        $pas = '2bDEk5QPN4WtVzJjuQqP';
                    break;
                    case 118: // velka cena hradce
                        $log = 'velkacenahk';
                        $pas = '2bkW5Q4QWtVzJju4x';
                    break;
                    case 94: // hyundai
                        $log = 'hyundai_beh';
                        $pas = '2bKl5Q4qWtVzK6s';
                    break;
                    case 122: // bila
                        $log = 'beskydska_magistrala';
                        $pas = '2KLkQ4q54qzK54ws';
                    break;
                }
		
		$log1 = 'skybedy';
		$pas1 = 'mk1313life';
		
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

