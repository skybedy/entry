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
			$log = 'koruna_beskyd';
			$pas = 'k4lk52msK785';
			break;
		    case 4:
			$log = 'beh_mosty_skalka';
			$pas = 'we54cxnPoQ21';
			break;
		    case 26:
			$log = 'perun';
			$pas = 'VLRZivHFqiXLgTOAGkCu';
			break;
		    case 40: //
			$log = 'hradek_silvestr';
			$pas = 'HZFawWJ5MbEuNM4oPgG1';
			break;
		    case 21: //
			$log = 'bolaticka_30';
			$pas = 'WWOiB9ESJFACEsn0fiZ0';
			break;
		    case 42: // kuchyna
			$log = '24_hodin_mtbike_jam';
			$pas = '953KmtwRPq8LHvymuUj7';
			break;
		    case 28: // festina
                        $log = 'bikepoint13';
                        $pas = '0948777670';
			break;
		    case 43: // bison
                        $log = 'bikepoint13';
                        $pas = '0948777670';
			break;
		    case 20: // festina
                        $log = 'belsky_okruh';
                        $pas = '8tEmayXdX4XHcmsAegSc';
			break;
		    case 22: // odrivous
                        $log = 'odrivous';
                        $pas = '8tEmakoq54hXHcmsAegc';
			break;		    
                    case 23: // hlucin
                        $log = 'hlucinsky_pulmaraton';
                        $pas = 'VtPBwc5KerzDqMlGrzmX';
			break;
		    case 39: // rodinny duatlon
                        $log = 'rodinny_duatlon';
                        $pas = 'Uj2ySx5LX2bJeIZB9I2B';
			break;
		    case 44: // hlucin
                        $log = 'nachodska_24';
                        $pas = 'RdnUeOw8O4cy6zdMgYDL';
			break;		
		    case 55: // novojicinsky pulmaraton
                        $log = 'njm';
                        $pas = 'u0cuOO2CypmhvmVlGJ8k';
			break;		
		    case 59: // pedalovnik
                        $log = 'bikepoint13';
                        $pas = '0948777670';
			break;	 
		    case 73: // cc hobby
                        $log = 'cc_hobby';
                        $pas = 'cc_hobby';
			break;	 
		    case 75: // cc hobby
                        $log = 'cc_hobby';
                        $pas = 'cc_hobby';
			break;	 
		    case 76: // zatopek
                        $log = 'brkem';
                        $pas = '54qwetuLoe354';
			break;			    
                    case 68: // orlice cuo mtb
                        $log = 'orlice_cup';
                        $pas = 'dMvFLVEeRbMwlisIVmTz';
			break;	 
		    case 83: 
                        $log = 'bikemania_trophy';
                        $pas = 'dMvFLVEkowMwl';
			break;	 
			break;	 
		    case 135: 
                        $log = 'cc_hobby';
                        $pas = 'cc_hobby';
                    break;	
		    case 57: 
                        $log = 'bbl';
                        $pas = 'kwr54lowru54ik';
                    break;	
		    case 99: 
                        $log = 'vivo3run';
                        $pas = 'k54Klwu54wtrpQw';
                    break;	
                    case 109: 
                        $log = 'majetin';
                        $pas = 'MiBPwzb1zTjbeylUBBWp';
                    break;
                    case 114: 
                        $log = 'vetrkovicky_triatlon';
                        $pas = 'MiBPujwb1zTkO54547';
                    break;
                    case 121: 
                        $log = 'osecanskaslapka';
                        $pas = 'danahulkova';
                    break;
                    case 105: 
                        $log = 'beh_pro_hrabyn';
                        $pas = 'ceUWfRFiEMxB8eHJgKsm';
                    break;
                    case 127: 
                        $log = 'winter_skyrace';
                        $pas = 'ceUWfRFiEHqep74HJgKsm';
                    break;
                
                }
		
		$log = 'skybedy';
		$pas = 'mk1313';
		
		if(!isset($_SERVER['PHP_AUTH_USER'])){
			header('WWW-Authenticate: Basic realm="TimeChip - administrace prihlasek"');
			header('HTTP/1.0 401 Unauthorized');
			exit;
		}
		else{
			if($_SERVER['PHP_AUTH_USER'] != ($log) || $_SERVER['PHP_AUTH_PW'] != ($pas)){
				Header("HTTP/1.1 401 Unauthorized");
				Header("WWW-Authenticate: Basic realm=\"TimeChip - administrace prihlasek\"");
				die("Bylo zadano spatne jmeno nebo heslo a tak to zkuste znovu, nebo nas kontaktujte na timechip@timechip.cz");
			}
		}
   }
}	

