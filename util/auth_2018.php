<?php
class Auth{
	
    public function __construct(){
	    $log_admin = 'skybedy';
		$log = false;
		$pas = false;
		$pas_admin = 'mk1313life';
		$id_zavodu = Session::get('race_id');
		switch($id_zavodu){
                    case 1: // 24mtb
                        $log = 'bikepoint13';
                        $pas = '0948777670';
			break;	
		    case 7:
			$log = 'sikland_winter_trophy';
			$pas = 'k4lk5vKp785';
                    break;
		    case 8:
			$log = 'beh_mosty_skalka';
			$pas = 'k45w5vKJkqKa54';
                    break;
		    case 9:
			$log = 'perun';
			$pas = 'k45qvL3kqKa23';
                    break;
                    case 70:
			$log = 'aktivitytour';
			$pas = 'XcvmxL3sWKHwe3';
                    break;
                    case 12:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;
                    case 13:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;
                    case 14:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;
                    case 15:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;                    
                    case 16:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;
                    case 102:
			$log = 'novacup';
			$pas = 'gVKrtjw7q6XB94NV1o3V';
                    break;
                    case 18:
			$log = '24_hodin_mtbike_jam';
			$pas = '953KmtwRPq8LHvymuUj7';
                    break;
                    case 20:
			$log = 'alis_run';
			$pas = 'JomwVwk9PN9EkcLjZ3f8';
                    break;
                    case 21: // pedalovnik
                        $log = 'bikepoint13';
                        $pas = '0948777670';
                    break;	
                    case 24: // majovy bobr
                        $log = 'majovy_bobr';
                        $pas = 'sfcigYh6QWcIPul7dDtL';
                    break;	
                    case 25: // bolatice
                        $log = 'bolaticka_30';
                        $pas = 'sfceoWh6QWcILqP7dkW';
                    break;	
                    case 26: // bison
                        $log = 'bikepoint13';
                        $pas = '0948777670';
                    break;	
                    case 27: // 
                        $log = 'novojicinsky_pulmaraton';
                        $pas = 'lKfTVgiKRSKf3TludMr1';
                    break;	
                    case 78: // cc hobby
                        $log = 'cc_hobby';
                        $pas = 'bfH4gVdpEjdu8VA8xKDu';
                    break;
                    case 80: // cc hobby
                        $log = 'cc_hobby';
                        $pas = 'bfH4gVdpEjdu8VA8xKDu';
                    break;
                    case 92: // cc hobby
                        $log = 'cc_hobby';
                        $pas = 'bfH4gVdpEjdu8VA8xKDu';
                    break;
                    case 30: // hlucin
                        $log = 'hlucinsky_pulmaraton';
                        $pas = '3dRsgq4Q7JdfWrGCJFyu';
                    break;
                    case 46: // belsky_okruh
                        $log = 'belsky_okruh';
                        $pas = '5WNoWgq5478ko4xsJkQwe';
                    break;                
                    case 47: // bbl
                        $log = 'bbl';
                        $pas = '5W7Ngq547Jhwe4xsJkQwe';
                    break;
                    case 50: // nachod
                        $log = 'nachodska24';
                        $pas = 'cexNKViRaP5hz3icqdbM';
                    break;
                    case 67:  // bbl
                        $log = 'zelenak';
                        $pas = 'pEjduq4Q5cIPul4wuFyu';
                    break;   
                    case 79:  // nefrofr
                        $log = 'nefrofr';
                        $pas = 'k4lk5vKp785LkWr54';
                    break; 
                    case 63:  // vetrkovice
                        $log = 'vetrkovice';
                        $pas = 'k4Koi5KHwe855qwr54';
                    break;
                    case 64:  // brusperk
                        $log = 'brusperk';
                        $pas = 'k4Koi5Kwr785L4r54';
                    break;
                    case 136: // cc hobby
                        $log = 'cc_hobby';
                        $pas = 'bfH4gVdpEjdu8VA8xKDu';
                    break;
                    case 101: // casovka_lysa
                        $log = 'casovka_lysa';
                        $pas = 'ENXHOO0fxzTwDnUQDuCT';
                    break;
                    case 112: // majetin
                        $log = 'majetin';
                        $pas = '2bDEkPNLgAtVzSxIuQqP';
                    break;
                    case 118: // slapka
                        $log = 'osecanska_slapka';
                        $pas = '2bDEk5QPN4WtVzJjuQqP';
                    break;
                    case 54: // zatopek
                        $log = 'brkem';
                        $pas = '54qwetuLoe354';
                    break;
                    case 124: // okolo lyse hory
                        $log = 'okolo_lyse';
                        $pas = 'lbDhW0TNpyMDLrsGRwqQ';
                    break;
                    case 108: // okolo lyse hory
                        $log = 'czech_downhill';
                        $pas = 'uIwfzuD5GtzeIZqGLoBm';
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

