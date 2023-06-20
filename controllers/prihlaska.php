<?php
class Prihlaska extends Controller{
	
	public $podzavod;

	function __construct() {
	    Session::init();
	    parent::__construct();
	    $this->view->js = Array('prihlaska/js/underscore.js','prihlaska/js/backbone.js','prihlaska/js/jquery.validate.js','prihlaska/js/default.js','prihlaska/js/messages_cs.js'); 
	}
	 
	public function Index(){
	    if(Session::get('token') == false){
		$token = uniqid(mt_rand(), true);
		Session::set('token',$token);
	    }
            
	    $this->view->h1 = 'Přihláška k závodu '.$this->model->NazevZavodu;
            if($_SESSION['race_id'] != '46000'){  //Běh  Mosty-Skalka
               $this->view->h1 .= ' '.$this->model->RokZavodu; 
            }
	    $this->view->NazevZavodu = $this->model->NazevZavodu;
	    $this->view->RokZavodu = $this->model->RokZavodu;
	    $this->view->IdZavodu = $this->model->IdZavodu;
	    $this->view->reklamy = $this->model->Reklamy();
	    $this->view->vyber_kategorii = $this->model->VyberKategorii();
	    $this->view->seznam_statu = $this->model->SeznamStatu();
            $this->view->tricka = $this->model->Tricka();
	    $this->view->vyber_podzavodu = $this->model->VyberPodzavodu();
	   
            
            
            
            if($this->model->IdZavodu == 38){
                $this->view->ponozky = $this->model->Ponozky();
            }
           
			if($this->model->IdZavodu == 9){
		$this->view->zdravotni_pojistovny = $this->model->ZdravotniPojistovny();
		$this->view->znacky_motocyklu = $this->model->ZnackyMotocyklu();
		$this->view->objemy_motoru = $this->model->objemy_motoru();
	    }

            if(($this->model->IdZavodu == 48 AND $this->model->RokZavodu == 2019)  || ($this->model->IdZavodu == 101 AND $this->model->RokZavodu == 2019)  || ($this->model->IdZavodu == 68 AND $this->model->RokZavodu == 2019)  || ($this->model->IdZavodu == 65 AND $this->model->RokZavodu == 2019)){
                $this->view->vlny = $this->model->Vlny();
            }

            if($this->model->IdZavodu == 100001){
                $this->view->vlny = $this->model->VlnyBlaticko();
            }
            $this->view->Render('prihlaska/index');  
	}
	
	
	
	public function xhrFinish($id_zavodu){
	    if($this->model->xhrFinish($id_zavodu)){
		$this->view->mail_na_zavodnika = $this->model->mail_na_zavodnika;
		 session_destroy();
		 header('Location: '.URL.'prihlaska/uspesne_prihlaseni');
	    }
	    else{
		header('Location: '.URL.'prihlaska/neuspesne_prihlaseni');
	    }
	}
        
        
        public function KontrolaKategorie(){
            echo "hoj";
            
        }


	
	
	
	public function vyber_kategorii(){
	    $this->model->VyberKategoriiXHR();
	}
	
	

	
	public function xhrOvereni(){
	    $this->view->h1 = 'Kontrola údajů';
	    $this->view->overeni = $this->model->xhrOvereni();
	    $this->view->Render('prihlaska/overeni'); 
	}
	 
	public function xhrRepair(){ //predelat do ajaxu
	    if(Session::get('token') == true){
		header('Location: '.URL.'prihlaska');
	    }
	    else{
		 header('Location: '.URL.'prihlaska/neuspesne_prihlaseni');
	    }
	}
	
	public function Uspesne_Prihlaseni(){
	    $this->view->h1 = 'Úspěšené příhlášení';
	    $this->view->Render('prihlaska/uspesne-prihlaseni'); 
	}
	
	public function Neuspesne_Prihlaseni(){
	    $this->view->h1 = 'Nespěšené příhlášení';
	    $this->view->Render('prihlaska/neuspesne-prihlaseni'); 
	}
	public function Vybrat_Zavod(){
	    $this->view->Render('prihlaska/vybrat-zavod'); 
	}
	
	public function vypis_prihlasek(){
	    $this->view->h1 = 'Výpis přihlášek';
	    $this->view->VypisPrihlasek = $this->model->VypisPrihlasek();
	    $this->view->reklamy = $this->model->Reklamy();
	    $this->view->Render('prihlaska/vypis_prihlasek');
	}
	
	public function poradi_podzavodu($poradi_podzavodu){
	    Session::set('poradi_podzavodu', $poradi_podzavodu);
	    header('Location: '.URL.'prihlaska');
	}
	
	public function poradi_zavodu($poradi_zavodu){
	    Session::set('poradi_zavodu', $poradi_zavodu);
	    header('Location: '.URL.'prihlaska');
	}
	
	public function pocet_clenu($pocet_clenu){
	    Session::set('pocet_clenu', $pocet_clenu);
	    header('Location: '.URL.'prihlaska');
	}
	
	public function server_data_enduro(){
	    $this->model->DataEnduro();
	} 
	
	public function ulozeni_prihlasky_enduro(){
	    $this->model->xhrSaveToDB(3);
	}
	
	public function overeni_udaju_enduro(){
	     $this->model->OvereniUdajuEnduro();
	}
	
	public function ZdravotniPojistovny(){
	    $this->model->ZdravotniPojistovny();
	}
    }	 
?>
