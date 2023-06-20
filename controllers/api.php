<?php
class Api extends Controller{
	
	

	function __construct() {
	    Session::init();
	    parent::__construct();
	}
	 
	public function Index(){
	    $this->view->h1 = 'Přihláška k závodu '.$this->model->NazevZavodu.' '.$this->model->RokZavodu;
	    $this->view->NazevZavodu = $this->model->NazevZavodu;
	    $this->view->RokZavodu = $this->model->RokZavodu;
	    $this->view->IdZavodu = $this->model->IdZavodu;
	    $this->view->reklamy = $this->model->Reklamy();
	    $this->view->vyber_kategorii = $this->model->VyberKategorii();
	    $this->view->seznam_statu = $this->model->SeznamStatu();
	    $this->view->ponozky = $this->model->Ponozky();
	    $this->view->tricka = $this->model->Tricka();
	    $this->view->vyber_podzavodu = $this->model->VyberPodzavodu();
	    $this->view->Render('prihlaska/index');  
	}
	
	
	
    }	 
?>
