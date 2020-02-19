<?php
class Administrace extends Controller{

	function __construct() {
		Session::init();
		parent::__construct();
		$this->view->js = Array('administrace/js/default_270318.js'); 
		require 'util/auth.php';
		New Auth(); 
		$this->view->h1 = 'Administrace';
	}
	
	public function Index(){
            $this->view->VypisPrihlasek = $this->model->Index();
            $this->view->pocet_podzavodu = $this->model->pocet_podzavodu;
            $this->view->IdZavodu = $this->model->IdZavodu;
            $this->view->CategoryList = $this->model->CategoryList();
            $this->view->Tricka = $this->model->Tricka();
            $this->view->typ_zavodnika = $this->model->typ_zavodnika;
            $this->view->Render('administrace/index');
	}
	
	
	
	public function zmena_udaju(){
	    $this->model->ZmenaUdaju();
	    header('Location: '.URL.'administrace');
	}
	public function zmena_udaju_tymu_jednotlivce(){
	    $this->model->ZmenaUdajuTymuJednotlivce();
	    header('Location: '.URL.'administrace');
	}
	
	public function zmena_udaju_tymy(){
	    $this->model->ZmenaUdajuTymy();
	    header('Location: '.URL.'administrace');
	}
	
	
	
	public function export_excel_jednotlivci(){
	    $this->model->ExportExcelJednotlivci();
	}
	
	public function export_excel_tymy(){
	    $this->model->ExportExcelTymy();
	}
	
}	
 