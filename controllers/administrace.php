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
		$this->view->IdZavodu = Session::get('race_id');
		$this->view->RokZavodu = Session::get('race_year');

	    $this->model->ExportExcelJednotlivci();
		//$homepage = file_get_contents('http://localhost:1312/export-to-excel?typ=jednotlivci&race_id='.Session::get('race_id').'&race_year='.YEAR);
		//header('Location: http://entry.timechip.loc/public/temp/test.xlsx');


	}

	public function export_excel_tymy(){
	    $this->model->ExportExcelTymy();
	}

}
