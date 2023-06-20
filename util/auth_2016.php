<?php
class Auth{
	
    public function __construct(){
	    $log_admin = 'skybedy';
		$log = false;
		$pas = false;
		$pas_admin = 'mk1313life';
		$id_zavodu = Session::get('race_id');
		switch($id_zavodu){
		    case 1: //
			$log = 'dynafit_skialp_vertical_race';
			$pas = 'kWkkQ871w';
			break;
		    case 5: //perun
			$log = 'perun';
			$pas = 'qoeIurQw9';
			break;
		    case 20: //pedalovnik
			$log = 'bikepoint13';
			$pas = '0948777670';
			break;
		    case 10: //pedalovnik
			$log = 'bikepoint13';
			$pas = '0948777670';
			break;
		    case 8: //KUCHYNA
			$log = '24_hodin_mtbike_jam';
			$pas = 'kQw54qCV1qW2';
		    break;
		    case 9: //jihlava
			$log = 'jihlavska_24';
			$pas = 'qw4loqw_nv47';
		    break;
		    case 11: //Náchodská 24
			$log = 'nachodska_24hours_mtb';
			$pas = 'ls_w4@nuw8l4';
		    break;		    
		    case 12: //OPAVA 24
			$log = 'opavska_24';
			$pas = '4k8q7x4mmqQw';
		    break;
                    case 19: //jihlava
			$log = 'jihlavsky_pulmaraton';
			$pas = '4qw47tz14sdm';
		    break;
		    case 21: //Majetín
			$log = 'krtrima';
			$pas = 'Kq85qw98ma45';
		    break;		    
		    case 23: //BBL
			$log = 'bbl';
			$pas = 'o7H8p65sWQ';
		    break;		    
		    case 25://vetrkovice
			$log = 'vetrkovicky_triatlon';
			$pas = 'k4t6q61lw5';
		    break;
		    case 26://sokolov
			$log = 'sokolovsky_ctvrmaraton';
			$pas = 'kqo5lqou8';
		    break;
		    case 29://odrvous
			$log = 'odrivousuv_pohar';
			$pas = 'k7e345w7ok94';
		    break;
		    case 33://prajzak
			$log = 'zelezny_prajzak';
			$pas = '5als65qwer45';
		    break;

		    case 39://hlucin
			$log = 'hlucinsky_pulmaraton';
			$pas = 'kjwzhq78m4k4';
		    break;
		    case 41://radegastova vyzva 24hod
			$log = 'radegastova_vyzva';
			$pas = 'Lpw47qmck4q8';
		    break;
		    case 43://koprivnice
			$log = 'brkez';
			$pas = 'kW5r8z54nkq';
		    break;
		    case 76://radegastova vyzva 13km
			$log = 'radegastova_vyzva';
			$pas = 'Lpw47qmck4q8';
		    break;
		    case 46://sport bar bikemarathon
			$log = 'sport_bar_bikemarathon';
			$pas = 'ml4ar8pqw_84';
		    break;
		    case 47://100 pro adru
			$log = '100_pro_adru';
			$pas = '4a5f7m3s5s7s';
		    break;
		    case 50://belsky okruh
			$log = 'belsky_okruh';
			$pas = 'LqQ8qoW1Q';
		    break;
		    case 114://cc hobby
			$log = 'cc_hobby';
			$pas = 'cc_hobby';
		    break;
		    case 53://cc hobby
			$log = 'cc_hobby';
			$pas = 'kqw547rNw54';
		    break;
		    case 54://kytlice
			$log = 'kytlicky_minitriatlon';
			$pas = '8q2w4rw54q4';
		    break;
		    case 48://ustecky schod
			$log = 'ustecky_schod';
			$pas = '5kql54_poWeP';
		    break;
		    case 71://mtb krune hory
			$log = 'qwert_maraton';
			$pas = 'j5e4k8m6w8b2';
		    break;
		    case 83://nezmar
			$log = 'nezmar';
			$pas = 'kqw58f81hsO';
		    break;
		    case 121://machinery
			$log = 'machinery_run';
			$pas = 'kOw7hqu65jioq';
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

