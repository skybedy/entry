<?php
class Index_Model extends Model{
	public $IdZavodu;
	public $RokZavodu;
	public $sqlprihlasky;
	public $sqlzavody;
	
    function __construct() {
	parent::__construct();
	$this->IdZavodu = Session::get('race_id');
	$this->sqlzavody = 'zavody_'.YEAR;
	$this->sqlprihlasky = 'prihlasky_'.YEAR; 
    }

    public function Index(){
	$data = false;
	$sql = "SELECT
			$this->sqlzavody.nazev_zavodu,
			DATE_FORMAT($this->sqlzavody.datum_zavodu,'%e.%c.%Y') AS datum_zavodu,
			DATE_FORMAT($this->sqlzavody.datum_zavodu,'%Y') AS rok_zavodu,
                        DATE_FORMAT($this->sqlzavody.datum_zavodu,'%e') AS den_zavodu,
			$this->sqlzavody.misto_zavodu,
			$this->sqlzavody.web,
			DATE_FORMAT($this->sqlprihlasky.konec_prihlasek,'%e.%c.%Y') AS konec_prihlasek,
			$this->sqlprihlasky.poradatel,
			$this->sqlprihlasky.mail,
			$this->sqlprihlasky.telefon,
                        $this->sqlzavody.id_zavodu
		FROM $this->sqlzavody,$this->sqlprihlasky 
		WHERE
			$this->sqlzavody.id_zavodu = :id_zavodu AND $this->sqlprihlasky.id_zavodu = $this->sqlzavody.id_zavodu";
			//echo $sql;
			$sth = $this->db->prepare($sql);
	$sth->execute(Array(
	    'id_zavodu' => $this->IdZavodu
	));
	if($sth->rowCount()){
	    $data = $sth->fetchAll();
	}
	return $data;
    }
}
?>