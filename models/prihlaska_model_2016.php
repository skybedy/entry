<?php
class Prihlaska_Model extends Model{
	public $sqlzavody;
	public $sqlprihlasky;
	public  $sqlpodzavody;
	public $NazevZavodu;
	public $kod_zavodu;
	public $IdZavodu;
	private $cislo_uctu;
	private $iban;
	private $swift;
	private $nazev_banky;
	public $udaje;
	private $vs;
	private $startovne_z_db;
	private $startovne_z_db_kc;
	private $startovne_z_db_eu;
	private $startovne_eu;
	private $startovne_kc;
	private $startovne;
	private $startovne_2;
	private $konec_prihlasek;
	private $mena;
	private $poradatel;
	private $telefon_na_poradatele;
	private $mail_na_poradatele;
	public  $mail_na_zavodnika;
	private $kategorie;
	private $kod_kategorie;
	private $poradi_podzavodu;
	private $kategorie_2;
	private $kod_kategorie_2;
	private $poradi_podzavodu_2;
	public $RokZavodu;
	private $vek;
	private $typ_prihlasky;
	private $pohlavi;
	private $pocet_podzavodu;
	private $sqlprihlaskyjednotlivci;
	private $sqlprihlaskytymy;
	private $sqlkategorie;
	private $sqlzavod;
	private $vychozi_startovne;
	
	
	//select bez hodnoty je false, ale je definovaný, checbox není ani definovaný, musí se použít isset
	
	function __construct() {
	    parent::__construct();
	    $this->IdZavodu = Session::get('race_id');
	    if(Session::get('poradi_podzavodu')){
		$this->poradi_podzavodu = Session::get('poradi_podzavodu'); 	
	    }
	    $data = false;
	    $this->sqlzavody = 'zavody_'.YEAR;
	    $sql1 = "SELECT *,DATE_FORMAT(datum_zavodu,'%Y') AS rok_zavodu FROM $this->sqlzavody WHERE id_zavodu = :id_zavodu";
	    $sth = $this->db->prepare($sql1);
	    $sth->execute(array(':id_zavodu' => $this->IdZavodu));
	    if($sth->rowCount()){
		$data =  $sth->fetchAll();
		foreach($data as $val){
		    $this->NazevZavodu = $val['nazev_zavodu'];
		    $this->kod_zavodu = $val['kod_zavodu'];
		    $this->RokZavodu = $val['rok_zavodu'];
		    $this->pocet_podzavodu = $val['pocet_podzavodu']; 
		    $this->kod_zavodu = $val['kod_zavodu']; 
		}
		$this->sqlprihlasky = 'prihlasky_'.$this->kod_zavodu.'_'.YEAR;
		$this->sqlprihlaskyjednotlivci = 'prihlasky_jednotlivci_'.YEAR;
		$this->sqlprihlaskytymy = 'prihlasky_tymy_'.YEAR;
		$this->sqlkategorie = 'kategorie_'.YEAR;
		$this->sqlpodzavody = 'podzavody_'.YEAR;
		$this->sqlzavod = 'zavod_'.$this->kod_zavodu.'_'.YEAR;
	    }
	    $this->Pohlavi();
	}
	
	
	public function xhrFinish(){
	    //tady ještě zkontrolovat, jestli se ty SESSIONS nedají udělat nějak jinak
	    $str = '';
	    if(Session::get('token') == true){
		(Session::get('udaje') == true) ? ($this->udaje = unserialize(Session::get('udaje'))) : ($this->udaje = false);
		if($this->udaje['typ_prihlasky'] == 1 OR $this->udaje['typ_prihlasky'] == 4){
		    $this->mail_na_zavodnika = $this->udaje['mail'];
		}
		if($this->udaje['typ_prihlasky'] == 2){
		    $this->mail_na_zavodnika = $this->udaje['mail_tym'];
		}
		$str = false;
		$sql1 = "SELECT *,DATE_FORMAT(konec_prihlasek,'%e.%c.%Y') AS konec_prihlasek FROM prihlasky_".YEAR." WHERE id_zavodu = '$this->IdZavodu'";
		//echo $sql1;
		$sth1 = $this->db->prepare($sql1);
		$sth1->execute(array(':id_zavodu' => $this->IdZavodu));
		if($sth1->rowCount()){
		    $data1 =  $sth1->fetchObject();
		    $this->cislo_uctu = $data1->cislo_uctu;
		    $this->iban = $data1->iban;
		    $this->swift = $data1->swift;
		    $this->nazev_banky = $data1->nazev_banky;
		    $this->poradatel = $data1->poradatel;
		    $this->telefon_na_poradatele = $data1->telefon;
		    $this->mail_na_poradatele = $data1->mail;
		    $this->konec_prihlasek = $data1->konec_prihlasek;
		}
		$this->ZiskaniVS();
		//$this->VyberStartovneho();
		//$this->VypocetStartovneho();
		$this->StartovneZDB();
		$this->Startovne();
		$this->Vek();
		$this->TypPrihlasky();
		$this->VyberKategorie();
		$this->xhrSaveToDB($this->typ_prihlasky);
		return true;
	    }
	    else{
		return false;
	    }
	}

	
    private function TypPrihlasky(){
	switch($this->udaje['typ_prihlasky']){
	    case 1:
		$this->typ_prihlasky = 'jednotlivci';
	    break;
	    case 2:
		$this->typ_prihlasky = 'tymy';
	    break;
	    case 4: //enduro hobby
		$this->typ_prihlasky = 'jednotlivci';
	    break;
	}
    }
	
    
    //v případě 1 a 2 se bere typ z metody TpPrihlasky, která je volána xhr finisf, v případě 3 je typ_prihlášky  dodáván ručně v kontroleru
    public function xhrSaveToDB($typ_prihlasky){
	if($this->IdZavodu == 13 OR $this->IdZavodu == 500){
	    $tp = $typ_prihlasky;
	}
	else{
	   $tp = $this->udaje['typ_prihlasky']; 
	}
	
	switch($tp){
	    case 1:
		$this->xhrSaveToDBJednotlivci();
	    break;
	    case 2:
		$this->xhrSaveToDBTymy();
	    break;
	    case 3:
		$this->xhrSaveToDBEnduro();
	    break;
	    case 4: //Enduro hobby
		$this->xhrSaveToDBJednotlivci();
	    break;
	}
    }
    
    public function xhrOvereni(){
	switch($_POST['typ_prihlasky']){
	    case 1:
		return $this->xhrOvereniJednotlivci();
	    break;
	    case 2:
		return $this->xhrOvereniTymy();
	    break;
	    case 4:
		return $this->xhrOvereniHobbyEnduro();
	    break;
	}
    }

    private function Pohlavi(){
	$this->pohlavi = Array("M" => "Muž","Z" => "Žena","0" => "0");
    }

	
	
	
	
	
	
	
	
	
	
	
	
	
	
   /*
    * Ať to zas příště nehledám jako kokot, tak v případě typu závodu jako je Žilina, (tzn. různé typy formulářů na různé podzávody) se číslo podzávodu ukládá do Session a je posléze
    * přístupné přes $this->poradí_podzavodu... v pripade, kdy se jedna  stejne formulare, tak je poradi podzavodu pristupne pres příchozí form a je serializovaný do $this->udaje['poradi_podzavodu']
    */

    
    
	public function xhrOvereniJednotlivci(){
	    
	    Session::set('udaje',serialize($_POST));
	    $str = false;
	    $str .= '<div class="container">';
	    $str .= '<table class="table table-hover">';
	    $str .= (isset($_POST['jmeno_1']) && isset($_POST['prijmeni_1'])) ? ('<tr><td class="align_left">Jméno a příjmení</td><td class="align_right">'.$_POST['jmeno_1'].' '.$_POST['prijmeni_1'].'</td></tr>') : ('');
	    $str .= (isset($_POST['pohlavi'])) ? ('<tr><td class="align_left">Pohlaví</td><td class="align_right">'.$this->pohlavi[$_POST['pohlavi']].'</td></tr>') : ('');
	    $str .= (isset($_POST['den_narozeni']) && isset($_POST['mesic_narozeni']) && isset($_POST['rok_narozeni'])) ? ('<tr><td class="align_left">Datum narození</td><td class="align_right">'.$_POST['den_narozeni'].'.'.$_POST['mesic_narozeni'].'.'.$_POST['rok_narozeni'].'</td></tr>') : ('');
	    $str .= (isset($_POST['prislusnost'])) ? ('<tr><td class="align_left">Tým nebo bydliště</td><td class="align_right">'.$_POST['prislusnost'].'</td></tr>') : ('');
	    $str .= (isset($_POST['stat'])) ? ('<tr><td class="align_left">Stát</td><td class="align_right">'.$_POST['stat'].'</td></tr>') : ('');
	    $str .= (isset($_POST['mail'])) ? ('<tr><td class="align_left">E-mail</td><td class="align_right">'.$_POST['mail'].'</td></tr>') : ('');
	    $str .= (isset($_POST['telefon_1'])) ? ('<tr><td class="align_left">Telefon</td><td class="align_right">'.$_POST['telefon_1'].'</td></tr>') : ('');
	    $str .= (!empty($_POST['telefon_2'])) ? ('<tr><td class="align_left">Alternativní telefon</td><td class="align_right">'.$_POST['telefon_2'].'</td></tr>') : ('');
	    $str .= (!empty($_POST['tricko'])) ? ('<tr><td class="align_left">Velikost trička</td><td class="align_right">'.$_POST['tricko'].'</td></tr>') : ('');
	    $str .= (!empty($_POST['ponozky'])) ? ('<tr><td class="align_left">Velikost ponožek</td><td class="align_right">'.$_POST['ponozky'].'</td></tr>') : ('');
	    $str .= (!empty($_POST['vzkaz_poradateli'])) ? ('<tr><td class="align_left">Vzkaz pořadateli</td><td class="align_right">'.$_POST['vzkaz_poradateli'].'</td></tr>') : ('');
	    $str .= '</table>';
	    $str .= $this->xhrOvereniForm();
	    return $str;
	}
	
	
	public function xhrOvereniHobbyEnduro(){
	    
	Session::set('udaje',serialize($_POST));
	$str = false;
	$str .= '<div class="container">';
	$str .= '<table class="table table-hover">';
	$str .= (isset($_POST['ids'])) ? ('<tr><td class="align_left">Startovní číslo</td><td class="align_right">'.$_POST['ids'].'</td></tr>') : ('');
	$str .= (isset($_POST['jmeno_1']) && isset($_POST['prijmeni_1'])) ? ('<tr><td class="align_left">Jméno a příjmení</td><td class="align_right">'.$_POST['jmeno_1'].' '.$_POST['prijmeni_1'].'</td></tr>') : ('');
	$str .= (isset($_POST['pohlavi'])) ? ('<tr><td class="align_left">Pohlaví</td><td class="align_right">'.$this->pohlavi[$_POST['pohlavi']].'</td></tr>') : ('');
	$str .= (isset($_POST['den_narozeni']) && isset($_POST['mesic_narozeni']) && isset($_POST['rok_narozeni'])) ? ('<tr><td class="align_left">Datum narození</td><td class="align_right">'.$_POST['den_narozeni'].'.'.$_POST['mesic_narozeni'].'.'.$_POST['rok_narozeni'].'</td></tr>') : ('');
	$str .= (isset($_POST['prislusnost'])) ? ('<tr><td class="align_left">Tým nebo bydliště</td><td class="align_right">'.$_POST['prislusnost'].'</td></tr>') : ('');
	$str .= (isset($_POST['stat'])) ? ('<tr><td class="align_left">Stát</td><td class="align_right">'.$_POST['stat'].'</td></tr>') : ('');
	$str .= (isset($_POST['mail'])) ? ('<tr><td class="align_left">E-mail</td><td class="align_right">'.$_POST['mail'].'</td></tr>') : ('');
	$str .= (isset($_POST['telefon_1'])) ? ('<tr><td class="align_left">Telefon</td><td class="align_right">'.$_POST['telefon_1'].'</td></tr>') : ('');
	$str .= (!empty($_POST['telefon_2'])) ? ('<tr><td class="align_left">Alternativní telefon</td><td class="align_right">'.$_POST['telefon_2'].'</td></tr>') : ('');
	$str .= (!empty($_POST['tricko'])) ? ('<tr><td class="align_left">Velikost trička</td><td class="align_right">'.$_POST['tricko'].'</td></tr>') : ('');
	$str .= (!empty($_POST['ponozky'])) ? ('<tr><td class="align_left">Velikost ponožek</td><td class="align_right">'.$_POST['ponozky'].'</td></tr>') : ('');
	$str .= (!empty($_POST['vzkaz_poradateli'])) ? ('<tr><td class="align_left">Vzkaz pořadateli</td><td class="align_right">'.$_POST['vzkaz_poradateli'].'</td></tr>') : ('');
	$str .= '</table>';
	
	$str .= '<div class="panel contact">';
	$str .= '<div class="panel-body padding-bottom-none">';    
	$str .= '<ul class="list-unstyl">';
	$str .= '<li>zkontrolujte si hlavně e-mail, pokud bude uveden špatně, nepřijdou vám platební informace</li>';
	$str .= '<li>neuvádějte zdrobnělé nebo jiné tvary svého jména než máte v osobních dokladech, v opačném případě může být přihláška smazána</li>';
	$str .= '<li>v případě, že neuvádíte název týmu, uveďte pouze místo bydliště (např. Ostrava), neuvádějte ulici, ani č.p, ani psč</li>';
	$str .= '<li>telefonní číslo uvádějte pokud možno s předčíslím, tzn. např. +420, +421, atd.</li>';
	$str .= '</ul>';
	$str .= '</div></div>';
	$sql1 = "SELECT ids FROM $this->sqlprihlaskyjednotlivci WHERE id_zavodu = :id_zavodu AND ids = :ids";
	$sth1 = $this->db->prepare($sql1);
	$sth1->execute(Array('id_zavodu' => $this->IdZavodu,'ids' => $_POST['ids']));
	if($sth1->rowCount()){
	    $dbdata1 = $sth1->fetchObject();
	    $ids = $dbdata1->ids;
	    $str .= '<div class="panel contact"><div class="panel-body">';
	    $str .= 'Startovní číslo <b>'.$ids.'</b> už je <a style="text-decoration:underline" target="_blank" href="'.URL.'prihlaska/vypis-prihlasek">obsazené</a>, je třeba si vybrat jiné.';
	    $str .= '</div></div>';
	    $str .= '<form action="'.URL.'prihlaska/xhrRepair" method="post" id="opravit_udaje" class="kontrolni_tabulka">';
	    $str .= '<div class="form-group">'; 
	    $str .= '<button type="submit" class="form-control btn btn-danger">Opravit údaje - zvolte v případě, že údaje potřebujete opravit</button>';
	    $str .= '</div>';
	    $str .= '</form>';

	}
	else{
	    $str .= '<form action="'.URL.'prihlaska/xhrRepair" method="post" id="opravit_udaje" class="kontrolni_tabulka">';
	    $str .= '<div class="form-group">'; 
	    $str .= '<button type="submit" class="form-control btn btn-danger">Opravit údaje - zvolte v případě, že údaje potřebujete opravit</button>';
	    $str .= '</div>';
	    $str .= '</form>';
	    $str .= '<form action="'.URL.'prihlaska/xhrFinish/'.$this->IdZavodu.'" method="post" id="odeslat_prihlasku" class="form">';
	    $str .= '<div class="form-group">'; 
	    $str .= '<button type="submit" class="form-control btn btn-success">Odeslat přihlášku - zvolte pouze v případě, že údaje jsou OK a můžete je odeslat</button>';
	    $str .= '</div>';
	    $str .= '</form>';
	}
	
	
	
	$str .= '</div>';
	
	
	
	
	
	
	return $str;
	}
	
	
	
	
	
