<?php
class Prihlaska_Model extends Model{
   public $sqlzavody;
	public $sqlprihlasky;
	public $NazevZavodu;
	public $kod_zavodu;
	public $IdZavodu;
	private $cislo_uctu;
	public $udaje;
	private $kategorie;
	private $vs;
	private $startovne_z_db;
	private $startovne;
	private $konec_prihlasek;
	private $mena;
	private $poradatel;
	private $telefon_na_poradatele;
	private $mail_na_poradatele;
	public $mail_na_zavodnika;
    
	function __construct() {
		parent::__construct();
		Session::init();
		$this->IdZavodu = Session::get('race_id');
		
	
		
		
		$data = false;
		$this->sqlzavody = 'zavody_2013';
		
		$sql1 = "SELECT * FROM $this->sqlzavody WHERE id_zavodu = :id_zavodu";
		$sth = $this->db->prepare($sql1);
		$sth->execute(array(
            ':id_zavodu' => $this->IdZavodu
		));
		if($sth->rowCount()){
			$data =  $sth->fetchAll();
			foreach($data as $val){
				$this->NazevZavodu = $val['nazev_zavodu'];
				$this->kod_zavodu = $val['kod_zavodu'];
			}
				$this->sqlprihlasky = 'prihlasky_'.$this->kod_zavodu.'_2013';
		}
	}
   

	public function xhrOvereni($id_zavodu){
		Session::set('udaje',serialize($_POST));
		$str = false;
		$pohlavi = Array("M" => "Muž","Z" => "Žena");
		//if($id_zavodu == '82'){// Deza Valachiarun
			$str .= '<table id="overeni">';
			$str .= (isset($_POST['jmeno']) && isset($_POST['prijmeni'])) ? ('<tr><td class="align_leftleft">Jméno a příjmení</td><td class="align_right">'.$_POST['jmeno'].' '.$_POST['prijmeni'].'</td></tr>') : ('');
			$str .= (isset($_POST['pohlavi'])) ? ('<tr><td class="align_leftleft">Pohlaví</td><td class="align_right">'.$pohlavi[$_POST['pohlavi']].'</td></tr>') : ('');
			$str .= (isset($_POST['den_narozeni']) && isset($_POST['mesic_narozeni']) && isset($_POST['rok_narozeni'])) ? ('<tr><td class="align_leftleft">Datum narození</td><td class="align_right">'.$_POST['den_narozeni'].'.'.$_POST['mesic_narozeni'].'.'.$_POST['rok_narozeni'].'</td></tr>') : ('');
			$str .= (isset($_POST['oddil'])) ? ('<tr><td class="align_leftleft">Tým nebo bydliště</td><td class="align_right">'.$_POST['oddil'].'</td></tr>') : ('');
			$str .= (isset($_POST['stat'])) ? ('<tr><td class="align_leftleft">Stát</td><td class="align_right">'.$_POST['stat'].'</td></tr>') : ('');
			$str .= (isset($_POST['velikost_tricka'])) ? ('<tr><td class="align_leftleft">Tričko</td><td class="align_right">'.$_POST['velikost_tricka'].'</td></tr>') : ('');
			$str .= (isset($_POST['mail'])) ? ('<tr><td class="align_leftleft">E-mail</td><td class="align_right">'.$_POST['mail'].'</td></tr>') : ('');
			$str .= (isset($_POST['telefon_1'])) ? ('<tr><td class="align_leftleft">Telefon</td><td class="align_right">'.$_POST['telefon_1'].'</td></tr>') : ('');
			$str .= (!empty($_POST['telefon_2'])) ? ('<tr><td class="align_leftleft">Alternativní telefon</td><td class="align_right">'.$_POST['telefon_2'].'</td></tr>') : ('');
			$str .= (!empty($_POST['vzkaz_poradateli'])) ? ('<tr><td class="align_leftleft">Vzkaz pořadateli</td><td class="align_right">'.$_POST['vzkaz_poradateli'].'</td></tr>') : ('');
			$str .= '</table>';
			$str .= '<form action="'.URL.'prihlaska/xhrRepair" method="post" id="opravit_udaje" class="kontrolni_tabulka">';
			$str .= '<input type="submit" value="Opravit údaje" />&nbsp;Zvolte v případě, že údaje potřebuje opravit';
			$str .= '</form>';
			$str .= '<form action="'.URL.'prihlaska/xhrFinish/'.$this->IdZavodu.'" method="post" id="odeslat_prihlasku" class="kontrolni_tabulka">';
			$str .= '<input type="submit" value="Odeslat přihlášku" />&nbsp;Zvolte v případě, že údaje jsou OK a můžete se přihlásit';
			$str .= '</form>';
			//echo $str;
			return $str;
	}
	
