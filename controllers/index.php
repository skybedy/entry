<?php

class Index extends Controller{
    function __construct() {
	parent::__construct();
	Session::init();	
	$this->view->h1 = 'Údaje o závodu'; 
	if (Session::get('race_id') == false){
	    $this->view->h1 = 'Přihlášky'; 
	}
	
    }
	 
    public function Index(){
	$this->view->Index = $this->model->Index(); 
	$this->view->Render('index/index');  
    }
 }
 ?>