	public function xhrOvereniTymy(){
	    Session::set('udaje',serialize($_POST));
	    $str = false;
	    $str .= '<div class="container">';
	    $str .= '<table class="table table-hover">';
	    $str .= '<thead><th colspan="2">Tým</th></thead>';
	    $str .= (isset($_POST['nazev_tymu'])) ? ('<tr><td class="align_left">Název týmu</td><td class="align_right">'.$_POST['nazev_tymu'].'</td></tr>') : ('');
	    $str .= (isset($_POST['stat_tym'])) ? ('<tr><td class="align_left">Stát</td><td class="align_right">'.$_POST['stat_tym'].'</td></tr>') : ('');
	    $str .= (isset($_POST['mail_tym'])) ? ('<tr><td class="align_left">E-mail:</td><td class="align_right">'.$_POST['mail_tym'].'</td></tr>') : ('');
	    $str .= (isset($_POST['telefon_1_tym'])) ? ('<tr><td class="align_left">Telefon:</td><td class="align_right">'.$_POST['telefon_1_tym'].'</td></tr>') : ('');
	    $str .= (isset($_POST['telefon_2_tym'])) ? ('<tr><td class="align_left">Alternativní telefon :</td><td class="align_right">'.$_POST['telefon_2_tym'].'</td></tr>') : ('');
	    $str .= (isset($_POST['id_kategorie'])) ? ('<tr><td class="align_left">Kategorie</td><td class="align_right">'.$this->VyberKategoriePodleId($_POST['id_kategorie']).'</td></tr>') : ('');
	    for($i=1;$i<=$_POST['pocet_clenu'];$i++){
		$str .= '<thead><th colspan="2">Závodník '.$i.'</th></thead>';
		$str .= (isset($_POST['jmeno_1_'.$i]) && isset($_POST['prijmeni_1_'.$i])) ? ('<tr><td class="align_left">Jméno a příjmení</td><td class="align_right">'.$_POST['jmeno_1_'.$i].' '.$_POST['prijmeni_1_'.$i].'</td></tr>') : ('');
		$str .= (isset($_POST['pohlavi_'.$i])) ? ('<tr><td class="align_left">Pohlaví</td><td class="align_right">'.$this->pohlavi[$_POST['pohlavi_'.$i]].'</td></tr>') : ('');
		$str .= (isset($_POST['den_narozeni_'.$i]) && isset($_POST['mesic_narozeni_'.$i]) && isset($_POST['rok_narozeni_'.$i])) ? ('<tr><td class="align_left">Datum narození</td><td class="align_right">'.$_POST['den_narozeni_'.$i].'.'.$_POST['mesic_narozeni_'.$i].'.'.$_POST['rok_narozeni_'.$i].'</td></tr>') : ('');
		$str .= (isset($_POST['prislusnost_'.$i])) ? ('<tr><td class="align_left">Tým/bydliště</td><td class="align_right">'.$_POST['prislusnost_'.$i].'</td></tr>') : ('');
		$str .= (isset($_POST['stat_'.$i])) ? ('<tr><td class="align_left">Stát</td><td class="align_right">'.$_POST['stat_'.$i].'</td></tr>') : ('');
		$str .= (isset($_POST['mail_'.$i])) ? ('<tr><td class="align_left">E-mail</td><td class="align_right">'.$_POST['mail_'.$i].'</td></tr>') : ('');
		$str .= (isset($_POST['telefon_1_'.$i])) ? ('<tr><td class="align_left">Telefon</td><td class="align_right">'.$_POST['telefon_1_'.$i].'</td></tr>') : ('');
		$str .= (!empty($_POST['telefon_2_'.$i])) ? ('<tr><td class="align_left">Alternativní telefon</td><td class="align_right">'.$_POST['telefon_2_'.$i].'</td></tr>') : ('');
		$str .= (!empty($_POST['tricko_'.$i])) ? ('<tr><td class="align_left">Velikost trička</td><td class="align_right">'.$_POST['tricko_'.$i].'</td></tr>') : ('');
		$str .= (!empty($_POST['ponozky_'.$i])) ? ('<tr><td class="align_left">Velikost ponožek</td><td class="align_right">'.$_POST['ponozky_'.$i].'</td></tr>') : ('');


	    }
	    $str .= '</table>';
	    $str .= $this->xhrOvereniForm();

	    return $str;
	}
	
	
	
    private function xhrOvereniForm(){
	$str = '';
	$str .= '<div class="panel contact">';
	$str .= '<div class="panel-body padding-bottom-none">';    
	$str .= '<ul class="list-unstyl">';
	$str .= '<li>zkontrolujte si hlavně e-mail, pokud bude uveden špatně, nepřijdou vám platební informace</li>';
	$str .= '<li>neuvádějte zdrobnělé nebo jiné tvary svého jména než máte v osobních dokladech, v opačném případě může být přihláška smazána</li>';
	$str .= '<li>v případě, že neuvádíte název týmu, uveďte pouze místo bydliště (např. Ostrava), neuvádějte ulici, ani č.p, ani psč</li>';
	$str .= '<li>telefonní číslo uvádějte pokud možno s předčíslím, tzn. např. +420, +421, atd.</li>';
	$str .= '</ul>';
	$str .= '</div></div>';
	$str .= '<form action="'.URL.'prihlaska/xhrRepair" method="post" id="opravit_udaje" class="kontrolni_tabulka">';
	$str .= '<div class="form-group">'; 
	$str .= '<button type="submit" class="form-control btn btn-danger">Opravit údaje - zvolte v případě, že údaje potřebujete opravit</button>';
	$str .= '</div>';
	$str .= '</form>';
	$str .= '<form action="'.URL.'prihlaska/xhrFinish/'.$this->IdZavodu.'" method="post" id="odeslat_prihlasku" class="form">';
	$str .= '<div class="form-group">'; 
	$str .= '<button type="submit" class="form-control btn btn-success">Odeslat přihlášku - zvolte pouze v případě, že údaje jsou OK a můžete je odeslat</button>';
	$str .= '</div>';
	$str .= '</form>';
	$str .= '</div>';//konec containeru
	return $str;
    }
	
    
    public function VolneIdo(){
	$str = '';
	$prvni_cislo = 140;
	$sql1 = "SELECT MAX(ido) AS max_ido FROM osoby";
	$sth1 = $this->db->prepare($sql1);
	$sth1->execute();
	$dbdata1 = $sth1->fetchObject(); //zatím nepoužito
	$k = 1;
	for($i=$prvni_cislo;$i<=$dbdata1->max_ido;$i++){
	    $sql2 = "SELECT ido FROM osoby WHERE ido = :i";
	    $sth2 = $this->db->prepare($sql2);
	    $sth2->execute(Array(':i' => $i));
	    if(!$sth2->rowCount()){
		//$str .= ($i).',';
		$str .= ($i);
		//$k++;
		return $str;
		exit();
	    }
	}
	//$str .= $k;
    }
    


    private function Hlasky($typ_hlasky){
	$str = '';
	$dovetek = 'V případě nejasností nás kontaktujte prostřednictvím e-mailu na <a href="mailto://info@timechip.cz">info@timechip.cz</a>, nebo telefonicky na číslo +420 776 131313.<br />';
	$dovetek .= 'Zpět do formuláře se můžete vrátit <a id="navrat_do_formulare" href="#">zde.</a>'; 
	switch($typ_hlasky){
	    case 'osoba':
		$str .= 'Osoba se neuložila';
	    break;
	    case 'chybejici_etapa':
		$str .= 'Přihláška nemůže být uložena, nebyl zadán den závodění';
	    break;
	    case 'duplicitni_prihlaseni':
		$str .= 'Není možné se přihlásit v rámci jednoho závodu 2x do stejné kategorie.<br />';
		$str .= $dovetek;
	    break;
	    case 'uspesne_prihlaseni':
	    $str .= 'Děkujeme za přihlášení, na vaši e-mailovou adresu byla odeslána zpráva s dalšími informacemi.<br />
V případě, že vám e-mail nepřijde (zkontrolujte si i složku s nevyžádanou poštou), nenajdete se ve výpisu přihlášek, nebo narazíte na jiný problém, kontaktujte nás prosím buď prostřednictvím e-mailu na <a href="mailto:timechip@timechip.cz">timechip@timechip.cz</a>, nebo telefonicky
na +420 776131313.';
	    break;
	    
	
	}
	return $str;
    } 
    
    private function KontrolaDuplicityEnduro($etapa){
	$sql1 = "SELECT * FROM $this->sqlzavod WHERE ido = {$_GET['ido']} AND id_kategorie = {$_GET['id_kategorie']} AND id_etapy = $etapa";
	$sth1 = $this->db->prepare($sql1);
	$sth1->execute();
	if($sth1->rowCount()){
	    return $sth1->fetch();
	}
    }
    
    
    
    private function xhrSaveToDBEnduro(){
	$str = Array(); 
	$str['uspesne_prihlaseni'] = false;
	if(isset($_GET['etapa'])){
	    
	    
	    for($i=1;$i<=count($_GET['etapa']);$i++){
		if(count($_GET['etapa']) == 1){
		    $etapa = $_GET['etapa'];
		}
		else{
		    $etapa = $_GET['etapa'][$i-1]; 
		}
		
		if($this->KontrolaDuplicityEnduro($etapa)){
		    $str['hlaska'] =  $this->Hlasky('duplicitni_prihlaseni');
		}
		else{
		    ($_GET['ido'] == true) ? ($vlozeni['ido'] = $_GET['ido']) : ('');
		    ($_GET['race_number'] == true) ? ($vlozeni['ids'] = $_GET['race_number']) : ('');
		    ($_GET['race_number'] == true) ? ($vlozeni['ids_alias'] = $_GET['race_number']) : ('');
		    ($_GET['race_number'] == true) ? ($vlozeni['cip'] = $_GET['race_number']) : ('');
		    ($_GET['id_tymu'] == true) ? ($vlozeni['prislusnost'] = $_GET['id_tymu']) : ('');
		    ($_GET['id_tymu'] == true) ? ($vlozeni['id_tymu'] = $_GET['id_tymu']) : ('');
		    ($_GET['id_kategorie'] == true) ? ($vlozeni['id_kategorie'] = $_GET['id_kategorie']) : ('');
		    ($_GET['poradi_podzavodu'] == true) ? ($vlozeni['poradi_podzavodu'] = $_GET['poradi_podzavodu']) : ('');
		    ($_GET['zdravotni_pojistovna'] == true) ? ($vlozeni['zdravotni_pojistovna'] = $_GET['zdravotni_pojistovna']) : ('');
		    ($_GET['id_typu_licence'] == true) ? ($vlozeni['id_typu_licence'] = $_GET['id_typu_licence']) : ('');
		    ($_GET['cislo_licence'] == true) ? ($vlozeni['cislo_licence'] = $_GET['cislo_licence']) : ('');
		    ($_GET['id_2t4t'] == true) ? ($vlozeni['id_2t4t'] = $_GET['id_2t4t']) : ('');
		    ($_GET['id_motocyklu'] == true) ? ($vlozeni['id_motocyklu'] = $_GET['id_motocyklu']) : ('');
		    ($_GET['typ_motocyklu'] == true) ? ($vlozeni['typ_motocyklu'] = $_GET['typ_motocyklu']) : ('');
		    ($_GET['cislo_ramu'] == true) ? ($vlozeni['cislo_ramu'] = $_GET['cislo_ramu']) : ('');
		    ($_GET['objem_motoru'] == true) ? ($vlozeni['objem_motoru'] = $_GET['objem_motoru']) : ('');
		    ($_GET['pocet_valcu'] == true) ? ($vlozeni['pocet_valcu'] = $_GET['pocet_valcu']) : ('');
		    ($_GET['znacka_prilby'] == true) ? ($vlozeni['znacka_prilby'] = $_GET['znacka_prilby']) : ('');
		    ($_GET['homologace_prilby'] == true) ? ($vlozeni['homologace_prilby'] = $_GET['homologace_prilby']) : ('');
		    
		    $vlozeni['id_etapy'] = $etapa;
		    
		    
		    $sql1 = "INSERT INTO $this->sqlzavod (".implode(",",array_keys($vlozeni)).") VALUES ('".implode("','",$vlozeni)."')";
		    $sth1 = $this->db->prepare($sql1);
		    $sth1->execute();
		    if($sth1->rowCount()){
			$str['uspesne_prihlaseni'] = 1;
			$str['hlaska'] = $this->Hlasky('uspesne_prihlaseni');
			
		    }
		    else{
			//$str .= 'Nějaký problém s uložením - '.$sql1;
		    }

		}

	    }
	}
	else{
	    //$str .= $this->Hlasky('chybejici_etapa');
	}
	
	//mail  člověku přijde i když se třeba zkusí duplicitně přihlásít, což je špatně
	$this->MailZavodnikovi($_GET['mail']);
	$this->UpdateUdajuEnduro();
	$this->UpdateOsobyCiziZdroje();
	
	echo json_encode($str);
    }
    
    
    private function UpdateOsobyCiziZdroje(){
	
	($_GET['cislo_licence'] == '') ? ($cislo_licence = 'NULL') : ($cislo_licence = $_GET['cislo_licence']);
	($_GET['cislo_ramu'] == '') ? ($cislo_ramu = 'NULL') : ($cislo_ramu = $_GET['cislo_ramu']);

	$sql1 = "UPDATE osoby_cizi_zdroje SET kod_pojistovny =  '{$_GET['zdravotni_pojistovna']}',id_tymu = '{$_GET['id_tymu']}',id_typu_licence = '{$_GET['id_typu_licence']}',"
	. "cislo_licence = $cislo_licence,id_2t4t = '{$_GET['id_2t4t']}',id_motocyklu = '{$_GET['id_motocyklu']}',typ_motocyklu = '{$_GET['typ_motocyklu']}',"
	. "cislo_ramu = $cislo_ramu,objem_motoru = '{$_GET['objem_motoru']}',pocet_valcu = '{$_GET['pocet_valcu']}',znacka_prilby = '{$_GET['znacka_prilby']}',"
	. "homologace_prilby = '{$_GET['homologace_prilby']}' WHERE ido = '{$_GET['ido']}' AND id_serialu = 1 AND rok_serialu = $this->RokZavodu";
	$sth1 = $this->db->prepare($sql1);
	$sth1->execute();
	//echo $sql1;
    }
    
    
    
    
    private function UpdateUdajuEnduro(){
	$str = '';
	$den_update = false;
	$mesic_update = false;
	$ulice_update = false;
	$ulice_update = false;
	$obec_update = false;
	$zip_update = false;
	$stat_update = false;
	$telefon_update = false;
	$pohlavi_update = false;
	
	$sql2 = "UPDATE osoby SET ";
	$sql1 = "SELECT * FROM osoby WHERE ido = :ido";
	$sth1 = $this->db->prepare($sql1);
	$sth1->execute(Array(':ido' => $_GET['ido']));
	if($sth1->rowCount()){
	    $dbdata1 = $sth1->fetchObject();
	    if(!$dbdata1->den){
		$den_update = 'den = '.$_GET['den_narozeni'].',';
		$sql2 .= $den_update;
	    }
	    if(!$dbdata1->mesic){
		$mesic_update = 'mesic = '.$_GET['mesic_narozeni'].',';
		$sql2 .= $mesic_update;
	    }
	    
	    if(!$dbdata1->ulice){
		$ulice_update = "ulice = '".$_GET['ulice']."',";
		$sql2 .= $ulice_update;
	    }
	    if(!$dbdata1->obec){
		$obec_update = "obec = '".$_GET['obec']."',";
		$sql2 .= $obec_update;
	    }
	    if(!$dbdata1->zip){
		$zip_update = "zip = '".$_GET['zip']."',";
		$sql2 .= $zip_update;
	    }
	    if(!$dbdata1->psc){
		$stat_update = "psc = '".$_GET['stat']."',";
		$sql2 .= $stat_update;
	    }
	    if(!$dbdata1->telefon){
		$telefon_update = "telefon = '".$_GET['telefon']."',";
		$sql2 .= $telefon_update;
	    }
	    if(!$dbdata1->pohlavi){
		$pohlavi_update = "pohlavi = '".$_GET['pohlavi']."',";
		$sql2 .= $pohlavi_update;
	    }
	
	    if($den_update OR $mesic_update OR $ulice_update OR $obec_update OR $zip_update OR $stat_update OR $telefon_update OR $pohlavi_update){
		$sql2 .= "zdroj = 'update_prihlaseni_do_zavodu_cams' WHERE ido = {$_GET['ido']}";
	
		$sth2 = $this->db->prepare($sql2);
		$sth2->execute();
		if($sth2->rowCount()){
		    $str .= 'Úprava provedena '.$sql2;
		    //echo 'jo';
		}
		else{
		    $str .= 'Nejaký problem s UPDATE osoby - '.$sql2;
		    //echo 'ne';
		}
	    }
	}
	//echo $sql2; 
    }
	
    
    
    
    
    
    private function StartNumberInsert($ido){
	// ve chvíli programování použito číslo 1, což je jakoby Cross Country, což je provizorka
	//správně by mělo být k závodu v db přiřazeno id seriálu, pokud je nějakého seriálu součástí a s tím ID tady pracovat ... Maňana
	$id_serialu = 1;
	$sql1 = "SELECT * FROM startovni_cisla WHERE ido = $ido AND id_serialu = :id_serialu";
	$sth1 = $this->db->prepare($sql1);
	$sth1->execute(Array(':id_serialu' => $id_serialu));
	if($sth1->rowCount()){
	    return 'uz tam je';
	    //exit();
	}
	else{
	    $sql2 = "INSERT INTO startovni_cisla (ido,startovni_cislo,id_serialu) VALUES ('$ido','{$_GET['race_number']}','$id_serialu')";
	    $sth2 = $this->db->prepare($sql2);
	    $sth2->execute();
	    if($sth2->rowCount()){
		echo 'Startovní číslo vloženo do centrální DB';
	    }
	    else{
		echo 'Nějaký problém s vložením startovního čísla do centrální DB - '.$sql2;
	    }
	}

	
    }
    
    
    
    
    private function OsobaInsert(){
	$vlozeni['ido'] = $this->VolneIdo();
	($_GET['jmeno_1'] == true) ? ($vlozeni['jmeno'] = $_GET['jmeno_1']) : ('');
	($_GET['jmeno_1'] == true) ? ($vlozeni['jmeno_bez_diakritiky'] =  $this->RedukceDiakritiky($_GET['jmeno_1'])) : ('');
	($_GET['prijmeni_1'] == true) ? ($vlozeni['prijmeni'] = $_GET['prijmeni_1']) : ('');
	($_GET['prijmeni_1'] == true) ? ($vlozeni['prijmeni_bez_diakritiky'] =  $this->RedukceDiakritiky($_GET['prijmeni_1'])) : ('');
	($_GET['pohlavi'] == true) ? ($vlozeni['pohlavi'] = $_GET['pohlavi']) : ('');
	($_GET['den_narozeni'] == true) ? ($vlozeni['den'] = $_GET['den_narozeni']) : ('');
	($_GET['mesic_narozeni'] == true) ? ($vlozeni['mesic'] = $_GET['mesic_narozeni']) : ('');
	($_GET['rok_narozeni'] == true) ? ($vlozeni['rocnik'] = $_GET['rok_narozeni']) : ('');
	($_GET['ulice'] == true) ? ($vlozeni['ulice'] = $_GET['ulice']) : ('');
	($_GET['obec'] == true) ? ($vlozeni['obec'] = $_GET['obec']) : ('');
	($_GET['zip'] == true) ? ($vlozeni['zip'] = $_GET['zip']) : ('');
	($_GET['stat'] == true) ? ($vlozeni['psc'] = $_GET['stat']) : ('');
	($_GET['mail'] == true) ? ($vlozeni['mail'] = $_GET['mail']) : ('');
	($_GET['telefon'] == true) ? ($vlozeni['telefon'] = $_GET['telefon']) : ('');
	$sql1 = "INSERT INTO osoby (".implode(",",array_keys($vlozeni)).",datum_vlozeni) VALUES ('".implode("','",$vlozeni)."',NOW())";
	//echo $sql1;
	$sth1 = $this->db->prepare($sql1);
	$sth1->execute();
	if($sth1->rowCount()){
	    return $this->db->lastInsertId();
	}
	else{
	    return false;
	}
    }
    