	public function xhrFinish($id_zavodu){
		//tady ještě zkontrolovat, jestli se ty SESSIONS nedají udělat nějak jinak
		(Session::get('udaje') == true) ? ($this->udaje = unserialize(Session::get('udaje'))) : ($this->udaje = false);
		$this->mail_na_zavodnika = $this->udaje['mail'];
		$str = false;
		$sql1 = "SELECT *,DATE_FORMAT(konec_prihlasek,'%e.%c.%Y') AS konec_prihlasek FROM prihlasky_2013 WHERE id_zavodu = :id_zavodu";
		//echo $sql1;
		$sth1 = $this->db->prepare($sql1);
		$sth1->execute(array(
            ':id_zavodu' => $this->IdZavodu
		));
		if($sth1->rowCount()){
			$data1 =  $sth1->fetchObject();
			$this->cislo_uctu = $data1->cislo_uctu;
			$this->vs = $data1->posledni_vs+1;
			$this->startovne_z_db = $data1->startovne;
			$this->poradatel = $data1->poradatel;
			$this->mena = $data1->mena;
			$this->telefon_na_poradatele = $data1->telefon;
			$this->mail_na_poradatele = $data1->mail;
			$this->konec_prihlasek = $data1->konec_prihlasek;
			
		}
		
		$this->VyberKategorie($id_zavodu);
		$this->Startovne($id_zavodu);
		
		$this->xhrSaveToDB($id_zavodu);
		
		
		
	}
	
	
	
	
	
