<?php
    class Race extends Controller{
	function __construct() {
	    Session::init();
	    parent::__construct();
		$this->view->js = Array('race/js/default.js');
	}
    
	function RaceOption($race_id){
	    if($race_id){
		Session::set('race_id',$race_id);
		header('Location: '.URL);
	    }
	    else{
		Session::destroy();
		header('Location: '.URL);
	    }
	}
}
?>