    private function xhrSaveToDBJednotlivci(){
	
	
	
	$str = false;
	$vlozeni = Array();
	$vlozeni['id_zavodu'] = $this->IdZavodu;
	(isset($this->vychozi_startovne)) ? ($vlozeni['startovne'] = $this->vychozi_startovne) : ('');
	//(isset($this->mena)) ? ($vlozeni['mena'] = $this->mena) : ('');
	$vlozeni['mena'] = $this->mena;
	(isset($this->udaje['ids'])) ? ($vlozeni['ids'] = $this->udaje['ids']) : ('');
	(isset($this->udaje['jmeno_1'])) ? ($vlozeni['jmeno_1'] = $this->udaje['jmeno_1']) : ('');
	(isset($this->udaje['prijmeni_1'])) ? ($vlozeni['prijmeni_1'] = $this->udaje['prijmeni_1']) : ('');
	(isset($this->udaje['prislusnost'])) ? ($vlozeni['prislusnost'] = $this->udaje['prislusnost']) : ('');
	(isset($this->udaje['skola'])) ? ($vlozeni['skola'] = $this->udaje['skola']) : ('');
	(isset($this->udaje['pohlavi'])) ? ($vlozeni['pohlavi'] = $this->udaje['pohlavi']) : ('');
	(isset($this->udaje['stat'])) ? ($vlozeni['stat'] = $this->udaje['stat']) : ('');
	if(isset($this->udaje['den_narozeni']) && isset($this->udaje['mesic_narozeni']) && isset($this->udaje['rok_narozeni'])){
	    $vlozeni['datum_narozeni'] = $this->udaje['rok_narozeni'].'-'.$this->udaje['mesic_narozeni'].'-'.$this->udaje['den_narozeni'];
	}
	(isset($this->udaje['mail'])) ? ($vlozeni['mail'] = $this->udaje['mail']) : ('');
	(isset($this->udaje['telefon_1'])) ? ($vlozeni['telefon_1'] = $this->udaje['telefon_1']) : ('');	
	(isset($this->udaje['telefon_2'])) ? ($vlozeni['telefon_2'] = $this->udaje['telefon_2']) : ('');
	
	
	//pokud je dáno poradi podzavodu staticky formuarem, tak se apukije první varanta, pokud ne, tak poradí podzávodu se vybírá dynamicky v kategoriích (prajzák) a pozužívá se druhá varanta
	(isset($this->udaje['poradi_podzavodu'])) ? ($vlozeni['poradi_podzavodu'] = $this->udaje['poradi_podzavodu']) : ('');
	if($this->poradi_podzavodu){
	    $vlozeni['poradi_podzavodu'] = $this->poradi_podzavodu;
	}
	
	(isset($this->id_kategorie)) ? ($vlozeni['id_kategorie'] = $this->id_kategorie) : ('');
	(isset($this->udaje['tricko'])) ? ($vlozeni['tricko'] = $this->udaje['tricko']) : ('');	
	(isset($this->udaje['ponozky'])) ? ($vlozeni['ponozky'] = $this->udaje['ponozky']) : ('');	
	(isset($this->udaje['vzkaz'])) ? ($vlozeni['vzkaz'] = $this->udaje['vzkaz']) : ('');
	(isset($this->startovne)) ? ($vlozeni['startovne'] = $this->startovne) : ('');
	(isset($this->udaje['kategorie_2'])) ? ($vlozeni['kategorie_2'] = $this->udaje['kategorie_2']) : ('');
	(isset($this->udaje['jidlo'])) ? ($vlozeni['jidlo'] = $this->udaje['jidlo']) : ('');
	(isset($this->udaje['choice_1'])) ? ($vlozeni['choice_1'] = $this->udaje['choice_1']) : ('');
	(isset($this->udaje['choice_2'])) ? ($vlozeni['choice_2'] = $this->udaje['choice_2']) : ('');
	(isset($this->udaje['zaplaceno'])) ? ($vlozeni['zaplaceno'] = $this->udaje['zaplaceno']) : ('');
	(isset($this->udaje['vzkaz'])) ? ($vlozeni['vzkaz'] = $this->udaje['vzkaz']) : ('');
	(isset($this->udaje['dalsi_udaje_1'])) ? ($vlozeni['dalsi_udaje_1'] = $this->udaje['dalsi_udaje_1']) : ('');	
	(isset($this->udaje['dalsi_udaje_2'])) ? ($vlozeni['dalsi_udaje_2'] = $this->udaje['dalsi_udaje_2']) : ('');
	(isset($this->udaje['dalsi_udaje_3'])) ? ($vlozeni['dalsi_udaje_3'] = $this->udaje['dalsi_udaje_3']) : ('');
	(isset($this->udaje['dalsi_udaje_4'])) ? ($vlozeni['dalsi_udaje_4'] = $this->udaje['dalsi_udaje_4']) : ('');
	(isset($this->udaje['dalsi_udaje_5'])) ? ($vlozeni['dalsi_udaje_5'] = $this->udaje['dalsi_udaje_5']) : ('');

	$sql1 = "INSERT INTO prihlasky_{$this->typ_prihlasky}_$this->RokZavodu (".implode(",",array_keys($vlozeni)).",datum_prihlaseni) VALUES ('".implode("','",$vlozeni)."',NOW())";
	//echo $sql1;
	$sth1 = $this->db->prepare($sql1);
	if($sth1->execute()){
	    $id_prihlasky = $this->db->lastInsertId();
	    $sql2 = "INSERT INTO vs_{$this->RokZavodu} (id_zavodu,vs,id_prihlasky,typ_prihlasky) VALUES ('$this->IdZavodu','$this->vs','$id_prihlasky','{$this->udaje['typ_prihlasky']}')";
	    //echo $sql2;
	    $sth2 = $this->db->prepare($sql2);
	    if($sth2->execute()){
		$this->MailZavodnikovi('');
		unset($_POST);
	    }
	}
    }
    
    
    private function xhrSaveToDBTymy(){
	$str = false;
	$vlozeni = Array();
	$vlozeni['id_zavodu'] = $this->IdZavodu;
	(isset($this->udaje['nazev_tymu'])) ? ($vlozeni['nazev_tymu'] = $this->udaje['nazev_tymu']) : ('');
	(isset($this->udaje['stat_tym'])) ? ($vlozeni['stat'] = $this->udaje['stat_tym']) : ('');
	(isset($this->udaje['prislusnost'])) ? ($vlozeni['prislusnost'] = $this->udaje['prislusnost']) : ('');
	(isset($this->udaje['telefon_1_tym'])) ? ($vlozeni['telefon_1'] = $this->udaje['telefon_1_tym']) : ('');	
	(isset($this->udaje['telefon_2_tym'])) ? ($vlozeni['telefon_2'] = $this->udaje['telefon_2_tym']) : ('');
	(isset($this->udaje['mail_tym'])) ? ($vlozeni['mail'] = $this->udaje['mail_tym']) : ('');
	(isset($this->udaje['poradi_podzavodu'])) ? ($vlozeni['poradi_podzavodu'] = $this->udaje['poradi_podzavodu']) : ('');
	if(isset($this->udaje['id_kategorie'])){
	    $vlozeni['id_kategorie'] = $this->udaje['id_kategorie'];
	}
	elseif (isset($this->id_kategorie)) {
	    $vlozeni['id_kategorie'] = $this->id_kategorie;
	}
	(isset($this->udaje['zaplaceno'])) ? ($vlozeni['zaplaceno'] = $this->udaje['zaplaceno']) : ('');
	//(isset($this->startovne)) ? ($vlozeni['startovne'] = $this->startovne) : (''); //2015
	(isset($this->vychozi_startovne)) ? ($vlozeni['startovne'] = $this->vychozi_startovne) : (''); //2016
	(isset($this->mena)) ? ($vlozeni['mena'] = $this->mena) : ('');
	(isset($this->vs)) ? ($vlozeni['vs'] = $this->vs) : ('');
	(isset($this->udaje['vzkaz'])) ? ($vlozeni['vzkaz'] = $this->udaje['vzkaz']) : ('');
	(isset($this->udaje['dalsi_udaje_1'])) ? ($vlozeni['dalsi_udaje_1'] = $this->udaje['dalsi_udaje_1']) : ('');	
	(isset($this->udaje['dalsi_udaje_2'])) ? ($vlozeni['dalsi_udaje_2'] = $this->udaje['dalsi_udaje_2']) : ('');

	$sql1 = "INSERT INTO prihlasky_tymy_$this->RokZavodu (".implode(",",array_keys($vlozeni)).",datum_prihlaseni) VALUES ('".implode("','",$vlozeni)."',NOW())";
	$sth1 = $this->db->prepare($sql1);
	if($sth1->execute()){
	    $id_prihlasky = $this->db->lastInsertId(); //pro tabulku vs
	    $id_prihlasky_tymu = $id_prihlasky; //pro tabulku prihlasky_jednotlivci
	    $sql2 = "INSERT INTO vs_{$this->RokZavodu} (id_zavodu,vs,id_prihlasky,typ_prihlasky) VALUES ('$this->IdZavodu','$this->vs','$id_prihlasky','{$this->udaje['typ_prihlasky']}')";
	    $sth2 = $this->db->prepare($sql2);
	    if($sth2->execute()){
		for($i=1;$i<=$this->udaje['pocet_clenu'];$i++){
		    $vlozeni = Array();
		    $vlozeni['id_zavodu'] = $this->IdZavodu;
		    $vlozeni['id_prihlasky_tymu'] = $id_prihlasky_tymu;
		    (isset($this->udaje['jmeno_1_'.$i])) ? ($vlozeni['jmeno_1'] = $this->udaje['jmeno_1_'.$i]) : ('');
		    (isset($this->udaje['prijmeni_1_'.$i])) ? ($vlozeni['prijmeni_1'] = $this->udaje['prijmeni_1_'.$i]) : ('');
		    (isset($this->udaje['prislusnost_'.$i])) ? ($vlozeni['prislusnost'] = $this->udaje['prislusnost_'.$i]) : ('');
		    (isset($this->udaje['pohlavi_'.$i])) ? ($vlozeni['pohlavi'] = $this->udaje['pohlavi_'.$i]) : ('');
		    (isset($this->udaje['stat_'.$i])) ? ($vlozeni['stat'] = $this->udaje['stat_'.$i]) : ('');
		    if(isset($this->udaje['den_narozeni_'.$i]) && isset($this->udaje['mesic_narozeni_'.$i]) && isset($this->udaje['rok_narozeni_'.$i])){
			$vlozeni['datum_narozeni'] = $this->udaje['rok_narozeni_'.$i].'-'.$this->udaje['mesic_narozeni_'.$i].'-'.$this->udaje['den_narozeni_'.$i];
		    }
		    (isset($this->udaje['mail_'.$i])) ? ($vlozeni['mail'] = $this->udaje['mail_'.$i]) : ('');
		    (isset($this->udaje['telefon_1_'.$i])) ? ($vlozeni['telefon_1'] = $this->udaje['telefon_1_'.$i]) : ('');	
		    (isset($this->udaje['telefon_2_'.$i])) ? ($vlozeni['telefon_2'] = $this->udaje['telefon_2_'.$i]) : ('');
		    (isset($this->udaje['tricko_'.$i])) ? ($vlozeni['tricko'] = $this->udaje['tricko_'.$i]) : ('');	
		    (isset($this->udaje['ponozky_'.$i])) ? ($vlozeni['ponozky'] = $this->udaje['ponozky_'.$i]) : ('');	
		    (isset($this->udaje['dalsi_udaje_1_'.$i])) ? ($vlozeni['dalsi_udaje_1'] = $this->udaje['dalsi_udaje_1_'.$i]) : ('');	
		    (isset($this->udaje['dalsi_udaje_2_'.$i])) ? ($vlozeni['dalsi_udaje_2'] = $this->udaje['dalsi_udaje_2_'.$i]) : ('');
		    (isset($this->udaje['dalsi_udaje_3_'.$i])) ? ($vlozeni['dalsi_udaje_3'] = $this->udaje['dalsi_udaje_3_'.$i]) : ('');

		    $sql1 = "INSERT INTO prihlasky_jednotlivci_$this->RokZavodu (".implode(",",array_keys($vlozeni)).",datum_prihlaseni) VALUES ('".implode("','",$vlozeni)."',NOW())";
		    //echo $sql1;
		    $sth1 = $this->db->prepare($sql1);
		    $sth1->execute();
		}
		$this->MailZavodnikovi('');
		unset($_POST);
	    }
	}
    }
    
    
    private function MailZavodnikoviEnduro(){
	    require "./libs/phpmailer/class.phpmailer.php";
		    $mail1 = new PHPMailer();
		    $mail1->IsSMTP();
		    $mail1->Host = SMTP;
		    //$mail1->Host = "smtp.vodafonmail.cz";
		    $mail1->From = "info@timechip.cz";
		    $mail1->FromName = "TimeChip";
		    if($mail){
			$mail1->AddAddress($mail);
		    }
		    else{
			$mail1->AddAddress($this->mail_na_zavodnika);
		    }
		    $mail1->IsHTML(true);
		    $mail1->Subject = $this->NazevZavodu.' '.YEAR.", předběžná registrace";
		    $mail1->Body = false;
    }
    
    
    
    
    
    
    
