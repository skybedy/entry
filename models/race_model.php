<?php

class Race_Model extends Model{
   
    
	function __construct() {
		parent::__construct();
	
			
   }
    
	public function VypisPrihlasek(){
		$data = false;
		$sth =  $this->db->prepare("SELECT * FROM zavod_bolaticka_tricitka_2013 ORDER BY vs");
		$sth->setFetchMode(PDO::FETCH_OBJ);
		$sth->execute();
		if($sth->rowCount()){
			$data =  $sth->fetchAll();
		}
		return $data;
	}
	
	public function ZmenaUdaju(){
		$sql = "UPDATE zavod_bolaticka_tricitka_2013 SET startovne = '{$_POST['startovne']}',velikost_tricka = '{$_POST['tricko']}',zaplaceno = '{$_POST['platba']}'  WHERE id = '{$_POST['id']}'";
		$sth = $this->db->prepare($sql);
		$sth->execute();
		//echo $this->VypisPrihlasek();
	}
	
	 
	
	
}