	private function xhrSaveToDB($id_zavodu){
		$str = false;
			$vlozeni = Array();
  			(isset($this->udaje['jmeno'])) ? ($vlozeni['jmeno'] = $this->udaje['jmeno']) : ('');
  			(isset($this->udaje['prijmeni'])) ? ($vlozeni['prijmeni'] = $this->udaje['prijmeni']) : ('');
  			(isset($this->udaje['oddil'])) ? ($vlozeni['prislusnost'] = $this->udaje['oddil']) : ('');
			(isset($this->udaje['stat'])) ? ($vlozeni['stat'] = $this->udaje['stat']) : ('');
			if(isset($this->udaje['den_narozeni']) && isset($this->udaje['mesic_narozeni']) && isset($this->udaje['rok_narozeni'])){
				 $vlozeni['datum_narozeni'] = $this->udaje['rok_narozeni'].'-'.$this->udaje['mesic_narozeni'].'-'.$this->udaje['den_narozeni'];
			}
			(isset($this->udaje['mail'])) ? ($vlozeni['mail'] = $this->udaje['mail']) : ('');
			(isset($this->udaje['telefon_1'])) ? ($vlozeni['telefon'] = $this->udaje['telefon_1']) : ('');	
			(isset($this->udaje['telefon_2'])) ? ($vlozeni['nahradni_telefon'] = $this->udaje['telefon_2']) : ('');	
			(isset($this->udaje['telefon_2'])) ? ($vlozeni['nahradni_telefon'] = $this->udaje['telefon_2']) : ('');		
			(isset($this->kategorie)) ? ($vlozeni['kategorie'] = $this->kategorie) : ('');	
			(isset($this->udaje['velikost_tricka'])) ? ($vlozeni['velikost_tricka'] = $this->udaje['velikost_tricka']) : ('');	
			(isset($this->udaje['vzkaz_poradateli'])) ? ($vlozeni['vzkaz'] = $this->udaje['vzkaz_poradateli']) : ('');
			(isset($this->startovne)) ? ($vlozeni['startovne'] = $this->startovne) : ('');
			(isset($this->vs)) ? ($vlozeni['vs'] = $this->vs) : ('');
			/* v této situaci asi nelze použít připravaný dotaz, chtělo by to kouknout na bezpečnost */ 
			$sql1 = "INSERT INTO $this->sqlprihlasky (".implode(",",array_keys($vlozeni)).") VALUES ('".implode("','",$vlozeni)."')";
			//echo $sql1;
			$sth1 = $this->db->prepare($sql1);
			if($sth1->execute()){
				$this->MailZavodnikovi($id_zavodu);
				$this->UpdateVS($id_zavodu);
				unset($_SESSION['udaje']);
				unset($_POST);
			}
		}
		
		
		public function MailZavodnikovi($id_zavodu){
				require "./libs/phpmailer/class.phpmailer.php";
				$mail1 = new PHPMailer();
				$mail1->IsSMTP();
				$mail1->Host = "smtp.webneta.cz";                                      
				$mail1->From = "timechip@timechip.cz";
				$mail1->FromName = "TimeChip";
				$mail1->AddAddress($this->udaje['mail']);
				$mail1->IsHTML(true);
				$mail1->Subject = $this->NazevZavodu.", předběžná registrace";
				$mail1->Body = false;
				if($id_zavodu == 82){ //Deza Valachiarun
					$mail1->Body .= 'Dobrý den, děkujeme za přihlášku k závodu '.$this->NazevZavodu.'.<br />';
					$mail1->Body .= '<hr />';
					$mail1->Body .= 'Vaše údaje jsou:<br />';
					$mail1->Body .= "Jméno a příjmení: {$this->udaje['jmeno']} {$this->udaje['prijmeni']}<br />"; 
					$mail1->Body .= "Oddíl nebo místo bydliště: {$this->udaje['oddil']}<br />";
					$mail1->Body .= "Datum narození: {$this->udaje['den_narozeni']}.{$this->udaje['mesic_narozeni']}.{$this->udaje['rok_narozeni']}<br />";
					$mail1->Body .= "Velikost trička: {$this->udaje['velikost_tricka']}<br />"; 	
					$mail1->Body .= "Telefon: {$this->udaje['telefon_1']}<br />";
					$mail1->Body .= '<hr />';
					if($this->udaje['poradi_podzavodu'] == 1){ //pouze běh na 10km
						$mail1->Body .= 'V případě, že budete chtít využít zvýhodněné startovné, je nutné do '.$this->konec_prihlasek.' realizovat platbu podle následujících údajů:<br />';
						$mail1->Body .= 'Číslo účtu: '.$this->cislo_uctu.'<br />';
						$mail1->Body .= 'Částka: '.$this->startovne.$this->mena.'<br />';
						$mail1->Body .= 'Variabilní symbol: '.$this->vs.'<br />';
						$mail1->Body .= '<hr />';
					}	
					$mail1->Body .= $this->poradatel.'<br />';
					$mail1->Body .= 'E-mail: <a href="mailto:'.$this->mail_na_poradatele.'">'.$this->mail_na_poradatele.'</a><br />';
					$mail1->Body .= 'Tel: '.$this->telefon_na_poradatele;
					$mail1->Body .= '<hr />';
				}
				if(!$mail1->Send()){
					echo "<p>Vznikl nějaký problém a zpráva nebyla odeslána. Pokud můžete, kontaktujte nás prosím buď telefonicky na 776131313, nebo pomocí e-mailu na adresu <a href=\"mailto:timechip@timechip.cz\">timechip@timechip.cz</a>.</p>";
					exit;
				}
			}		


	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	private function VyberKategorie($id_zavodu){
		$sthis->kategorie = false;
		$vek = date('Y') - $this->udaje['rok_narozeni'];
		if($id_zavodu == 82){ //Deza Valachiarun
			
			if($this->udaje['poradi_podzavodu'] == 2){ // Běh 2km
				$pohlavi = 'B';
				}
			else{
				$pohlavi = $this->udaje['pohlavi'];
				}
			
			$sql = "SELECT * FROM kategorie_2013 WHERE id_zavodu = :id_zavodu AND poradi_podzavodu = :poradi_podzavodu AND pohlavi = :pohlavi AND :vek BETWEEN vek_start AND vek_konec";
		
			//echo $sql;
			$sth = $this->db->prepare($sql);
			$sth->execute(Array(
				 ':id_zavodu' => $this->IdZavodu, ':poradi_podzavodu' => $this->udaje['poradi_podzavodu'],':pohlavi' => $pohlavi,':vek' => $vek
			));
			if($sth->rowCount()){
				$data1 =  $sth->fetchObject();
				$this->kategorie = $data1->nazev_k;
			}
		} 
	}
	
	
	
	private function Startovne($id_zavodu){
		if($id_zavodu == 82){ //Deza Valachiarun
			switch($this->udaje['poradi_podzavodu']){
				case 1;
					$this->startovne = $this->startovne_z_db;
				break;
				case 2;
					$this->startovne = 0;
				break;
				case 3:
					$this->startovne = 0;
				break;
				default:
					$this->startovne = $this->startovne_z_db;
			}
		}
	}
		
	private function UpdateVS($id_zavodu){
		$sql = "UPDATE prihlasky_2013 SET posledni_vs = '$this->vs' WHERE id_zavodu = :id_zavodu";
		//echo $sql;
		$sth = $this->db->prepare($sql);
		$sth->execute(array(
			 ':id_zavodu' => $id_zavodu
		));
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	 
	
	
} 
?>