    private function MailPoradateli(){
	if(!empty($this->udaje['vzkaz'])){
	    $sql1 = "SELECT mail FROM prihlasky_".YEAR." WHERE id_zavodu = '$this->IdZavodu'";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    $dbdata1 = $sth1->fetchObject();

		    $mail2 = new PHPMailer();
		    $mail2->IsSMTP();
		    //$mail2->Host = "smtp.hnojniknet.cz";
		    $mail2->Host = SMTP;
		    //$mail1->Host = "smtp.vodafonmail.cz";
		    $mail2->From = $this->mail_na_zavodnika;
		    $mail2->FromName = $this->udaje['jmeno_1'].' '.$this->udaje['prijmeni_1'];
		    $mail2->AddAddress($dbdata1->mail);
		    $mail2->IsHTML(true);
		    $mail2->Subject = $this->NazevZavodu.' '.YEAR.", vzkaz pořadateli";
		    $mail2->Body = "Od: {$this->udaje['jmeno_1']} {$this->udaje['prijmeni_1']}<br />"; 
		    $mail2->Body .= "Text: {$this->udaje['vzkaz']}";
		    if(!$mail2->Send()){
			exit;
		    }

	}
    }
		public function MailZavodnikovi($mail){
		    require "./libs/phpmailer/class.phpmailer.php";
		    $mail1 = new PHPMailer();
		    $mail1->IsSMTP();
		    $mail1->Host = SMTP;
		    //$mail1->Host = "smtp.t-email.cz";
		    //$mail1->Host = "smtp.vodafonmail.cz";
		    $mail1->From = "info@timechip.cz";
		    //$mail1->addReplyTo('skybedy@gmail.com', 'Information');
		    $mail1->FromName = "TimeChip";
		    if($mail){
			$mail1->AddAddress($mail);
		    }
		    else{
			$mail1->AddAddress($this->mail_na_zavodnika);
		    }
		    $mail1->IsHTML(true);
		    $mail1->Subject = $this->NazevZavodu.' '.YEAR.", předběžná registrace";
		    $mail1->Body = false;
		    
		    if($this->IdZavodu == 13){//Cross Country
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.' '.YEAR.'.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Vaše údaje jsou:<br />';
			$mail1->Body .= "Startovní číslo: {$_GET['race_number']}<br />"; 
			$mail1->Body .= "Jméno a příjmení: {$_GET['jmeno']} {$_GET['prijmeni']}<br />"; 
			$mail1->Body .= "Datum narození: {$_GET['den_narozeni']}.{$_GET['mesic_narozeni']}.{$_GET['rocnik']}<br />";
			$mail1->Body .= "Telefon: {$_GET['telefon']}<br />";
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Na viděnou se těší pořadatelé<br />';
			$mail1->Body .= '<hr />';
		    }
		    
		    elseif($this->IdZavodu == 29){ //Odrivous
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.'.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Vaše údaje jsou:<br />';
			$mail1->Body .= "Jméno a příjmení: {$this->udaje['jmeno_1']} {$this->udaje['prijmeni_1']}<br />"; 
			$mail1->Body .= "Oddíl nebo místo bydliště: {$this->udaje['prislusnost']}<br />";
			$mail1->Body .= "Datum narození: {$this->udaje['den_narozeni']}.{$this->udaje['mesic_narozeni']}.{$this->udaje['rok_narozeni']}<br />";
			$mail1->Body .= "Telefon: {$this->udaje['telefon_1']}<br />";
			$mail1->Body .= 'Možnost platby startovného dopředu již bylo ukončena. Startovné bude možno zaplatit až v den závodu v rámci prezentace.';
                        $mail1->Body .= '<hr />';
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= '<hr />';
		    }
                    
                    
                    		    
		    elseif($this->IdZavodu == 21){ //MAjetín
                        if($this->udaje['poradi_podzavodu'] == 1){
                            $mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.'.<br />';
                            $mail1->Body .= '<hr />';
                            $mail1->Body .= 'Vaše údaje jsou:<br />';
                            $mail1->Body .= "Jméno a příjmení: {$this->udaje['jmeno_1']} {$this->udaje['prijmeni_1']}<br />"; 
                            $mail1->Body .= "Oddíl nebo místo bydliště: {$this->udaje['prislusnost']}<br />";
                            $mail1->Body .= "Datum narození: {$this->udaje['den_narozeni']}.{$this->udaje['mesic_narozeni']}.{$this->udaje['rok_narozeni']}<br />";
                            $mail1->Body .= "Telefon: {$this->udaje['telefon_1']}<br />";
                            $mail1->Body .= '<hr />';
                            if($this->udaje['poradi_podzavodu'] < 3){
                                $mail1->Body .= 'V případě, že budete chtít využít zvýhodněné startovné, je nutné do '.$this->konec_prihlasek.' realizovat platbu podle následujících údajů:<br />';
                                $mail1->Body .= 'Číslo účtu: '.$this->cislo_uctu.'<br />';
                                $mail1->Body .= 'Částka: '.$this->startovne_kc.'Kč<br />';
                                $mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
                                $mail1->Body .= '<hr />';
                            }
                        }
                        else{
                            $mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.'.<br />';
                            $mail1->Body .= '<hr />';
                            $mail1->Body .= 'V případě, že budete chtít využít zvýhodněné startovné, je nutné do '.$this->konec_prihlasek.' realizovat platbu podle následujících údajů:<br />';
                            $mail1->Body .= 'Číslo účtu: '.$this->cislo_uctu.'<br />';
                            $mail1->Body .= 'Částka: '.$this->startovne_kc.' Kč<br />';
                            $mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
                            $mail1->Body .= '<hr />';			
                        }
                        
                        
                        
                        
                        $mail1->Body .= 'Za pořadatele:<br />';
                        $mail1->Body .= $this->poradatel.'<br />';
                        $mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
                        $mail1->Body .= '<hr />';

		
		    }
                    
                    
		    
		    
		    
		    
		    
		    elseif($this->IdZavodu == 33){ //prajzak
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.'.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Vaše údaje jsou:<br />';
			$mail1->Body .= "Jméno a příjmení: {$this->udaje['jmeno_1']} {$this->udaje['prijmeni_1']}<br />"; 
			$mail1->Body .= "Oddíl nebo místo bydliště: {$this->udaje['prislusnost']}<br />";
			$mail1->Body .= "Datum narození: {$this->udaje['den_narozeni']}.{$this->udaje['mesic_narozeni']}.{$this->udaje['rok_narozeni']}<br />";
			$mail1->Body .= "Telefon: {$this->udaje['telefon_1']}<br />";
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Podmínkou přihlášení je platba startovného. Pokud jej neuhradíte do 4 pracovních dnů od registrace, budete automaticky vymazáni ze seznamu závodníků a uvolní se tak místo pro další zájemce.<br />';
			$mail1->Body .= 'STARTOVNÉ SE NEVRACÍ.<br />';
			$mail1->Body .= 'Číslo účtu: '.$this->cislo_uctu.'<br />';
			$mail1->Body .= 'Částka: '.$this->startovne_kc.'Kč<br />';
			$mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'V případě, že budete chtít zaplatit hotově, je to možné po dohodě s hlavní organizátorkou, jejíž kontaktní údaje jsou uvedeny níže.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= ($this->telefon_na_poradatele == true) ? ('Tel: '.$this->telefon_na_poradatele) : ('');
			$mail1->Body .= '<hr />';
		    }

		    
		    elseif($this->IdZavodu == 114 OR $this->IdZavodu == 53000){//Cross Country
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.' '.YEAR.'.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Vaše údaje jsou:<br />';
			$mail1->Body .= "Jméno a příjmení: {$this->udaje['jmeno_1']} {$this->udaje['prijmeni_1']}<br />"; 
			$mail1->Body .= "Oddíl nebo místo bydliště: {$this->udaje['prislusnost']}<br />";
			$mail1->Body .= "Datum narození: {$this->udaje['den_narozeni']}.{$this->udaje['mesic_narozeni']}.{$this->udaje['rok_narozeni']}<br />";
			$mail1->Body .= "Telefon: {$this->udaje['telefon_1']}<br />";
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Na viděnou se těší pořadatelé<br />';
			$mail1->Body .= '<hr />';
		    }

		    elseif($this->IdZavodu == 1){ //Skialplysa
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.' '.YEAR.'.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Vaše údaje jsou:<br />';
			$mail1->Body .= "Jméno a příjmení: {$this->udaje['jmeno_1']} {$this->udaje['prijmeni_1']}<br />"; 
			$mail1->Body .= "Oddíl nebo místo bydliště: {$this->udaje['prislusnost']}<br />";
			$mail1->Body .= "Datum narození: {$this->udaje['den_narozeni']}.{$this->udaje['mesic_narozeni']}.{$this->udaje['rok_narozeni']}<br />";
			$mail1->Body .= "Telefon: {$this->udaje['telefon_1']}<br />";
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Výše startovného při úhradě:<br />';
			$mail1->Body .= 'do 1.12.2015 – 250 Kč (10 EUR, 39 PLN):<br />';
			$mail1->Body .= 'do 31.12.2015 – 300 Kč (12 EUR, 47 PLN)<br />';
			$mail1->Body .= 'do 12.1.2016 – 400 Kč (16 EUR, 62 PLN)<br />';
			$mail1->Body .= 'na místě v den závodu – 500 Kč (20 EUR, 78 PLN))<br />';
			$mail1->Body .= '<b>Pro uznání zvýhodněné platby je rozhodující den připsání platby na účet</b><br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Čísla účtu: <br />';
			$mail1->Body .= 'Pro české účastníky v CZK: 2106579494/2700, variabilní symbol: 15030283, do zprávy pro příjemce uvést jméno a příjmení.<br />';
			$mail1->Body .= 'Pro slovenské účastníky v EUR: 1053063026/1111, variabilní symbol: 15030283, do zprávy pro příjemce uvést jméno a příjmení.<br />';
			$mail1->Body .= 'Pro polské účastníky v PLN: 87105014031000002303599472/10501403, variabilní symbol: 15030283, do zprávy pro příjemce uvést jméno a příjmení.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= '<b>Vstupem a vyplněním přihlášky každý účastník stvrzuje pravdivost svých údajů. Nepravdivé údaje mohou mít za následek vyřazení ze závodního pole.</b>';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Kontakt na pořadatele:<br />';
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= ($this->telefon_na_poradatele == true) ? ('Tel: '.$this->telefon_na_poradatele) : ('');
			$mail1->Body .= '<hr />';
		    }
		    elseif($this->IdZavodu == 20){//Pedalovnik
			//echo 'hoj';
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.'.<br />';
			$mail1->Body .= '<hr />';
			if($this->udaje['poradi_podzavodu'] == 3){
			    $mail1->Body .= "Start na Pedálovníčku je zdarma";
			}
			else{
			    $mail1->Body .= 'V případě, že budete chtít využít zvýhodněné startovné, je nutné do '.$this->konec_prihlasek.' realizovat platbu podle následujících údajů:<br />';
			    $mail1->Body .= 'Částka: '.$this->startovne_eu.'€<br />';
			    $mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
			    $mail1->Body .= 'Banka: '.$this->nazev_banky.'<br />';
			    $mail1->Body .= 'Číslo účtu - '.$this->cislo_uctu.'<br />';
			    $mail1->Body .= 'IBAN: '.$this->iban.'<br />';
			    $mail1->Body .= 'SWIFT: '.$this->swift.'<br />';
			}
			$mail1->Body .= '<hr />';			
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= '<hr />';
		    }
		    
		    elseif($this->IdZavodu == 41){//radegastova výzva
			//echo 'hoj';
			$mail1->Body .= 'Ahoj Vyzyvateli Radegasta!<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Děkujeme celému Vašemu týmu za zájem zúčastnit se <span style="color:red">Radegastovy výzvy pro kostní dřeň 2016</span>. Vaše registrace byla úspěšně uložena do systému.<br />';
			
			$mail1->Body .= 'Nyní k úspěšnému dokončení registrace prosím zašli platbu v celkové výši '.$this->startovne_kc.' Kč na účet spolku RV<br />';
			$mail1->Body .= 'Číslo účtu: '.$this->cislo_uctu.'<br />';
			$mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
			$mail1->Body .= 'Platbu prosím proveď do 7 dnů od obdržení tohoto e-mailu.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Částka zahrnuje startovné celého týmu (490kč / osoba) + cenu za objednaná trika (200kč / 1 kus)<br />';
			
			$mail1->Body .= '<span style="font-weight:bold;color:red">V případě, že jste zvolili chatku nebo budovu, tak se ubytování celého týmu platí hotově až na místě v den ubytování! Do 3 dnů od registrace zašleme email s informacemi o celkové částce za ubytování (150 kč / 1 lůžko / 1 noc), číslo chatky, číslo pokoje.. atd. </span><br />';
			$mail1->Body .= '<span style="font-weight:bold;color:red">Na místě bude taky možné domluvit ubytování doprovodu (150 kč / 1 lůžko / 1 noc). Pokud už nebude na pokoji postel volná, tak ubytování doprovodu na vlastní karimatce (100 kč / 1 lůžko / 1 noc). </span><br />';
			$mail1->Body .= '<br />';
			$mail1->Body .= 'Uděláme vše proto, aby se vám závod líbil a užili si tak hezký podzimní víkend v srdci Beskydských hor.<br />';
			$mail1->Body .= '<hr />';	
			$mail1->Body .= 'S pozdravem<br />';
			$mail1->Body .= 'Organizační tým RV<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= ($this->telefon_na_poradatele == true) ? ('Tel: '.$this->telefon_na_poradatele) : ('');
			$mail1->Body .= '<hr />';
		    }
		    
		    
		    elseif($this->IdZavodu == 76){//radegastova výzva 13km
			//echo 'hoj';
			$mail1->Body .= 'Ahoj!<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Děkujeme za zájem zúčastnit se <span style="color:red">Běžeckého a turistického happeningu pro kostní dřeň 2016</span>. Vaše registrace byla úspěšně uložena do systému.<br />';
			
			$mail1->Body .= 'Nyní k úspěšnému dokončení registrace prosím zašli platbu v celkové výši '.$this->startovne_kc.' Kč na účet spolku RV<br />';
			$mail1->Body .= 'Číslo účtu: '.$this->cislo_uctu.'<br />';
			$mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
			$mail1->Body .= 'Platbu prosím proveď do 7 dnů od obdržení tohoto e-mailu.<br />';
			$mail1->Body .= 'Částka zahrnuje startovné (150kč / osoba) + cenu za triko (150kč / 1 kus) v případě jeho objednání<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Uděláme vše proto, aby se vám happening líbil a užili si tak hezký letní víkend v srdci Beskydských hor.<br />';
			$mail1->Body .= '<hr />';	
			$mail1->Body .= 'S pozdravem<br />';
			$mail1->Body .= 'Organizační tým RV<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= ($this->telefon_na_poradatele == true) ? ('Tel: '.$this->telefon_na_poradatele) : ('');
			$mail1->Body .= '<hr />';
		    }
		    
		    
		    
		    
		    elseif($this->IdZavodu == 10 || $this->IdZavodu == 8){//zilina 24 + kuchyna
			//echo 'hoj';
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.'.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'V případě, že budete chtít využít zvýhodněné startovné, je nutné do '.$this->konec_prihlasek.' realizovat platbu podle následujících údajů:<br />';
			$mail1->Body .= 'Částka: '.$this->startovne_eu.'€<br />';
			$mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
			$mail1->Body .= 'Banka: '.$this->nazev_banky.'<br />';
			$mail1->Body .= 'Číslo účtu - '.$this->cislo_uctu.'<br />';
			$mail1->Body .= 'IBAN: '.$this->iban.'<br />';
			$mail1->Body .= 'SWIFT: '.$this->swift.'<br />';
			$mail1->Body .= '<hr />';			
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= '<hr />';
		    }

		    elseif($this->IdZavodu == 9 || $this->IdZavodu == 11 || $this->IdZavodu == 12 || $this->IdZavodu == 47 || $this->IdZavodu == 19){//jihlava,opava,náchod,100 pro adru
			//echo 'hoj';
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.'.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'V případě, že budete chtít využít zvýhodněné startovné, je nutné do '.$this->konec_prihlasek.' realizovat platbu podle následujících údajů:<br />';
			$mail1->Body .= 'Částka: '.$this->vychozi_startovne.' Kč<br />';
			$mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
			$mail1->Body .= 'Banka: '.$this->nazev_banky.'<br />';
			$mail1->Body .= 'Číslo účtu - '.$this->cislo_uctu.'<br />';
			//$mail1->Body .= 'IBAN: '.$this->iban.'<br />';
			//$mail1->Body .= 'SWIFT: '.$this->swift.'<br />';
			$mail1->Body .= '<hr />';			
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= '<hr />';
		    }

		    
		    elseif($this->IdZavodu == 83){ //Nezmar
			$mail1->Body .= 'Ahoj Vyzyvateli z řad Nezmara .<br />';
			$mail1->Body .= 'První nástrahu formou registrace jsi úspěšně zvládl. Nyní Tě čeká druhá nástraha formou platby. Pro úspěšné dokončení registrace prověď platbu.<br />';
                        $mail1->Body .= 'Na č. účtu –  670100-2213663261/6210<br />';
			$mail1->Body .= 'Platba – SkyMarathon – 400kč / UltraskyMarathon – 555Kč <br />';
                        $mail1->Body .= 'Variabilni symbol - '.$this->vs.'<br />';
			$mail1->Body .= 'Do zprávy pro příjemce vyplň – NEZMAR SKYMARATHON,( v případě platby 400kč), nebo NEZMAR ULTRA ( v případě platby 555kč)<br />';
			$mail1->Body .= 'Pro zahraniřní platby<br />';
			$mail1->Body .= 'Proveď Evropskou SEPA Platbu pouze v EURECH<br />';
			$mail1->Body .= 'Na č.účtu - 670100-2213663261/6210<br />';
			$mail1->Body .= 'Platba – SkyMarathon – 15 Euro / UltraskyMarathon – 20 Euro <br />';
			$mail1->Body .= 'Variabilni symbol - '.$this->vs.'<br />';
			$mail1->Body .= 'Do zprávy pro příjemce vyplň – NEZMAR SKYMARATHON,( v případě platby 400kč), nebo NEZMAR ULTRA ( v případě platby 555kč) <br />';
                        $mail1->Body .= '<hr />';
			$mail1->Body .= 'Hello Nezmar´s challenger .<br />';
			$mail1->Body .= 'The first step – to registrate on race you´ve already done. The next step is to realize a payment to finish succesfully the registration. .<br />';
			$mail1->Body .= 'The account number: 670100-2213663261/6210<br />';
			$mail1->Body .= 'Pyement – SkyMarathon – 400Kč/UltraskyMarathon – 555Kč <br />';
			
                        $mail1->Body .= 'Fill the specific number - '.$this->vs.'<br />';
			$mail1->Body .= 'In to the message for reciever fill in – NEZMAR SKYMARATHON (if you send 400Kč) or NEZMAR ULTRA (sending 555Kč)<br />';
			$mail1->Body .= 'For foreign payment you must make European SEPA Payment only in Euro!!!<br />';
			$mail1->Body .= 'Pyement – SkyMarathon – 15Euro/UltraskyMarathon – 20Euro<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Za pořadatele:<br />';
                        $mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= '<hr />';

		    }

                    elseif($this->IdZavodu == 5){ //Perun
			$mail1->Body .= 'Ahoj Vyzyvateli Peruna.<br />';
			$mail1->Body .= 'Prvni nastrahu formou registrace jsi zvladl:o).<br />';
			$mail1->Body .= 'Nyni k uspesnemu dokoncení prosim zasli startovne v hodnote '.$this->startovne_kc.'Kč nebo '.$this->startovne_eu.'€<br />';
			$mail1->Body .= 'Číslo účtu - '.$this->cislo_uctu.'<br />';
			$mail1->Body .= 'IBAN - '.$this->iban.'<br />';
			$mail1->Body .= 'SWIFT - '.$this->swift.'<br />';
			$mail1->Body .= 'Adresa banky: Raiffeisenbank a.s., Hvězdova 1716/2b, 140 78 Praha 4<br />';
			$mail1->Body .= 'Variabilni symbol - '.$this->vs.'<br />';
			$mail1->Body .= 'Specificky symbol - PERUN<br />';
			$mail1->Body .= 'Platbu proved do 10 dni od obdrzení tohoto potvrzujíciho e-mailu.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'A muzes smele zacit trenovat:o).<br />';
			$mail1->Body .= 'Life is Vertical.<br />';
			$mail1->Body .= 'Perun je partnerem charitativniho projektu - Nikdy nejsi sam.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= 'Tel: '.$this->telefon_na_poradatele;
			$mail1->Body .= '<hr />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= '<hr />';
			
			$mail1->Body .= 'Hi challengers Peruna.<br />';
			$mail1->Body .= 'The first bait registration form you managed: o).<br />';
			$mail1->Body .= 'Now to complete, please send fee in the amount of '.$this->startovne_kc.'Kc or '.$this->startovne_eu.'€<br />';
			$mail1->Body .= 'Account number - '.$this->cislo_uctu.'<br />';
			$mail1->Body .= 'IBAN - '.$this->iban.'<br />';
			$mail1->Body .= 'SWIFT - '.$this->swift.'<br />';
			$mail1->Body .= 'Bank adress: Raiffeisenbank a.s., Hvězdova 1716/2b, 140 78 Praha 4<br />';
			$mail1->Body .= 'Variable symbol - '.$this->vs.'<br />';
			$mail1->Body .= 'Specific symbol - PERUN<br />';
			$mail1->Body .= 'Payment shall be made within 10 days of receipt of confirmation email..<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'And you can boldly start training: o).<br />';
			$mail1->Body .= 'Life is Vertical.<br />';
			$mail1->Body .= ' Perun is partner of charity project - Nikdy nejsi sám.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= 'Phone: '.$this->telefon_na_poradatele;
			$mail1->Body .= '<hr />';

		    }
		    
		    elseif($this->IdZavodu == 48){//default 
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.' '.YEAR.'.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Vaše údaje jsou:<br />';
			$mail1->Body .= "Jméno a příjmení: {$this->udaje['jmeno_1']} {$this->udaje['prijmeni_1']}<br />"; 
			$mail1->Body .= "Oddíl nebo místo bydliště: {$this->udaje['prislusnost']}<br />";
			$mail1->Body .= "Datum narození: {$this->udaje['den_narozeni']}.{$this->udaje['mesic_narozeni']}.{$this->udaje['rok_narozeni']}<br />";
			$mail1->Body .= "Telefon: {$this->udaje['telefon_1']}<br />";
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Za pořadatele:<br />';
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= ($this->telefon_na_poradatele == true) ? ('Tel: '.$this->telefon_na_poradatele) : ('');
			$mail1->Body .= '<hr />';
		    }
		    
		    elseif($this->IdZavodu == 50){//belsky_okruh
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.' '.YEAR.'.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Vaše údaje jsou:<br />';
			$mail1->Body .= "Jméno a příjmení: {$this->udaje['jmeno_1']} {$this->udaje['prijmeni_1']}<br />"; 
			$mail1->Body .= "Oddíl nebo místo bydliště: {$this->udaje['prislusnost']}<br />";
			$mail1->Body .= "Datum narození: {$this->udaje['den_narozeni']}.{$this->udaje['mesic_narozeni']}.{$this->udaje['rok_narozeni']}<br />";
			$mail1->Body .= "Telefon: {$this->udaje['telefon_1']}<br />";
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'V případě, že budete chtít využít zvýhodněné startovné, je nutné do '.$this->konec_prihlasek.' realizovat platbu podle následujících údajů:<br />';
			$mail1->Body .= 'Číslo účtu: '.$this->cislo_uctu.'<br />';
			$mail1->Body .= 'Částka: '.$this->startovne_kc.' Kč<br />';
			$mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= ($this->telefon_na_poradatele == true) ? ('Tel: '.$this->telefon_na_poradatele) : ('');
			$mail1->Body .= '<hr />';
			$mail1->AddAttachment('./public/doc/zakladni-informace-belsky-okruh.pdf', $name = '', $encoding = 'base64', $type = 'application/octet-stream');
		    }
		    
		    elseif($this->IdZavodu == 23){//bbl
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.' '.YEAR.'.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Vaše údaje jsou:<br />';
			$mail1->Body .= "Jméno a příjmení: {$this->udaje['jmeno_1']} {$this->udaje['prijmeni_1']}<br />"; 
			$mail1->Body .= "Oddíl nebo místo bydliště: {$this->udaje['prislusnost']}<br />";
			$mail1->Body .= "Datum narození: {$this->udaje['den_narozeni']}.{$this->udaje['mesic_narozeni']}.{$this->udaje['rok_narozeni']}<br />";
			$mail1->Body .= "Telefon: {$this->udaje['telefon_1']}<br />";
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'V případě, že budete chtít využít zvýhodněné startovné, je nutné do '.$this->konec_prihlasek.' (volba s tričkem), či 16. 8. 2016 (volba bez trička), realizovat platbu podle následujících údajů:<br />';
			$mail1->Body .= 'Číslo účtu: '.$this->cislo_uctu.'<br />';
			$mail1->Body .= 'Částka: '.$this->startovne_kc.' Kč<br />';
			$mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= ($this->telefon_na_poradatele == true) ? ('Tel: '.$this->telefon_na_poradatele) : ('');
			$mail1->Body .= '<hr />';		    
		    }
                    elseif($this->IdZavodu == 54){//kytlice
			//echo 'hoj';
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.'.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'V případě, že budete chtít využít zvýhodněné startovné, je nutné do '.$this->konec_prihlasek.' realizovat platbu podle následujících údajů:<br />';
			$mail1->Body .= 'Číslo účtu: '.$this->cislo_uctu.'<br />';
			$mail1->Body .= 'Částka: '.$this->startovne_kc.' Kč<br />';
			$mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
			$mail1->Body .= '<hr />';			
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= '<hr />';
		    }
		    
		    
                    elseif($this->IdZavodu == 121){//
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.' '.YEAR.'.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Vaše údaje jsou:<br />';
			$mail1->Body .= "Jméno a příjmení: {$this->udaje['jmeno_1']} {$this->udaje['prijmeni_1']}<br />"; 
			$mail1->Body .= "Oddíl nebo místo bydliště: {$this->udaje['prislusnost']}<br />";
			$mail1->Body .= "Datum narození: {$this->udaje['den_narozeni']}.{$this->udaje['mesic_narozeni']}.{$this->udaje['rok_narozeni']}<br />";
			$mail1->Body .= "Telefon: {$this->udaje['telefon_1']}<br />";
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Nezapomeňte, že startovné je nutné uhradit nejpozději do '.$this->konec_prihlasek.' podle následujících údajů:<br />';
			$mail1->Body .= 'Číslo účtu: '.$this->cislo_uctu.'<br />';
			$mail1->Body .= 'Částka: '.$this->startovne_kc.' Kč<br />';
			$mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= ($this->telefon_na_poradatele == true) ? ('Tel: '.$this->telefon_na_poradatele) : ('');
			$mail1->Body .= '<hr />';
		    }

                    else{//default 
			$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.' '.YEAR.'.<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'Vaše údaje jsou:<br />';
			$mail1->Body .= "Jméno a příjmení: {$this->udaje['jmeno_1']} {$this->udaje['prijmeni_1']}<br />"; 
			$mail1->Body .= "Oddíl nebo místo bydliště: {$this->udaje['prislusnost']}<br />";
			$mail1->Body .= "Datum narození: {$this->udaje['den_narozeni']}.{$this->udaje['mesic_narozeni']}.{$this->udaje['rok_narozeni']}<br />";
			$mail1->Body .= "Telefon: {$this->udaje['telefon_1']}<br />";
			$mail1->Body .= '<hr />';
			$mail1->Body .= 'V případě, že budete chtít využít zvýhodněné startovné, je nutné do '.$this->konec_prihlasek.' realizovat platbu podle následujících údajů:<br />';
			$mail1->Body .= 'Číslo účtu: '.$this->cislo_uctu.'<br />';
			$mail1->Body .= 'Částka: '.$this->startovne_kc.' Kč<br />';
			$mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
			$mail1->Body .= '<hr />';
			$mail1->Body .= $this->poradatel.'<br />';
			$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
			$mail1->Body .= ($this->telefon_na_poradatele == true) ? ('Tel: '.$this->telefon_na_poradatele) : ('');
			$mail1->Body .= '<hr />';
		    }
		    if(!$mail1->Send()){
			echo "<p>Vznikl nejaky problem a zprava nebyla odeslana. Pokud muzete, kontaktujte nas prosim bud telefonicky na 776131313, nebo pomoci e-mailu na adresu <a href=\"mailto:timechip@timechip.cz\">timechip@timechip.cz</a>.</p>";
			exit;
		    }
		    $this->MailPoradateli();
		}		

	private function VyberKategorie(){
	    $this->kategorie = false;
	    isset($this->udaje['pohlavi']) ? $pohlavi = $this->udaje['pohlavi'] : ''; 
	    isset($this->udaje['pohlavi_1']) ? $pohlavi = $this->udaje['pohlavi_1'] : ''; 
	    if($this->IdZavodu == 20){ //Pedalovnik
		switch($this->udaje['poradi_podzavodu']){
		    case 1:
			$this->VyberKategorieDefault($this->udaje['poradi_podzavodu']);
			break;
		    case 2;
			$this->VyberKategoriePodlePoradiPodzavodu($this->udaje['poradi_podzavodu']);
			break;
		    case 3:
			$this->VyberKategorieBezPohlavi($this->udaje['poradi_podzavodu']);
			break;
		}
	    }
	    elseif($this->IdZavodu == 41){
		$this->kategorie = $this->udaje['id_kategorie'];
	    }
	   
	    elseif($this->IdZavodu == 21){ //kytlice
		switch($this->udaje['poradi_podzavodu']){
		    case 1:
			$this->VyberKategorieDefault($this->udaje['poradi_podzavodu']);
			break;
		    case 2;
                        $this->kategorie = $this->udaje['id_kategorie'];
			break;
		}
	    }

            elseif($this->IdZavodu == 54){ //kytlice
		switch($this->udaje['poradi_podzavodu']){
		    case 1:
			$this->VyberKategorieDefault($this->udaje['poradi_podzavodu']);
			break;
		    case 2;
			$this->VyberKategoriePodleId($this->udaje['id_kategorie']);
			break;
		}
	    }

            elseif($this->IdZavodu == 48){ //ustecky schod
		switch($this->udaje['poradi_podzavodu']){
		    case 1:
			$this->VyberKategorieDefault($this->udaje['poradi_podzavodu']);
			break;
		    case 2;
			$this->VyberKategoriePodlePoradiPodzavodu($this->udaje['poradi_podzavodu']);
			break;
		    case 3:
			$this->VyberKategorieDefault($this->udaje['poradi_podzavodu']);
			break;
		}
	    }
	    
	    elseif($this->IdZavodu == 76){ //radegast, 16km
		$this->VyberKategorieBezPohlavi($this->udaje['poradi_podzavodu']);
	    }
	    
	    
	    

	    elseif($this->IdZavodu == 19){ //pulmaraton jihlava
		if($this->udaje['poradi_podzavodu'] == 1 || $this->udaje['poradi_podzavodu'] == 5){
                    $this->VyberKategorieDefault($this->udaje['poradi_podzavodu']);
		}
		
		else{
		    $this->kategorie = $this->udaje['id_kategorie'];
		}

	    }

            elseif($this->IdZavodu == 9){ //24 hod jihlava
		if($this->udaje['poradi_podzavodu'] == 1 || $this->udaje['poradi_podzavodu'] == 5){
		    if(!isset($this->udaje['open'])){
			$this->VyberKategorieDefault($this->udaje['poradi_podzavodu']);
		    }
		    else{
			$this->VyberKategoriePodleKonkretnihoVeku($this->udaje['poradi_podzavodu'],30);
		    }
		}
		elseif($this->udaje['poradi_podzavodu'] == 4){
		    $this->VyberKategoriePodlePoradiPodzavodu($this->udaje['poradi_podzavodu']);

		}
		
		else{
		    $this->kategorie = $this->udaje['id_kategorie'];
		}

	    }
	    
	    elseif($this->IdZavodu == 33){
		$this->VyberKategorieBezPoradiPodzavodu();
	    }
	    
	    elseif($this->IdZavodu == 10 || $this->IdZavodu == 8 || $this->IdZavodu == 11 || $this->IdZavodu == 12){ //24 hod zilina, opava, kuchyna, nachod
		switch($this->udaje['poradi_podzavodu']){
		    case 1:
			if(!isset($this->udaje['open'])){
			    $this->VyberKategorieDefault($this->udaje['poradi_podzavodu']);
			}
			else{
			    $this->VyberKategoriePodleKonkretnihoVeku($this->udaje['poradi_podzavodu'],30);
			}
		    break;
		    case 4: //jen opava, nachod
			if($this->IdZavodu == 11){ //jen nachod
			    $this->VyberKategorieDefault($this->udaje['poradi_podzavodu']);
			}
			elseif($this->IdZavodu == 12){ //jen opava
			    if(!isset($this->udaje['open'])){
				$this->VyberKategorieDefault($this->udaje['poradi_podzavodu']);
			    }
			else{
			    $this->VyberKategoriePodleKonkretnihoVeku($this->udaje['poradi_podzavodu'],30);
			    }
			}
		    break;
		    default:
			$this->kategorie = $this->udaje['id_kategorie'];
		}
	    }
	    elseif($this->IdZavodu == 47){ //100 pro adru
		$this->kategorie = $this->udaje['id_kategorie'];
	    }
	    

	    elseif($this->IdZavodu == 114 || $this->IdZavodu == 53){ //cc hobby
		if(!isset($this->udaje['open'])){
		    $this->VyberKategorieDefault($this->udaje['poradi_podzavodu']);
		}
		else{
		    $this->VyberKategoriePodleKonkretnihoVeku($this->udaje['poradi_podzavodu'],30);
		}
	    }
		
	    elseif($this->IdZavodu == 50){
		if(!isset($this->udaje['elite'])){
		    $this->VyberKategorieDefault($this->udaje['poradi_podzavodu']);
		}
		else{
		    $this->VyberKategoriePodleKonkretnihoVeku($this->udaje['poradi_podzavodu'],99); //elite
		}
	    }
            
           		
	    elseif($this->IdZavodu == 121){
		if(isset($this->udaje['vmg'])){
		    $this->VyberKategorieParalelniKategorie($this->udaje['poradi_podzavodu']);
		}
		else{
		    $this->VyberKategorieDefault($this->udaje['poradi_podzavodu']); 
		}
	    }
	    
            else{
		$this->VyberKategorieDefault($this->udaje['poradi_podzavodu']);
	    }
	}
	
	private function VyberKategorieDefault($poradi_podzavodu){
	    isset($this->udaje['pohlavi']) ? $pohlavi = $this->udaje['pohlavi'] : ''; 
	   // $vek = date('Y') - $this->udaje['rok_narozeni'] + 1; //jednicka pripoctena jen do 31.12
	    $vek = date('Y') - $this->udaje['rok_narozeni']; 
	    $sql = "SELECT * FROM kategorie_{$this->RokZavodu} WHERE id_zavodu = '$this->IdZavodu' AND pohlavi = '$pohlavi' AND '$vek' BETWEEN vek_start AND vek_konec AND poradi_podzavodu = '$poradi_podzavodu' AND paralelni_kategorie = 0";
	    $sth = $this->db->prepare($sql);
	    $sth->execute();
	    if($sth->rowCount()){ 
		$data1 =  $sth->fetchObject();
		$this->kategorie = $data1->nazev_k;
		$this->kod_kategorie = $data1->kod_k;
		$this->id_kategorie = $data1->id_kategorie;
	    }
	}
        
        private function VyberKategorieParalelniKategorie($poradi_podzavodu){
	    isset($this->udaje['pohlavi']) ? $pohlavi = $this->udaje['pohlavi'] : ''; 
	    $vek = date('Y') - $this->udaje['rok_narozeni']; 
	    $sql = "SELECT * FROM kategorie_{$this->RokZavodu} WHERE id_zavodu = '$this->IdZavodu' AND pohlavi = '$pohlavi' AND '$vek' BETWEEN vek_start AND vek_konec AND poradi_podzavodu = '$poradi_podzavodu' AND paralelni_kategorie = 1";
	    $sth = $this->db->prepare($sql);
	    $sth->execute();
	    if($sth->rowCount()){ 
		$data1 =  $sth->fetchObject();
		$this->kategorie = $data1->nazev_k;
		$this->kod_kategorie = $data1->kod_k;
		$this->id_kategorie = $data1->id_kategorie;
	    }
	}

	private function VyberKategoriePodleKonkretnihoVeku($poradi_podzavodu,$vek){
	    isset($this->udaje['pohlavi']) ? $pohlavi = $this->udaje['pohlavi'] : ''; 
	    $sql = "SELECT * FROM kategorie_{$this->RokZavodu} WHERE id_zavodu = '$this->IdZavodu' AND pohlavi = '$pohlavi' AND '$vek' BETWEEN vek_start AND vek_konec AND poradi_podzavodu = '$poradi_podzavodu'";
	    //echo $sql;
	    $sth = $this->db->prepare($sql);
	    $sth->execute();
	    if($sth->rowCount()){ 
		$data1 =  $sth->fetchObject();
		$this->kategorie = $data1->nazev_k;
		$this->kod_kategorie = $data1->kod_k;
		$this->id_kategorie = $data1->id_kategorie;
	    }
	}
	
	private function VyberKategoriePodlePoradiPodzavodu($poradi_podzavodu){
	    //isset($this->udaje['pohlavi_1']) ? $pohlavi = $this->udaje['pohlavi_1'] : ''; 
	    //$vek = date('Y') - $this->udaje['rok_narozeni_1'];
	    $sql = "SELECT * FROM kategorie_{$this->RokZavodu} WHERE id_zavodu = '$this->IdZavodu' AND poradi_podzavodu = '$poradi_podzavodu'";
	    echo $sql;
	    $sth = $this->db->prepare($sql);
	    $sth->execute();
	    if($sth->rowCount()){
		$data1 =  $sth->fetchObject();
		$this->kategorie = $data1->nazev_k;
		$this->kod_kategorie = $data1->kod_k;
		$this->id_kategorie = $data1->id_kategorie;
	    }
	}   
	
	private function VyberKategoriePodleNazvu($poradi_podzavodu,$kod_kategorie){
	    isset($this->udaje['pohlavi_1']) ? $pohlavi = $this->udaje['pohlavi_1'] : ''; 
	    $vek = date('Y') - $this->udaje['rok_narozeni_1'];
	    $sql = "SELECT * FROM kategorie_{$this->RokZavodu} WHERE id_zavodu = '$this->IdZavodu' AND kod_k LIKE '$kod_kategorie' AND poradi_podzavodu = '$poradi_podzavodu'";
	    //echo $sql;
	    $sth = $this->db->prepare($sql);
	    $sth->execute();
	    if($sth->rowCount()){
		$data1 =  $sth->fetchObject();
		$this->kategorie = $data1->nazev_k;
		$this->kod_kategorie = $data1->kod_k;
		$this->id_kategorie = $data1->id_kategorie;
	    }
	}   
	private function VyberKategorieBezPohlavi($poradi_podzavodu){
	    isset($this->udaje['pohlavi_1']) ? $pohlavi = $this->udaje['pohlavi_1'] : ''; 
	    $vek = date('Y') - $this->udaje['rok_narozeni'];
	    $sql = "SELECT * FROM kategorie_{$this->RokZavodu} WHERE id_zavodu = '$this->IdZavodu' AND '$vek' BETWEEN vek_start AND vek_konec AND poradi_podzavodu = '$poradi_podzavodu'";
	    //echo $sql;
	    $sth = $this->db->prepare($sql);
	    $sth->execute();
	    if($sth->rowCount()){
		$data1 =  $sth->fetchObject();
		$this->kategorie = $data1->nazev_k;
		$this->kod_kategorie = $data1->kod_k;
		$this->id_kategorie = $data1->id_kategorie;
	    }

	    }
	
	private function VyberKategorieBezPoradiPodzavodu(){
	    isset($this->udaje['pohlavi']) ? $pohlavi = $this->udaje['pohlavi'] : ''; 
	    $vek = date('Y') - $this->udaje['rok_narozeni'];
	    $sql = "SELECT * FROM kategorie_{$this->RokZavodu} WHERE id_zavodu = '$this->IdZavodu' AND pohlavi = '$pohlavi' AND '$vek' BETWEEN vek_start AND vek_konec";
	    //echo $sql;
	    $sth = $this->db->prepare($sql);
	    $sth->execute();
	    if($sth->rowCount()){
		$data1 =  $sth->fetchObject();
		$this->kategorie = $data1->nazev_k;
		$this->kod_kategorie = $data1->kod_k;
		$this->id_kategorie = $data1->id_kategorie;
		$this->poradi_podzavodu = $data1->poradi_podzavodu; //toto se ber z db pouze v tomto případě, kdy pořadí podzávodu neputuje s formuářem
	    }
	}
	
	
	
	private function VyberKategoriePodleId($id_kategorie){
    	    $sql1 = "SELECT nazev_k FROM kategorie_{$this->RokZavodu} WHERE id_kategorie = '$id_kategorie'";
	    //echo $sql1;
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		$dbdata1 = $sth1->fetchObject();
		return $dbdata1->nazev_k;
	    }
	}
	
	
	
	private function Vek(){
	    if(isset($this->udaje['rok_narozeni'])){
		$this->vek =  date('Y') - $this->udaje['rok_narozeni'];
	    }
	}
	
	private function StartovneZDB(){
	    $sql1 = "SELECT * FROM prihlasky_startovne_{$this->RokZavodu} WHERE prihlasky_startovne_{$this->RokZavodu}.id_zavodu = $this->IdZavodu";
	    //echo $sql1;
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		while($dbdata1 = $sth1->fetchObject()){
		    if($dbdata1->id_meny == 1){
			$this->startovne_z_db_kc = $dbdata1->castka;
			if($dbdata1->vychozi_startovne){
			    $this->vychozi_startovne = $this->startovne_z_db_kc;
			}
		    }
		    elseif($dbdata1->id_meny == 2){
			$this->startovne_z_db_eu = $dbdata1->castka;
			if($dbdata1->vychozi_startovne){
			    $this->vychozi_startovne = $this->startovne_z_db_eu;
			}

		    }
		}
	    }
	}
	
	private function Startovne(){
	    //$this->StartovneZDB();
	    if($this->IdZavodu == 20){ //pedalovnik
		if($this->udaje['poradi_podzavodu'] == 1){
		    $this->startovne_eu = $this->startovne_z_db_eu;
		}
		elseif($this->udaje['poradi_podzavodu'] == 2){
		    $this->vychozi_startovne = 200;
		    $this->startovne_eu = $this->vychozi_startovne;;
		}
		else{
		    $this->startovne_eu = 0;
		    $this->vychozi_startovne = 0;
		}
	    }
            
            elseif($this->IdZavodu == 25){ //Vetrkovice
                    if($this->udaje['tricko'] != "bez"){
			$this->vychozi_startovne = $this->vychozi_startovne + 220;
		    }
		$this->startovne_kc = $this->vychozi_startovne;
	    }
            
            elseif($this->IdZavodu == 54){ //Kytlice
		if($this->udaje['poradi_podzavodu'] == 1){
                    /*
                    if($this->udaje['tricko'] != "bez"){
			$this->vychozi_startovne = $this->vychozi_startovne + 200;
		    }
                     * */
                     
                    $this->vychozi_startovne = 200;
		}
		else{
		    $this->vychozi_startovne = 300;
                    /*
                    for($i = 1;$i <= 3;$i++){
			if($this->udaje['tricko_'.$i]){
			    $this->vychozi_startovne += 200; 
			}
                    } */
		}
		$this->startovne_kc = $this->vychozi_startovne;
	    }
	    
                        
            elseif($this->IdZavodu == 21){ //Majetin
		if($this->udaje['poradi_podzavodu'] == 1){
                    if(isset($this->udaje['dalsi_udaje_1'])){
                        $this->vychozi_startovne = 250;
                    }
                }
		else{
		    $this->vychozi_startovne = 600;
		}
		$this->startovne_kc = $this->vychozi_startovne;
	    }
	    
            elseif($this->IdZavodu == 83){ //Nezmar
		if($this->udaje['poradi_podzavodu'] == 2){
                    $this->vychozi_startovne = 550;
                }

		$this->startovne_kc = $this->vychozi_startovne;
	    }
            
            
            
            
	    
	    elseif($this->IdZavodu == 23){ //BBL
		if($this->udaje['poradi_podzavodu'] <= 3){
		    $vek =  date('Y') - $this->udaje['rok_narozeni'];
                    if($vek <= 18){
                        $this->vychozi_startovne = 300;
                    }
                    if($this->udaje['tricko'] != "bez"){
			$this->vychozi_startovne = $this->vychozi_startovne + 150;
		    }
		}
		else{
		    $this->vychozi_startovne = 100;
		    if($this->udaje['tricko'] != "bez"){
			$this->vychozi_startovne = $this->vychozi_startovne + 150;
		    }
		}
		$this->startovne_kc = $this->vychozi_startovne;
	    }
	    
	    
	    
	    
	    elseif($this->IdZavodu == 76){ //radegastova vyzva, 13km
		$vek =  date('Y') - $this->udaje['rok_narozeni'];
		if($this->udaje['poradi_podzavodu'] == 1){
		    if($vek <= 15){
			$this->vychozi_startovne = 0;
			if($this->udaje['tricko']){
			    $this->vychozi_startovne = 200; 
			}
		    }
		    else{
			if($this->udaje['tricko']){
			    $this->vychozi_startovne = $this->vychozi_startovne + 200; 
			}
		    }
		}
		else{
		    $this->vychozi_startovne = 0;
		    if($this->udaje['tricko']){
			$this->vychozi_startovne = 200; 
		    }
		}
		$this->startovne_kc = $this->vychozi_startovne;
		
		
		
	    }
	    
	    
	    
	    elseif($this->IdZavodu == 29){ //odrivous
		if($this->udaje['poradi_podzavodu'] < 3){
		    $this->startovne_kc = $this->vychozi_startovne;
		}
	    }

	    elseif($this->IdZavodu == 47){ //100 pro adru
		$this->vychozi_startovne = $this->vychozi_startovne * 2;
		$this->startovne_kc = $this->vychozi_startovne;
	    }

	    elseif($this->IdZavodu == 33){
		if($this->udaje['rok_narozeni'] >= 2002){ //děcka
		    $this->vychozi_startovne = 50;
		    //if($this->udaje['tricko'] != "Bez trička"){
			//$this->vychozi_startovne = $this->vychozi_startovne + 200;
		    //}
		    $this->startovne_kc = $this->vychozi_startovne;
		}
		else{
		    //if($this->udaje['tricko'] !=  "Bez trička"){
			//$this->vychozi_startovne = $this->vychozi_startovne + 200;
		    //}
		    
                    $this->startovne_kc = $this->vychozi_startovne;
		}
	    }
	    
	    

	    elseif($this->IdZavodu == 39){ //hlucin
		if($this->udaje['poradi_podzavodu'] == 1){
		    $this->startovne_kc = $this->startovne_z_db_kc;
		}
		elseif($this->udaje['poradi_podzavodu'] == 2){
		    $this->vychozi_startovne = 120;
		    $this->startovne_kc = $this->vychozi_startovne;
		}
		else{ //40km
		    $this->vychozi_startovne = 200;
		    $this->startovne_kc = $this->vychozi_startovne;
		}
	    }
	    
	    
	    
	    elseif($this->IdZavodu == 41){ //radegastova výzva
		$pocet_clenu = Session::get('pocet_clenu');
		$this->vychozi_startovne = $this->vychozi_startovne * $pocet_clenu;
		$this->startovne_kc = $this->vychozi_startovne;
		for($i=1;$i<=$pocet_clenu;$i++){
		    if($this->udaje['tricko_'.$i]){
			$this->vychozi_startovne = $this->vychozi_startovne + 200;
			$this->startovne_kc = $this->startovne_kc + 200;
		    }
		}
	    }

	    
	    
	    
	    
	    elseif($this->IdZavodu == 46){ //sport bar bikemarathon
		if($this->udaje['poradi_podzavodu'] == 1){
		    $this->startovne_kc = $this->startovne_z_db_kc;
		}
		elseif($this->udaje['poradi_podzavodu'] == 2){
		    $this->vychozi_startovne = 300;
		    $this->startovne_kc = $this->vychozi_startovne;
		}
	    }

	    elseif($this->IdZavodu == 19){ //jihlava pulmaraton
                if($this->udaje['poradi_podzavodu'] == 1){
                    $this->startovne_kc = $this->startovne_z_db_kc; 
                }
                elseif($this->udaje['poradi_podzavodu'] == 2){
                    $this->startovne_kc = $this->startovne_z_db_kc * 2; 
                }
                elseif($this->udaje['poradi_podzavodu'] == 3){
                    $this->startovne_kc = $this->startovne_z_db_kc * 4; 
                }
                
                elseif($this->udaje['poradi_podzavodu'] == 4){
		    $pocet_clenu = Session::get('pocet_clenu');
                    $this->startovne_kc = 0;
                    for($i = 1;$i <= $pocet_clenu;$i++){
                        $vek =  date('Y') - $this->udaje['rok_narozeni_'.$i];
                        if($vek < 15){
                            $this->startovne_kc += 20;
                            if($this->udaje['tricko_'.$i]){
                                $this->startovne_kc += 120; 
                            }
                        }
                        else{
                            $this->startovne_kc += 70;
                            if($this->udaje['tricko_'.$i]){
                                $this->startovne_kc += 120; 
                            }
                        }
		    }

                }
                elseif($this->udaje['poradi_podzavodu'] == 5){
                    $this->startovne_kc = 350;
                }
                $this->vychozi_startovne = $this->startovne_kc;
            }
	    
	    
	    elseif($this->IdZavodu == 9){ //jihlava 24
		
		if($this->udaje['poradi_podzavodu'] == 1){
		    if($this->udaje['tricko']){
			$this->vychozi_startovne += 250; //db
		    }
		    if(isset($this->udaje['dalsi_udaje_2'])){
			$this->vychozi_startovne += 306; //db
		    }
		    $this->startovne_kc = $this->vychozi_startovne; //mail
		}
		
		elseif ($this->udaje['poradi_podzavodu'] == 2) {
		    $pocet_clenu = 2;
		    $this->vychozi_startovne = $this->startovne_z_db_kc * $pocet_clenu;
		    for($i = 1;$i <= $pocet_clenu;$i++){
			if($this->udaje['tricko_'.$i]){
			    $this->vychozi_startovne += 250; //db
			}
			if(isset($this->udaje['dalsi_udaje_2_'.$i])){
			    $this->vychozi_startovne += 306; //db
			}

		    }
		}
		
		elseif ($this->udaje['poradi_podzavodu'] == 3) {
		    $pocet_clenu = 4;
		    $this->vychozi_startovne = $this->startovne_z_db_kc * $pocet_clenu;
		    for($i = 1;$i <= $pocet_clenu;$i++){
			if($this->udaje['tricko_'.$i]){
			    $this->vychozi_startovne += 250; //db
			}
			if(isset($this->udaje['dalsi_udaje_2_'.$i])){
			    $this->vychozi_startovne += 306; //db
			}

		    }
		}
		
		elseif ($this->udaje['poradi_podzavodu'] == 4) {
		    $pocet_clenu = Session::get('pocet_clenu');
		    $this->vychozi_startovne = $this->startovne_z_db_kc * $pocet_clenu;
		    for($i = 1;$i <= $pocet_clenu;$i++){
			if($this->udaje['tricko_'.$i]){
			    $this->vychozi_startovne += 250; //db
			}
			if(isset($this->udaje['dalsi_udaje_2_'.$i])){
			    $this->vychozi_startovne += 306; //db
			}

		    }
		}
		
		elseif ($this->udaje['poradi_podzavodu'] == 5) {
		    //$this->vychozi_startovne = $this->startovne_z_db_kc - 200;
		    //Nachystáno po období po 2.5.2016
		    $this->vychozi_startovne = $this->startovne_kc - 300;
		    if($this->udaje['tricko']){
			$this->vychozi_startovne += 250; //db
		    }
		    if(isset($this->udaje['dalsi_udaje_2'])){
			$this->vychozi_startovne += 306; //db
		    }
		    $this->startovne_kc = $this->vychozi_startovne; //mail
		}
		
		elseif ($this->udaje['poradi_podzavodu'] == 6) {
		    $pocet_clenu = 2;
		    //$this->vychozi_startovne = ($this->startovne_z_db_kc - 200) * $pocet_clenu;
		    //Nachystáno po období po 2.5.2016
		    $this->vychozi_startovne = ($this->startovne_z_db_kc - 300) * $pocet_clenu;
		    for($i = 1;$i <= $pocet_clenu;$i++){
			if($this->udaje['tricko_'.$i]){
			    $this->vychozi_startovne += 250; //db
			}
			if(isset($this->udaje['dalsi_udaje_2_'.$i])){
			    $this->vychozi_startovne += 306; //db
			}

		    }
		}
	    }	    

            elseif($this->IdZavodu == 10 || $this->IdZavodu == 8){ //zilina + kuchyna
		if($this->udaje['poradi_podzavodu'] == 1){
		    if($this->udaje['tricko']){
			$this->vychozi_startovne = $this->startovne_z_db_eu + 5; //db
		    }
		    $this->startovne_eu = $this->vychozi_startovne; //mail
		}
		
		elseif($this->udaje['poradi_podzavodu'] == 2){
		    $this->vychozi_startovne = $this->vychozi_startovne * 2;
		    for($i=1;$i<=2;$i++){
			if($this->udaje['tricko_'.$i]){
			    $this->vychozi_startovne = $this->vychozi_startovne + 5;
			}
		    }
		    $this->startovne_eu = $this->vychozi_startovne;
		}
		
		elseif($this->udaje['poradi_podzavodu'] == 3){
		    $this->vychozi_startovne = $this->vychozi_startovne * 4;
		    for($i=1;$i<=4;$i++){
			if($this->udaje['tricko_'.$i]){
			    $this->vychozi_startovne = $this->vychozi_startovne + 5;
			}
		    }
		    $this->startovne_eu = $this->vychozi_startovne;
		}
		
	    }
	    

	    elseif($this->IdZavodu == 11){ //nachod
		if($this->udaje['poradi_podzavodu'] == 1){
		    $this->startovne_kc = $this->vychozi_startovne; //mail
		}
		
		elseif($this->udaje['poradi_podzavodu'] == 2){
		    $this->vychozi_startovne = $this->vychozi_startovne * 2;
		    $this->startovne_kc = $this->vychozi_startovne;
		}
		
		elseif($this->udaje['poradi_podzavodu'] == 3){
		    $this->vychozi_startovne = $this->vychozi_startovne * 4;
		    $this->startovne_kc = $this->vychozi_startovne;
		}
		
		elseif($this->udaje['poradi_podzavodu'] == 4){
		    $this->vychozi_startovne = $this->startovne_z_db_kc - 200;
		    $this->startovne_kc = $this->vychozi_startovne; //mail
		}


	    }
	    
	    
	    
	    elseif($this->IdZavodu == 12){ //opava
		if($this->udaje['poradi_podzavodu'] == 1){
		    if($this->udaje['tricko']){
			$this->vychozi_startovne = $this->startovne_z_db_kc + 150; //db
		    }
		    $this->startovne_kc = $this->vychozi_startovne; //mail
		}
		
		elseif($this->udaje['poradi_podzavodu'] == 2){
		    $this->vychozi_startovne = $this->vychozi_startovne * 2;
		    for($i=1;$i<=2;$i++){
			if($this->udaje['tricko_'.$i]){
			    $this->vychozi_startovne = $this->vychozi_startovne + 150;
			}
		    }
		    $this->startovne_kc = $this->vychozi_startovne;
		}
		
		elseif($this->udaje['poradi_podzavodu'] == 3){
		    $this->vychozi_startovne = $this->vychozi_startovne * 4;
		    for($i=1;$i<=4;$i++){
			if($this->udaje['tricko_'.$i]){
			    $this->vychozi_startovne = $this->vychozi_startovne + 150;
			}
		    }
		    $this->startovne_kc = $this->vychozi_startovne;
		}
		//rozdíl mezi startovným výchozím na 24 a 12 po 30.6 změnit na 500 (teď 300), ale radeji jěště zkontrolovat 
		elseif($this->udaje['poradi_podzavodu'] == 4){
		    $this->vychozi_startovne = $this->startovne_z_db_kc - 300;
		    if($this->udaje['tricko']){
			$this->vychozi_startovne = $this->vychozi_startovne + 150; //db
		    }
		    $this->startovne_kc = $this->vychozi_startovne; //mail
		}

		elseif($this->udaje['poradi_podzavodu'] == 5){
		    $this->vychozi_startovne = ($this->vychozi_startovne - 300) * 2;
		    for($i=1;$i<=2;$i++){
			if($this->udaje['tricko_'.$i]){
			    $this->vychozi_startovne = $this->vychozi_startovne + 150;
			}
		    }
		    $this->startovne_kc = $this->vychozi_startovne;
		}
	    }

	    
	    elseif($this->IdZavodu == 50){ //belsky okruh
		if($this->udaje['poradi_podzavodu'] == 1){
		    $this->startovne_kc = $this->startovne_z_db_kc;
		}
		else{
		    $this->vychozi_startovne = 50;
		    $this->startovne_kc = $this->vychozi_startovne;
		}
	    }
	    
	    
	    
            elseif($this->IdZavodu == 121){
                if(!isset($this->udaje['vmg'])){
                    $this->vychozi_startovne = 150;
                }
                $this->startovne_kc = $this->vychozi_startovne;
            }

	    
	    
	    
	    
	    else{ //default
		$this->startovne_kc = $this->startovne_z_db_kc;
		$this->startovne_eu = $this->startovne_z_db_eu;
	    }
	}	

	
	
	
	
	
	
	
	
	

// startovné z 2015, už se to nepoužívá, ponecháno zatím do rezervy
	private function VyberStartovneho2015(){
	    $sql1 = "SELECT prihlasky_startovne_{$this->RokZavodu}.castka,mena.nazev_meny FROM prihlasky_startovne_{$this->RokZavodu},mena WHERE prihlasky_startovne_{$this->RokZavodu}.id_zavodu = '$this->IdZavodu' AND prihlasky_startovne_{$this->RokZavodu}.id_meny = mena.id_meny";
	    //echo $sql1;
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		if($sth1->rowCount() == 1){
		    $dbdata1 = $sth1->fetchObject();
		    $this->startovne_z_db = $dbdata1->castka;
		    $this->mena = $dbdata1->nazev_meny;
		}
		else{
		    //nachystáno pro situaci, až bude startovné v jiných částkách a jiných měnách
		}
	    }
	}
	
	
	
	
	
	
	private function VypocetStartovneho_2015(){
	    if($this->IdZavodu == 3000){ //je kvůli else zatím
	    }
	    
	    elseif($this->IdZavodu == 84){ 
		$vek =  date('Y') - $this->udaje['rok_narozeni'];
		if($vek <= 15){
		    $this->startovne = 50;
		}
		else{
		   $this->startovne =  $this->startovne_z_db; 
		}
		
		
	    }
	    elseif($this->IdZavodu == 99 OR $this->IdZavodu == 101){
		$this->startovne == 0;
	    }
	    elseif($this->IdZavodu == 5){ //zilina + kuchyna
		if($this->udaje['poradi_podzavodu'] == 1){
		    $this->startovne = $this->startovne_z_db;
		    if($this->udaje['tricko']){
			$this->startovne = $this->startovne + 5;
		    }
		    if($this->udaje['dalsi_udaje_2']){
			$this->startovne = $this->startovne + 30;
		    }

		}
		if($this->udaje['poradi_podzavodu'] == 2){
		    $this->startovne = $this->startovne_z_db * 2;
		    for($i=1;$i<=2;$i++){
			if($this->udaje['tricko_'.$i]){
			    $this->startovne = $this->startovne + 5;
			}
			if(isset($this->udaje['dalsi_udaje_2_'.$i])){
			    $this->startovne = $this->startovne + 30;
			}
		    }
		}
		if($this->udaje['poradi_podzavodu'] == 3){
		    $this->startovne = $this->startovne_z_db * 4;
		    for($i=1;$i<=4;$i++){
			if($this->udaje['tricko_'.$i]){
			    $this->startovne = $this->startovne + 5;
			}
			if(isset($this->udaje['dalsi_udaje_2_'.$i])){
			    $this->startovne = $this->startovne + 30;
			}

		    }
		}
		
		//echo $this->startovne;
	    }
	    elseif($this->IdZavodu == 10){
		$pocet_clenu = Session::get('pocet_clenu');
		$this->startovne = $this->startovne_z_db * $pocet_clenu;
		for($i=1;$i<=$pocet_clenu;$i++){
		    if($this->udaje['tricko_'.$i]){
			$this->startovne = $this->startovne + 150;
		    }
		}
		if($this->udaje['dalsi_udaje_1'] == 'Stan'){
		    $this->startovne = $this->startovne + 100;
		}
	    }
	    
	    elseif($this->IdZavodu == 80){ //radegastova vyzva happening
		$this->startovne = $this->startovne_z_db;
		if($this->udaje['tricko']){
		    $this->startovne = $this->startovne_z_db + 150;
		}
	    }
	    
	    elseif($this->IdZavodu == 8){
		if($this->udaje['poradi_podzavodu'] < 3){
		    $this->startovne = $this->startovne_z_db;
		    //if($this->udaje['tricko']){
			//$this->startovne = $this->startovne_z_db + 240;
		    //}
		}
		else{
		    $this->startovne = 0;
		}
	    }
	    elseif($this->IdZavodu == 26){
		$this->startovne = $this->startovne_z_db;
		if($this->udaje['tricko']){
		    $this->startovne = $this->startovne_z_db + 220;
		}
	    }
	    
	    elseif($this->IdZavodu == 79){
		if($this->udaje['poradi_podzavodu'] == 1){
		    $this->startovne = $this->startovne_z_db;
		}
		else{
		    $this->startovne = 300;
		}
		
	    }
	    
	    
	    elseif($this->IdZavodu == 20){
		$zkratka = substr($this->udaje['tricko'],-6);
		
		
		if($zkratka == '(+135)'){
		    echo '135';
		    $this->startovne = $this->startovne_z_db + 135;
		}
		elseif($zkratka == '(+315)'){
		    echo '315';
		    $this->startovne = $this->startovne_z_db + 315;
		}
		else{
		    $this->startovne = $this->startovne_z_db;
		}
	    }
	    
	    
	    
	    
	    elseif($this->IdZavodu == 4){
		$this->startovne = $this->startovne_z_db;
		if($this->udaje['poradi_podzavodu'] == 2){
		    $this->startovne = 400;
		}
	    }
	    
	    
	    
	    
	    elseif($this->IdZavodu == 44){
		if($this->udaje['rok_narozeni'] >= 2001){ //děcka
		    $this->startovne = 50;
		}
		else{
		    if($this->udaje['tricko']){
			$this->startovne = $this->startovne_z_db + 200;
		    }
		    else{
			$this->startovne = $this->startovne_z_db;
		    }
		}
	    }
	    elseif($this->IdZavodu == 27){ //BBB
		if($this->udaje['poradi_podzavodu'] <= 2){
		    if($this->udaje['tricko']){
			$this->startovne = $this->startovne_z_db + 150;
		    }
		    else{
			$this->startovne = $this->startovne_z_db;
		    }
		    
		}
		else{
		   $this->startovne = 100; 
		}
		
	    }
	    

	    
	    else{ //default
		$this->startovne = $this->startovne_z_db;
	    }
	}	

	
	
	private function ZiskaniVS(){
	    $sql = "SELECT MAX(vs) as posledni_vs FROM vs_{$this->RokZavodu} WHERE id_zavodu = '$this->IdZavodu'";
	    $sth = $this->db->prepare($sql);
	    $sth->execute();
	    $data = $sth->fetchObject();
	    if($data->posledni_vs > 0){
		$this->vs = $data->posledni_vs + 1;
	    }
	    else{
		$sql1 = "SELECT vychozi_vs FROM prihlasky_{$this->RokZavodu} WHERE id_zavodu = $this->IdZavodu";
		$sth1 = $this->db->prepare($sql1);
		$sth1->execute(Array(
		    ':id_zavodu' => $this->IdZavodu
		));
		if($sth1->rowCount()){
		    $data1 = $sth1->fetchObject();
		    $this->vs = $data1->vychozi_vs;
		}
	    }
	}
	
	public function Prevod(){
	    $sql1 = "SELECT * FROM prihlasky_perun_skymarathon_2015 ORDER BY id";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    while($dbdata1 = $sth1->fetchObject()){
		$sql2 = "INSERT INTO prihlasky_jednotlivci_2015 (id_zavodu,jmeno_1,prijmeni_1,prislusnost,pohlavi,datum_narozeni,stat,mail,telefon_1,telefon_2,tricko,poradi_podzavodu,"
			  . "id_kategorie,startovne,zaplaceno,datum_prihlaseni,vzkaz) VALUES('3','$dbdata1->jmeno_1','$dbdata1->prijmeni_1','$dbdata1->prislusnost_1',"
			  . "'$dbdata1->pohlavi_1','$dbdata1->datum_narozeni_1','$dbdata1->stat','$dbdata1->mail','$dbdata1->telefon_1','$dbdata1->telefon_2','$dbdata1->tricko_1',"
			  . "'$dbdata1->poradi_podzavodu','$dbdata1->id_kategorie','$dbdata1->startovne','$dbdata1->zaplaceno','$dbdata1->datum_prihlaseni','$dbdata1->vzkaz')";
		$sth2 = $this->db->prepare($sql2);
		//$sth2->execute();
		$id_prihlasky = $this->db->lastInsertId();
		$sql3 = "INSERT INTO vs_2015 (id_zavodu,id_prihlasky,typ_prihlasky,vs) VALUES ('3','$id_prihlasky','1','$dbdata1->vs')";
		$sth3 = $this->db->prepare($sql3);
		//$sth3->execute();
	    }
	}





	private function VypisPrihlasekEnduro(){
	    $str = '';
	    $sql1 =  "SELECT * FROM etapy WHERE id_zavodu = :id_zavodu AND rok_zavodu = :rok_zavodu ORDER BY id_etapy";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute(Array(':id_zavodu' => $this->IdZavodu,':rok_zavodu' => $this->RokZavodu));
	    if($sth1->rowCount()){
		while($dbdata1 = $sth1->fetchObject()){
		    $sql2 = "SELECT $this->sqlzavod.*,osoby.*,tymy.*,$this->sqlkategorie.*,$this->sqlpodzavody.*,znacky_motocyklu.nazev_motocyklu FROM $this->sqlzavod,osoby,tymy,$this->sqlpodzavody,$this->sqlkategorie,znacky_motocyklu WHERE "
			      . "$this->sqlzavod.id_etapy = $dbdata1->id_etapy AND "
			      . "$this->sqlzavod.ido = osoby.ido AND "
			      . "$this->sqlzavod.id_tymu = tymy.id_tymu AND "
			      . "$this->sqlpodzavody.id_zavodu = $this->IdZavodu AND "
			      . "$this->sqlzavod.id_kategorie = $this->sqlkategorie.id_kategorie AND "
			      . "$this->sqlzavod.poradi_podzavodu = $this->sqlpodzavody.poradi_podzavodu AND "
			      . "$this->sqlzavod.id_motocyklu = znacky_motocyklu.id_motocyklu "
			      . "ORDER BY $this->sqlzavod.ids";
		    //echo $sql2;
		    $sth2 = $this->db->prepare($sql2);
		    $sth2->execute();
		    if($sth2->rowCount()){
			$pocet_prihlasenych = $sth2->rowCount();
			$str .= '<h3>'.$dbdata1->nazev_etapy.' ('.$pocet_prihlasenych.' přihlášených)</h3>';
			$str .= '<table class="table table-hover table-condensed table-striped">';
			$str .= '<thead>';
			$str .= '<th class="text-center">#</th>';
			$str .= '<th>Příjmení a jméno</th>';
			$str .= '<th>Tým</th>';
			$str .= '<th class="text-center">Ročník</th>';
			$str .= '<th class="text-center">Stát</th>';
			$str .= '<th class="text-center">Třída</th>';
			$str .= '<th>Kategorie</th>';
			$str .= '<th>Motocykl</th>';
			$str .= '</thead>';
			while($dbdata2 = $sth2->fetchOBject()){
			    $str .= '<tr>';
			    $str .= '<td class="text-center">'.$dbdata2->ids.'</td>';
			    $str .= '<td>'.$dbdata2->prijmeni.' '.$dbdata2->jmeno.'</td>';
			    $str .= '<td>'.$dbdata2->nazev_tymu.'</td>';
			    $str .= '<td class="text-center">'.$dbdata2->rocnik.'</td>';
			    $str .= '<td class="text-center">'.$dbdata2->psc.'</td>';
			    $str .= '<td class="text-center">'.$dbdata2->nazev.'</td>';
			    $str .= '<td>'.$dbdata2->nazev_k.'</td>';
			    $str .= '<td>'.$dbdata2->nazev_motocyklu.'</td>';
			    $str .= '</tr>';

			}
			$str .= '</table><br />';
		    }
		}
	    }
	    return $str;
	}
	
	
	
	
	
	public function VypisPrihlasek(){
	    //$this->Prevod();
	    $str = false;
	    if($this->IdZavodu == 13 OR $this->IdZavodu == 500){
		$str .= $this->VypisPrihlasekEnduro();
	    }
	    elseif($this->IdZavodu == 114 OR $this->IdZavodu == 1010){ //cc hobby
		$sql2 = "SELECT $this->sqlprihlaskyjednotlivci.*,DATE_FORMAT($this->sqlprihlaskyjednotlivci.datum_narozeni,'%Y') AS rocnik,$this->sqlkategorie.nazev_k AS nazev_kategorie,$this->sqlkategorie.id_kategorie FROM $this->sqlprihlaskyjednotlivci,$this->sqlkategorie WHERE $this->sqlprihlaskyjednotlivci.id_zavodu = :id_zavodu AND $this->sqlprihlaskyjednotlivci.poradi_podzavodu = :poradi_podzavodu AND $this->sqlprihlaskyjednotlivci.id_kategorie = $this->sqlkategorie.id_kategorie "
			  . "ORDER BY "
			  . "$this->sqlprihlaskyjednotlivci.ids ASC";
		//echo $sql2;
		$sth2 = $this->db->prepare($sql2);
		$sth2->execute(Array(':id_zavodu' => $this->IdZavodu,':poradi_podzavodu' => 1));
		if($sth2->rowCount()){
		    $k = 1;
                    $sql3 = "SELECT (SELECT COUNT(id_prihlasky) from $this->sqlprihlaskyjednotlivci where id_zavodu = :id_zavodu AND id_kategorie IS NOT NULL) AS celkem";
                    $sth3 = $this->db->prepare($sql3);
                    $sth3->execute(Array(':id_zavodu' => $this->IdZavodu));
                    if($sth3->rowCount()){
                        $dbdata3 = $sth3->fetchObject();
                        $str .= '<p class="text-right"><i style="font-size:12px">Přihlášeno '.$dbdata3->celkem.' závodníků</i></p>';
                    }
		    $str .= '<table class="table table-striped table-hover table-condensed">';
		    $str .= '<thead>';
		    $str .= '<th class="text-center">St.č</th>';
		    $str .= '<th>Příjmení a jméno</th>';
		    $str .= '<th>Tým nebo bydliště</th>';
		    $str .= '<th class="text-center">Ročník</th>';
		    $str .= '<th class="text-center">Stát</th>';
		    $str .= '<th>Kategorie</th>';
		    $str .= '</thead>';
		    while($dbdata2 = $sth2->fetchObject()){
			$str .= '<tr>';
			$str .= '<td class="text-center">'.$dbdata2->ids.'</td>';
			$str .= '<td>'.$dbdata2->prijmeni_1.' '.$dbdata2->jmeno_1.'</td>';
			$str .= '<td>'.$dbdata2->prislusnost.'</td>';
			$str .= '<td class="text-center">'.$dbdata2->rocnik.'</td>';
			$str .= '<td class="text-center">'.$dbdata2->stat.'</td>';
			$str .= '<td>'.$dbdata2->nazev_kategorie.'</td>';
			$str .= '</tr>';
			$k++;
		    }
		    $str .= '</table>';
		}

	    }
	    else{ //default           
		for($i=1;$i<=$this->pocet_podzavodu;$i++){
		    $sql1 = "SELECT nazev AS nazev_podzavodu,typ_zavodnika FROM $this->sqlpodzavody WHERE id_zavodu = '$this->IdZavodu' AND poradi_podzavodu = :poradi_podzavodu";
		    $sth1 = $this->db->prepare($sql1);
		    $sth1->execute(Array(':poradi_podzavodu' => $i));
		    if($sth1->rowCount()){
			$dbdata1 = $sth1->fetchObject();
			$racer_type = $dbdata1->typ_zavodnika;
			if($racer_type == 1){
			    $sql2 = "SELECT $this->sqlprihlaskyjednotlivci.*,DATE_FORMAT($this->sqlprihlaskyjednotlivci.datum_narozeni,'%Y') AS rocnik,$this->sqlkategorie.nazev_k AS nazev_kategorie,$this->sqlkategorie.id_kategorie FROM $this->sqlprihlaskyjednotlivci,$this->sqlkategorie WHERE $this->sqlprihlaskyjednotlivci.id_zavodu = :id_zavodu AND $this->sqlprihlaskyjednotlivci.poradi_podzavodu = :poradi_podzavodu AND $this->sqlprihlaskyjednotlivci.id_kategorie = $this->sqlkategorie.id_kategorie "
				      . "ORDER BY "
				      . "$this->sqlprihlaskyjednotlivci.zaplaceno ASC,"
				      . "$this->sqlprihlaskyjednotlivci.prijmeni_1 ASC";
			    //echo $sql2;
			    $sth2 = $this->db->prepare($sql2);
			    $sth2->execute(Array(':id_zavodu' => $this->IdZavodu,':poradi_podzavodu' => $i));
			    if($sth2->rowCount()){
				$k = 1;
				if($this->pocet_podzavodu > 1){
				    $str .= '<h3>'.$dbdata1->nazev_podzavodu;
				    $sql3 = "SELECT "
					      . "(SELECT COUNT(id_prihlasky) from $this->sqlprihlaskyjednotlivci where id_zavodu = :id_zavodu and poradi_podzavodu = :i AND id_kategorie IS NOT NULL) AS celkem,"
					      . "(SELECT COUNT(id_prihlasky) from $this->sqlprihlaskyjednotlivci where id_zavodu = :id_zavodu and zaplaceno like 'zaplaceno' and poradi_podzavodu = :i AND id_kategorie IS NOT NULL) AS zaplaceno,"
					      . "(SELECT COUNT(id_prihlasky) from $this->sqlprihlaskyjednotlivci where id_zavodu = :id_zavodu and zaplaceno like 'nezaplaceno' and poradi_podzavodu = :i AND id_kategorie IS NOT NULL) AS nezaplaceno";
				    $sth3 = $this->db->prepare($sql3);
				    $sth3->execute(Array(':id_zavodu' => $this->IdZavodu,':i' => $i));
				    if($sth3->rowCount()){
					$dbdata3 = $sth3->fetchObject();
					$str .= '<br /><i style="font-size:12px">Přihlášeno - '.$dbdata3->celkem.', Zaplaceno - '.$dbdata3->zaplaceno.', Nezaplaceno - '.$dbdata3->nezaplaceno.'</i>';
				    }
				   $str .= '</h3>';
				}
				$str .= '<table class="table table-hover table-striped table-condensed" style="margin-bottom:70px">';
				$str .= '<thead>';
				//$str .= '<th class="text-center" style="width:4%">#</th>';
				$str .= '<th style="width:24%">Příjmení a jméno</th>';
				$str .= '<th style="width:30%">Tým nebo bydliště</th>';
				$str .= '<th style="width:5%" class="text-center">Ročník</th>';
				$str .= '<th style="width:5%" class="text-center">Stát</th>';
				$str .= '<th style="width:24%" class="text-center">Kategorie</th>';
				$str .= '<th  style="width:8%" class="text-center">Startovné</th>';
				$str .= '</thead>';
				while($dbdata2 = $sth2->fetchObject()){
				    $str .= '<tr>';
				    //$str .= '<td class="text-center">'.$k.'</td>';
				    $str .= '<td>'.$dbdata2->prijmeni_1.' '.$dbdata2->jmeno_1.'</td>';
				    $str .= '<td>'.$dbdata2->prislusnost.'</td>';
				    $str .= '<td class="text-center">'.$dbdata2->rocnik.'</td>';
				    $str .= '<td class="text-center">'.$dbdata2->stat.'</td>';
				    $str .= '<td class="text-center">'.$dbdata2->nazev_kategorie.'</td>';
				    $str .= '<td class="text-center">'.$dbdata2->zaplaceno.'</td>';
				    $str .= '</tr>';
				    $k++;
				}
				$str .= '</table><br />';
			    }
			}
			elseif($racer_type == 2){
			    $sql1 = "SELECT $this->sqlprihlaskytymy.*,$this->sqlkategorie.nazev_k AS nazev_kategorie,$this->sqlkategorie.id_kategorie FROM $this->sqlprihlaskytymy,$this->sqlkategorie WHERE $this->sqlprihlaskytymy.id_zavodu = :id_zavodu AND $this->sqlprihlaskytymy.id_kategorie = $this->sqlkategorie.id_kategorie AND $this->sqlprihlaskytymy.poradi_podzavodu = :poradi_podzavodu ORDER BY zaplaceno ASC,nazev_tymu ASC,$this->sqlkategorie.id_kategorie ASC";
			    $sth1 = $this->db->prepare($sql1);
			    $sth1->execute(Array(':id_zavodu' => $this->IdZavodu ,':poradi_podzavodu' => $i));
			    if($sth1->rowCount()){
				if($this->pocet_podzavodu > 1){
				    $str .= '<h3>'.$dbdata1->nazev_podzavodu.'</h3>';
				}
				$str .= '<table class="table table-condensed">';
				$str .= '<thead>';
				$str .= '<th class="text-center">#</th>';
				$str .= '<th>Název týmu</th>';
				$str .= '<th>Kategorie</th>';
				$str .= '<th>Členové</th>';
				$str .= '<th class="text-center">Ročník</th>';
				$str .= '<th class="text-center">Stát</th>';
				$str .= '<th class="text-center">Startovné</th>';
				$str .= '</thead>';
				$k = 1;
				while($dbdata1 = $sth1->fetchObject()){
				    $sql2 = "SELECT *,DATE_FORMAT(datum_narozeni,'%Y') AS rocnik FROM $this->sqlprihlaskyjednotlivci WHERE id_prihlasky_tymu = :id_prihlasky_tymu ORDER BY id_prihlasky ASC";
				    //echo $sql2."<br />";
				    $sth2 = $this->db->prepare($sql2);
				    $sth2->execute(Array(':id_prihlasky_tymu' => $dbdata1->id_prihlasky));
				    if($sth2->rowCount()){
					$pocet_clenu = $sth2->rowCount();
					$x = 1;
					while($dbdata2 = $sth2->fetchObject()){
					    if($x == 1){
						$str .= '<tr>';
						$str .= '<td rowspan="'.$pocet_clenu.'" class="text-center rowspan">'.$k.'</td>';
						$str .= '<td rowspan="'.$pocet_clenu.'" class="rowspan">'.$dbdata1->nazev_tymu.'</td>';
						$str .= '<td rowspan="'.$pocet_clenu.'" class="rowspan">'.$dbdata1->nazev_kategorie.'</td>';
						$str .= '<td>'.$dbdata2->prijmeni_1.' '.$dbdata2->jmeno_1.'</td>';
						$str .= '<td class="text-center">'.$dbdata2->rocnik.'</td>';
						$str .= '<td class="text-center">'.$dbdata2->stat.'</td>';
						$str .= '<td rowspan="'.$pocet_clenu.'" class="rowspan text-center">'.$dbdata1->zaplaceno.'</td>';
						$str .= '</tr>';

					    }
					    else{
						$str .= '<tr>';
						$str .= '<td>'.$dbdata2->prijmeni_1.' '.$dbdata2->jmeno_1.'</td>';
						$str .= '<td class="text-center">'.$dbdata2->rocnik.'</td>';
						$str .= '<td class="text-center">'.$dbdata2->stat.'</td>';
						$str .= '</tr>';
					    }
					
					$x++;    
					}
				    }
				    $k++;
				}

			    $str .= '</table><br /><br />';

			    }
			}
		    }
		}
	    }
	    return $str;
	}

	
	
	
	
	
	public function Radkovani($i){
	    (fmod($i,2) == 0) ? ($radek = "sudy") : ($radek = "lichy");
	    return $radek;
	}
	public function Radkovani1($i){
	    (fmod($i,2) == 0) ? ($radek = "sudy1") : ($radek = "lichy1");
	    return $radek;
	}
	
	
	public function Reklamy(){
	    $sql1 = "SELECT * FROM reklamy_na_prihlasky WHERE id_zavodu = '$this->IdZavodu' AND rok_zavodu = '$this->RokZavodu' ORDER BY poradi";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		return $sth1->fetchAll();
	    }
	}
	
	public function VyberKategorii(){
	    //moc se mi tahle metoda nelíbí
	    
	    // tady to zkusí vybrat kategorie podle pořadí podzávodu v případě, že je to typ jako FESTINA a spol, kdež se nejprve vybírá typ přihlášky a ukládá se to právě do SESSION
	    $sql1 = "SELECT id_kategorie,nazev_k FROM kategorie_".$this->RokZavodu." WHERE id_zavodu = '".$this->IdZavodu."' AND poradi_podzavodu = '".Session::get('poradi_podzavodu')."' ORDER BY poradi";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		return $sth1->fetchAll();
	    }
	    else{
		//pokud nic nenajde, tzn. pokud se nic to session neposílá, taks e hledá kategorie bez pořadí podzávodu
		$sql = false;
		$sql1 = "SELECT id_kategorie,nazev_k FROM kategorie_".$this->RokZavodu." WHERE id_zavodu = $this->IdZavodu ORDER BY poradi";
		$sth1 = $this->db->prepare($sql1);
		$sth1->execute();
		if($sth1->rowCount()){
		    return $sth1->fetchAll();
		}
	    }
	}

	
	
	public function VyberKategoriiXHR(){
	    $str = Array();
	    $sql1 = "SELECT nazev AS nazev_podzavodu, poradi_podzavodu FROM $this->sqlpodzavody WHERE id_zavodu = $this->IdZavodu ORDER BY poradi_podzavodu";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		$i = 0;
		while($dbdata1 = $sth1->fetch(PDO::FETCH_ASSOC)){
		    $str[$i] = $dbdata1;
		    $sql2 = "SELECT id_kategorie, nazev_k AS nazev_kategorie FROM $this->sqlkategorie WHERE id_zavodu = $this->IdZavodu AND poradi_podzavodu = {$dbdata1['poradi_podzavodu']} ORDER BY poradi";
		    $sth2 = $this->db->prepare($sql2);
		    $sth2->execute();
		    if($sth2->rowCount()){
			while($dbdata2 = $sth2->fetchAll(PDO::FETCH_ASSOC)){
			    $str[$i]['kategorie'] = $dbdata2;
			}
		    }
		$i++;  
		}
		//print_r($str);
		echo json_encode($str);
	    }
	}

	
	
	public function SeznamStatu(){
	    $stat = Array();
	    $stat['CZE'] = 'Česká republika';
	    $stat['DEU'] = 'Germany';
	    $stat['HUN'] = 'Hungary';
            $stat['ITA'] = 'Italy';
            $stat['KEN'] = 'Kenya';
    	    $stat['POL'] = 'Poland';
	    $stat['RUS'] = 'Russia';
	    $stat['SVK'] = 'Slovenská republika';
	    $stat['SWE'] = 'Sweden';
	    $stat['UKR'] = 'Ukraine';
	    $stat['GBR'] = 'United Kingdom';
	    $stat['USA'] = 'United States';
	    return $stat;
	}
	
	public function Ponozky(){
	    $noha = Array();
	    $noha['36-39'] = '36-39';
	    $noha['40-42'] = '40-42';
	    $noha['43-45'] = '43-45';
	    $noha['46-48'] = '46-48';
	    return $noha;
	}
	
	
	public function Tricka(){
	    $tricka = Array();
	    $tricka['S'] = 'S';
	    $tricka['M'] = 'M';
	    $tricka['L'] = 'L';
	    $tricka['XL'] = 'XL';
	    $tricka['XXL'] = 'XXL';
	    return $tricka;
	}
	
	public function Tricka1(){
	    $tricka = Array();
	    $tricka['DS'] = 'Dámské S';
	    $tricka['DM'] = 'Dámské M';
	    $tricka['DL'] = 'Dámské L';
	    $tricka['DXL'] = 'Dámské XL';
	    $tricka['S'] = 'Pánské S';
	    $tricka['M'] = 'Pánské M';
	    $tricka['L'] = 'Pánské L';
	    $tricka['XL'] = 'Pánské XL';
	    $tricka['XXL'] = 'Pánské XXL';
	    return $tricka;
	}
	
	public function VyberPodzavodu(){
	    $str = '';
	    $sql1 = "SELECT nazev AS nazev_podzavodu, poradi_podzavodu FROM $this->sqlpodzavody WHERE id_zavodu = $this->IdZavodu ORDER BY poradi_podzavodu";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		$sth1->setFetchMode(PDO::FETCH_OBJ);
		return $sth1->fetchAll();
	    }
	}
	public function ZnackyMotocyklu(){
	    $sql1 = "SELECT * FROM znacky_motocyklu ORDER BY nazev_motocyklu";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		$sth1->setFetchMode(PDO::FETCH_OBJ);
		return $sth1->fetchAll();
	    }
	}
	
	public function ZdravotniPojistovny(){
	    $str = '';
	    $sql1 = "SELECT * FROM zdravotni_pojistovny ORDER BY nazev_pojistovny";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		$sth1->setFetchMode(PDO::FETCH_OBJ);
		return $sth1->fetchAll();
	    }
	}
	
	
	private function TypyLicence(){
	    $sql1 = "SELECT * FROM typ_licence ORDER BY id_typu_licence";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		$sth1->setFetchMode(PDO::FETCH_OBJ);
		return $sth1->fetchAll();
	    }
	}
	private function TymyEnduro(){
	    $sql1 = "SELECT id_tymu,nazev_tymu FROM tymy WHERE id_enduro IS NOT NULL ORDER BY id_enduro";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		$sth1->setFetchMode(PDO::FETCH_OBJ);
		return $sth1->fetchAll();
	    }
	}
	
	private function DveTCtyriT(){
	    $sql1 = "SELECT * FROM 2t4t ORDER BY id_2t4t";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		$sth1->setFetchMode(PDO::FETCH_OBJ);
		return $sth1->fetchAll();
	    }
	}
	
	private function pocty_valcu(){
	    $sql1 = "SELECT * FROM pocty_valcu ORDER BY pocet_valcu";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		$sth1->setFetchMode(PDO::FETCH_OBJ);
		return $sth1->fetchAll();
	    }
	}
	public function objemy_motoru(){
	    $sql1 = "SELECT * FROM objemy_motoru ORDER BY objem_motoru";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		$sth1->setFetchMode(PDO::FETCH_OBJ);
		return $sth1->fetchAll();
	    }
	}
	
	private function RacerData(){
	    $sql1 = "SELECT osoby.*,osoby.psc AS stat,osoby.den AS den_narozeni,osoby.mesic AS mesic_narozeni,osoby_cizi_zdroje.*,osoby_cizi_zdroje.startovni_cislo AS race_number,osoby.mesic AS mesic_narozeni,osoby_cizi_zdroje.*,osoby_cizi_zdroje.kod_pojistovny AS zdravotni_pojistovna FROM osoby,osoby_cizi_zdroje WHERE osoby.ido = {$_GET['ido']} AND osoby.ido = osoby_cizi_zdroje.ido AND osoby_cizi_zdroje.id_serialu = 1 AND osoby_cizi_zdroje.rok_serialu = $this->RokZavodu AND osoby_cizi_zdroje.startovni_cislo = {$_GET['startovni_cislo']}";
	    //echo $sql1."\n";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
		$sth1->setFetchMode(PDO::FETCH_ASSOC);
		return $sth1->fetchAll();
	    }
	}
	
	
	
	public function DataEnduro(){
	    $str = Array();
	    $str['racer_data'] = $this->RacerData();
	    $str['pocty_valcu'] = $this->pocty_valcu();
	    $str['objemy_motoru'] = $this->objemy_motoru();
	    $str['seznam_2t4t'] = $this->DveTCtyriT();
	    $str['staty'] = $this->SeznamStatu();
	    $str['zdravotni_pojistovny'] = $this->ZdravotniPojistovny();
	    $str['typy_licence'] = $this->TypyLicence();
	    $str['znacky_motocyklu'] = $this->ZnackyMotocyklu();
	    $str['tymy'] = $this->TymyEnduro();
	    echo json_encode($str);
	}
	
	
	private function RedukceDiakritiky($old_string) {
	    setlocale(LC_CTYPE, "cs_CZ.utf-8"); // kvůli ICONV na Linuxu a knihovně GLIBC
	    $new_string = $old_string;
	    $new_string = preg_replace('~[^\\pL0-9_]+~u', '_', $new_string);
	    $new_string = trim($new_string, "_");
	    $new_string = iconv("utf-8", "us-ascii//TRANSLIT", $new_string);
	    $new_string = strtolower($new_string);
	    $new_string = preg_replace('~[^-a-z0-9_]+~', '', $new_string);
	    return $new_string;
	}
	
	
	public function OvereniUdajuEnduro(){
	    $str = Array();
	    //$sql1 = "SELECT osoby.ido FROM osoby,osoby_cizi_zdroje WHERE osoby_cizi_zdroje.startovni_cislo = {$_GET['race_number']} AND osoby.mail LIKE '{$_GET['mail']}' AND osoby.ido = osoby_cizi_zdroje.ido  AND osoby_cizi_zdroje.id_serialu = 1";
	    $sql1 = "SELECT ido FROM osoby_cizi_zdroje WHERE startovni_cislo = {$_GET['race_number']} AND mail LIKE '{$_GET['mail']}' AND id_serialu = 1 AND rok_serialu = $this->RokZavodu";
	    //echo $sql1."\n";
	    $sth1 = $this->db->prepare($sql1);
	    //$sth1->execute(Array(':race_number' => $_GET['race_number'],':mail' => $_GET['mail']));
	    $sth1->execute();
	    if($sth1->rowCount()){
		$dbdata1 =  $sth1->fetchObject();
		$str['ido'] = $dbdata1->ido; 
		$str['startovni_cislo'] = $_GET['race_number']; 
	    }
	    echo json_encode($str);
	}

	
	
	
	
} 
?>