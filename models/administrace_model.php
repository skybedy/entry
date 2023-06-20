<?php

class Administrace_Model extends Model{
	
	public $sqlzavody;
	public $sqlprihlasky;
	public $NazevZavodu;
	public $kod_zavodu;
	public $IdZavodu;
	public $sqlprihlaskyjednotlivci;
	public $sqlprihlaskytymy;
	private $sqlkategorie;
	private $sqlvs;
	public $typ_zavodnika;
	public $pocet_podzavodu;
        public $sqlpodzavody;
        public $sqlprihlasky_startovne;

	
	function __construct() {
	    parent::__construct();
	    $this->IdZavodu = Session::get('race_id');
	    $this->sqlzavody = 'zavody_'.YEAR;
	    $sql1 = "SELECT * FROM $this->sqlzavody WHERE id_zavodu = :id_zavodu";
	    $sth = $this->db->prepare($sql1);
	    $sth->execute(array(':id_zavodu' => $this->IdZavodu));
	    if($sth->rowCount()){
		$data =  $sth->fetchAll();
		foreach($data as $val){
		    $this->NazevZavodu = $val['nazev_zavodu'];
		    $this->kod_zavodu = $val['kod_zavodu'];
		}
		$this->sqlprihlasky = 'prihlasky_'.YEAR;
                $this->sqlprihlasky_startovne = 'prihlasky_startovne_'.YEAR;
		$this->sqlprihlaskyjednotlivci = 'prihlasky_jednotlivci_'.YEAR;
		$this->sqlprihlaskytymy = 'prihlasky_tymy_'.YEAR;
		$this->sqlkategorie = 'kategorie_'.YEAR;
                $this->sqlpodzavody = 'podzavody_'.YEAR;
		$this->sqlvs = 'vs_'.YEAR;
	    }
	}
    
	public function Index(){
	    $str = Array('jednotlivci' => '', 'tymy' => '');
	    $sql1 = "SELECT typ_zavodnika FROM podzavody_".YEAR." WHERE id_zavodu = :id_zavodu GROUP BY typ_zavodnika ORDER BY typ_zavodnika"; 
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute(Array(':id_zavodu' => $this->IdZavodu));
	    if($sth1->rowCount()){
		while($dbdata1 = $sth1->fetchObject()){
		    if($dbdata1->typ_zavodnika == 1){
			$str['jednotlivci'] = $this->AdministraceJednotlivci();
		    }
		    if($dbdata1->typ_zavodnika == 2 || $dbdata1->typ_zavodnika == 3 ||  $dbdata1->typ_zavodnika == 4 || $dbdata1->typ_zavodnika == 6 ){
			$str['tymy'] = $this->Administracetymy();
		    }
		}
	    }
	    return $str;
	}
	
	private function AdministraceTymy(){
	    $fcdata = '';
	    $nove_pole = Array();
	    $sql1 = "SELECT $this->sqlprihlaskytymy.*,$this->sqlvs.*,$this->sqlkategorie.nazev_k AS nazev_kategorie FROM $this->sqlprihlaskytymy,$this->sqlvs,$this->sqlkategorie "
		      . "WHERE "
		      . "$this->sqlprihlaskytymy.id_zavodu = $this->IdZavodu AND "
		      . "$this->sqlvs.typ_prihlasky = 2 AND "
		      . "$this->sqlvs.id_prihlasky = $this->sqlprihlaskytymy.id_prihlasky AND "
		      . "$this->sqlkategorie.id_kategorie = $this->sqlprihlaskytymy.id_kategorie  "
		. "ORDER BY $this->sqlvs.vs ASC";
	    //echo $sql1;
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    
	    
	    if($sth1->rowCount()){
		$fcdata = (object) array();
		$fcdata = Array();
		$sth1->setFetchMode(PDO::FETCH_ASSOC);
		$dbdata1 = $sth1->fetchAll();
		for($i=0;$i<count($dbdata1);$i++){
		    $fcdata[$i] = $dbdata1[$i]; 
		    
		    $sql2 = "SELECT *,CONCAT_WS(' ',prijmeni_1,jmeno_1) AS jmeno FROM $this->sqlprihlaskyjednotlivci WHERE id_prihlasky_tymu = {$dbdata1[$i]['id_prihlasky']}";
		    $sth2 = $this->db->prepare($sql2);
		    $sth2->execute();
		    if($sth2->rowCount()){
			$sth2->setFetchMode(PDO::FETCH_ASSOC);
			$dbdata2 = $sth2->fetchAll();
			   array_push($fcdata[$i],$dbdata2);
		    }   
		}
	    } 
	    return $fcdata;
	}
	
	
	
	public function ExportExcelTymy(){
	    $sql1 = "SELECT $this->sqlprihlaskytymy.*,$this->sqlvs.*,$this->sqlkategorie.nazev_k AS nazev_kategorie FROM $this->sqlprihlaskytymy,$this->sqlvs,$this->sqlkategorie "
		      . "WHERE "
		      . "$this->sqlprihlaskytymy.id_zavodu = $this->IdZavodu AND "
		      . "$this->sqlvs.typ_prihlasky = 2 AND "
		      . "$this->sqlvs.id_prihlasky = $this->sqlprihlaskytymy.id_prihlasky AND "
		      . "$this->sqlkategorie.id_kategorie = $this->sqlprihlaskytymy.id_kategorie  "
		      . "ORDER BY $this->sqlvs.vs ASC";
	   // echo $sql1;
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute();
	    if($sth1->rowCount()){
			$file = "C://webapps/export_tymy.csv";
			$fp = fopen ($file,"w+");

			$csv = "";


		$i=1;



		while($dbdata1 = $sth1->fetchOBject()){

			$csv .= "$dbdata1->vs;";
			$csv .= "$dbdata1->nazev_tymu;";
			$csv .= "$dbdata1->nazev_kategorie;";
			$csv .= "$dbdata1->mail;";
			$csv .= "$dbdata1->telefon_1;";
			$csv .= "$dbdata1->startovne;";
			$csv .= "$dbdata1->zaplaceno;";
			$csv .= "$dbdata1->dalsi_udaje_1;";
			$csv .= "$dbdata1->dalsi_udaje_2;";
			$csv .= "$dbdata1->dalsi_udaje_3;";
			$csv .= "$dbdata1->vzkaz;";
			$csv .= "$dbdata1->datum_prihlaseni;";
		      
		
			
		    $sql2 = "SELECT *,CONCAT_WS(' ',prijmeni_1,jmeno_1) AS jmeno FROM $this->sqlprihlaskyjednotlivci WHERE id_prihlasky_tymu = $dbdata1->id_prihlasky";
			$sth2 = $this->db->prepare($sql2);
			$sth2->execute();
			if($sth2->rowCount()){
			    $pocet_jednotlivcu = $sth2->rowCount();
			    $k = 1;
			    while($dbdata2 = $sth2->fetchObject()){
					$csv .= "$dbdata2->jmeno;";
					$csv .= "$dbdata2->datum_narozeni;";
					$csv .= "$dbdata2->pohlavi;";
					$csv .= "$dbdata2->prislusnost;";
					$csv .= "$dbdata2->stat;";
					$csv .= "$dbdata2->mail;";
					$csv .= "$dbdata2->telefon_1;";
					$csv .= "$dbdata2->telefon_2;";
					$csv .= "$dbdata2->tricko;";
					$csv .= "$dbdata2->ponozky;";
					$csv .= "$dbdata2->dalsi_udaje_1;";
					$csv .= "$dbdata2->dalsi_udaje_2;";
					$csv .= "$dbdata2->dalsi_udaje_3;";
				    $k++;
			    }
			
			}
		    $csv .= "\r\n";
		    $i++;
		}

		echo $csv;
		fwrite($fp,$csv);

		
	    }

		
	    }

		public function ExportExcelTymyZal(){
			$excel_sloupce = Array('A','B','C','D','E','F','G','I','J','K','L','M');
			
			
			 require "./libs/phpexcel/Classes/PHPExcel.php";
			 
			/** Error reporting */
			   error_reporting(E_ALL);
			   ini_set('display_errors', TRUE);
			   ini_set('display_startup_errors', TRUE);
			   date_default_timezone_set('Europe/London');
	
			   if (PHP_SAPI == 'cli')
				   die('This example should only be run from a Web Browser');
			
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
			
			
			$sql1 = "SELECT $this->sqlprihlaskytymy.*,$this->sqlvs.*,$this->sqlkategorie.nazev_k AS nazev_kategorie FROM $this->sqlprihlaskytymy,$this->sqlvs,$this->sqlkategorie "
				  . "WHERE "
				  . "$this->sqlprihlaskytymy.id_zavodu = $this->IdZavodu AND "
				  . "$this->sqlvs.typ_prihlasky = 2 AND "
				  . "$this->sqlvs.id_prihlasky = $this->sqlprihlaskytymy.id_prihlasky AND "
				  . "$this->sqlkategorie.id_kategorie = $this->sqlprihlaskytymy.id_kategorie  "
				  . "ORDER BY $this->sqlvs.vs ASC";
		   // echo $sql1;
			$sth1 = $this->db->prepare($sql1);
			$sth1->execute();
			if($sth1->rowCount()){
			$i=1;
			while($dbdata1 = $sth1->fetchOBject()){
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i,$dbdata1->vs)
				->setCellValue('B'.$i,$dbdata1->nazev_tymu)
				->setCellValue('C'.$i,$dbdata1->nazev_kategorie)
				->setCellValue('D'.$i,$dbdata1->mail)
				->setCellValue('E'.$i,$dbdata1->telefon_1)
				->setCellValue('F'.$i,$dbdata1->startovne)
				->setCellValue('G'.$i,$dbdata1->zaplaceno)
				->setCellValue('H'.$i,$dbdata1->dalsi_udaje_1)
				->setCellValue('I'.$i,$dbdata1->dalsi_udaje_2)
				->setCellValue('J'.$i,$dbdata1->dalsi_udaje_3)
				->setCellValue('K'.$i,$dbdata1->vzkaz)
				->setCellValue('L'.$i,$dbdata1->datum_prihlaseni);
				  
			
				
				$sql2 = "SELECT *,CONCAT_WS(' ',prijmeni_1,jmeno_1) AS jmeno FROM $this->sqlprihlaskyjednotlivci WHERE id_prihlasky_tymu = $dbdata1->id_prihlasky";
				$sth2 = $this->db->prepare($sql2);
				$sth2->execute();
				if($sth2->rowCount()){
					$pocet_jednotlivcu = $sth2->rowCount();
					$k = 1;
					while($dbdata2 = $sth2->fetchObject()){
					   $objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($excel_sloupce[$k-1].'A'.$i,$dbdata2->jmeno)
						->setCellValue($excel_sloupce[$k-1].'B'.$i,$dbdata2->datum_narozeni)
						->setCellValue($excel_sloupce[$k-1].'C'.$i,$dbdata2->pohlavi)
						->setCellValue($excel_sloupce[$k-1].'D'.$i,$dbdata2->prislusnost)
						->setCellValue($excel_sloupce[$k-1].'E'.$i,$dbdata2->stat)
						->setCellValue($excel_sloupce[$k-1].'F'.$i,$dbdata2->mail)
						->setCellValue($excel_sloupce[$k-1].'G'.$i,$dbdata2->telefon_1)
						->setCellValue($excel_sloupce[$k-1].'H'.$i,$dbdata2->telefon_2)
						->setCellValue($excel_sloupce[$k-1].'I'.$i,$dbdata2->tricko)
						->setCellValue($excel_sloupce[$k-1].'J'.$i,$dbdata2->ponozky)
						->setCellValue($excel_sloupce[$k-1].'K'.$i,$dbdata2->dalsi_udaje_1)
						->setCellValue($excel_sloupce[$k-1].'L'.$i,$dbdata2->dalsi_udaje_2)
						->setCellValue($excel_sloupce[$k-1].'M'.$i,$dbdata2->dalsi_udaje_3);
						$k++;
					}
				
				}
				
				$i++;
			}
			}
	
			$objPHPExcel->getActiveSheet()->setTitle('Přihlášky tymy');
	
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
	
	
			// Redirect output to a client’s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="prihlasky_tymy.xls"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
	
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
	
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			
			exit;
			
			}
	












		private function AdministraceJednotlivci(){
            $typ_prihlasky = 1;
            if($this->IdZavodu == 1 AND YEAR == 2017){ //pouze KORUNA Beskyd
                $typ_prihlasky = 5;
            }
            
	    $sql1 = "SELECT "
		      . "$this->sqlprihlaskyjednotlivci.*,DATE_FORMAT($this->sqlprihlaskyjednotlivci.datum_prihlaseni,'%d.%m.%Y') AS datum_prihlaseni,$this->sqlvs.vs,$this->sqlkategorie.nazev_k AS kategorie,1 AS typ_prihlasky,$this->sqlpodzavody.nazev FROM $this->sqlprihlaskyjednotlivci,$this->sqlvs,$this->sqlkategorie,$this->sqlpodzavody "
		      . "WHERE "
		      . "$this->sqlvs.id_zavodu = :id_zavodu AND "
		      . "$this->sqlprihlaskyjednotlivci.id_prihlasky = $this->sqlvs.id_prihlasky AND "
		      . "$this->sqlvs.typ_prihlasky = :typ_prihlasky AND "
		      . "$this->sqlprihlaskyjednotlivci.id_kategorie = $this->sqlkategorie.id_kategorie AND "
                      . "$this->sqlpodzavody.id_zavodu = :id_zavodu AND "
                      . "$this->sqlpodzavody.poradi_podzavodu = $this->sqlprihlaskyjednotlivci.poradi_podzavodu "
		      . "ORDER BY $this->sqlvs.vs ASC";
	    $sth1 = $this->db->prepare($sql1);
	    $sth1->execute(Array(':id_zavodu' => $this->IdZavodu,':typ_prihlasky' => $typ_prihlasky));
	    if($sth1->rowCount()){
		$sth1->setFetchMode(PDO::FETCH_OBJ);
		return $sth1->fetchAll();
	    }
	}
	
	public function ZmenaUdaju(){
           
	    $arr = explode('|', $_POST['kategorie']);
	    $id_kategorie = $arr[0];
	    $poradi_podzavodu = $arr[1];
	    if($_POST['typ_prihlasky'] == 1){
		if(isset($_POST['delete'])){
		    $sql1 = "DELETE FROM $this->sqlprihlaskyjednotlivci WHERE id_prihlasky = '{$_POST['id_prihlasky']}' LIMIT 1";
		    $sth1 = $this->db->prepare($sql1);
		    $sth1->execute();
		    $sql2 = "DELETE FROM $this->sqlvs WHERE id_prihlasky = '{$_POST['id_prihlasky']}' AND typ_prihlasky = '1' LIMIT 1";
		    //echo $sql2;
		    $sth2 = $this->db->prepare($sql2);
		    $sth2->execute();
		}
		else{
                    
                    $sql = "UPDATE $this->sqlprihlaskyjednotlivci SET telefon_1 = '{$_POST['telefon_1']}', zaplaceno = '{$_POST['platba']}',mail = '{$_POST['mail']}',prislusnost = '{$_POST['prislusnost']}',prijmeni_1 = '{$_POST['prijmeni_1']}',jmeno_1 = '{$_POST['jmeno_1']}',startovne = '{$_POST['startovne']}',tricko = '{$_POST['tricko']}',id_kategorie = '$id_kategorie',poradi_podzavodu = '$poradi_podzavodu',poznamka_poradatele = '{$_POST['poznamka_poradatele']}',datum_narozeni = '{$_POST['datum_narozeni']}' WHERE id_prihlasky = '{$_POST['id_prihlasky']}'";
		    $sth = $this->db->prepare($sql);
		    $sth->execute();
                    if($_POST['platba'] == 'zaplaceno'){
                        $sql = "SELECT odeslano_potvrzeni FROM $this->sqlprihlaskyjednotlivci WHERE id_prihlasky = :id_prihlasky";
                        $sth = $this->db->prepare($sql);
                        $sth->execute(Array(':id_prihlasky' => $_POST['id_prihlasky']));
                        if($sth->rowCount()){
                            $dbdata = $sth->fetchObject();
                            if(!$dbdata->odeslano_potvrzeni){
                                $sql1 = "SELECT $this->sqlprihlasky.mail,$this->sqlprihlasky_startovne.id_meny FROM $this->sqlprihlasky,$this->sqlprihlasky_startovne WHERE $this->sqlprihlasky.id_zavodu = :id_zavodu AND $this->sqlprihlasky_startovne.id_zavodu = $this->sqlprihlasky.id_zavodu";
                                $sth1 = $this->db->prepare($sql1);
                                $sth1->execute(Array(':id_zavodu' => $this->IdZavodu));
                                if($sth1->rowCount()){
                                    $dbdata1 = $sth1->fetchObject();
                                    $mena = 'Kč';
                                    if($dbdata1->id_meny == 2){
                                        $mena = "€";
                                    }

                                    require_once "./libs/phpmailer/phpmailer/PHPMailerAutoload.php";
                                    $mail = new PHPMailer();
                                    $mail->IsSMTP();
                                    $mail->Host = SMTP;
                                    $mail->CharSet = 'UTF-8';
                                    $mail->addReplyTo($dbdata1->mail);
                                    $mail->setFrom('info@timechip.cz', 'TimeChip');
                                    $mail->AddAddress($_POST['mail']);

                                    $mail->IsHTML(true);
                                    $mail->Subject = $this->NazevZavodu.", potvrzení platby";
                                    $mail->Body = "";
									if($this->IdZavodu == 37 AND YEAR == 2022){
										$mail->Body .= 'Děkujeme Ti/vám za registraci do nového projektu "Zdolej Alpy s Lindou". <br>';								
										$mail->Body .= 'Přílohou mailu posíláme tabulku, do které si nezapomeň/te zaznamenávat své výkony.<br>';
										$mail->Body .= 'Po skončení projektu nám vyplněnou tabulku zašli na náš email <a href="mailto:info@nezavodim-pomaham.cz">info@nezavodim-pomaham.cz</a>';
										$mail->Body .= '<hr>';
										$mail->Body .= 'Pokud se chcete zařadit do slosování o hodnotné ceny našich partnerů, nezapomeňte sdílet foto vašich výkonů na IG s hashtagem #nezavodimpomaham a vyplnit tabulku, která vám po registraci dojde do emailu. Pamatujte na to, že čím větší počet příspěvků, tím vyšší je vaše šance na výhru.';
										$mail->Body .= '<hr>';
										$mail->Body .= 'Hodně štěstí přeje tým NF Nezávodím-Pomáhám';
										$mail->AddAttachment('./public/doc/tabulka_Alpy.xlsx', $name = '', $encoding = 'base64', $type = 'application/octet-stream');

									}
									else{
										$mail->Body .= "Potvrzujeme zaplacení startovneho ve výši {$_POST['startovne']} $mena.<br>";
										$mail->Body .= "Děkujeme a těšíme se na vaši účast";
									}
                                    if(!$mail->Send()){
                                        echo "<p>Vznikl nejaky problem a zprava nebyla odeslana. Pokud muzete, kontaktujte nas prosim bud telefonicky na 776131313, nebo pomoci e-mailu na adresu <a href=\"mailto:info@timechip.cz\">info@timechip.cz</a>.</p>";
                                        exit;
                                    }
                                    else{
                                        $sql2 = "UPDATE $this->sqlprihlaskyjednotlivci SET odeslano_potvrzeni = 1 WHERE id_prihlasky = {$_POST['id_prihlasky']}";
                                        //echo $sql2;
                                        $this->db->query($sql2);
                                    }
                                }
                            }
                        }
                        
                        
                        
                    }
                    
                    
                    
                    
		}
	    }
	    elseif($_POST['typ_prihlasky'] == 5){ //pouze KORUNA Beskyd
		if(isset($_POST['delete'])){
		    $sql1 = "DELETE FROM $this->sqlprihlaskyjednotlivci WHERE id_prihlasky = '{$_POST['id_prihlasky']}' LIMIT 1";
		    $sth1 = $this->db->prepare($sql1);
		    $sth1->execute();
		    $sql2 = "DELETE FROM $this->sqlvs WHERE id_prihlasky = '{$_POST['id_prihlasky']}' AND typ_prihlasky = '5' LIMIT 1";
		    //echo $sql2;
		    $sth2 = $this->db->prepare($sql2);
		    $sth2->execute();
		}
		else{
                    $sql = "UPDATE $this->sqlprihlaskyjednotlivci SET zaplaceno = '{$_POST['platba']}',mail = '{$_POST['mail']}',prislusnost = '{$_POST['prislusnost']}',prijmeni_1 = '{$_POST['prijmeni_1']}',jmeno_1 = '{$_POST['jmeno_1']}',startovne = '{$_POST['startovne']}',id_kategorie = '$id_kategorie' WHERE id_prihlasky = '{$_POST['id_prihlasky']}'";
		    //echo $sql1;
		    $sth = $this->db->prepare($sql);
		    $sth->execute();
		}
	    }
	}
	
	
	public function ZmenaUdajuTymy(){
	    //$arr = explode('|', $_POST['kategorie']);
	    //$id_kategorie = $arr[0];
	    //$poradi_podzavodu = $arr[1];
	    if($_POST['typ_prihlasky'] == 2){
		if(isset($_POST['delete_tym'])){
		    $sql1 = "DELETE FROM $this->sqlprihlaskytymy WHERE id_prihlasky = '{$_POST['id_prihlasky']}' LIMIT 1";
		    echo $sql1."<br>";
		    $sth1 = $this->db->prepare($sql1);
		   $sth1->execute();
		    
		    $sql1 = "DELETE FROM $this->sqlprihlaskyjednotlivci WHERE id_prihlasky_tymu = '{$_POST['id_prihlasky']}'";
		    echo $sql1."<br>";
		    $sth1 = $this->db->prepare($sql1);
		    $sth1->execute();
		    
		    
		    $sql2 = "DELETE FROM $this->sqlvs WHERE id_prihlasky = '{$_POST['id_prihlasky']}' AND typ_prihlasky = '2' LIMIT 1";
		    echo $sql2;
		    $sth2 = $this->db->prepare($sql2);
		    $sth2->execute();
		}
		else{
		    //$sql = "UPDATE $this->sqlprihlaskyjednotlivci SET zaplaceno = '{$_POST['platba']}',mail = '{$_POST['mail']}',prislusnost = '{$_POST['prislusnost']}',prijmeni_1 = '{$_POST['prijmeni_1']}',jmeno_1 = '{$_POST['jmeno_1']}',startovne = '{$_POST['startovne']}',id_kategorie = '$id_kategorie',poradi_podzavodu = '$poradi_podzavodu'  WHERE id_prihlasky = '{$_POST['id_prihlasky']}'";
		    $sql = "UPDATE $this->sqlprihlaskytymy SET zaplaceno = '{$_POST['platba']}',nazev_tymu = '{$_POST['nazev_tymu']}',mail = '{$_POST['mail']}',startovne = '{$_POST['startovne']}' WHERE id_prihlasky = '{$_POST['id_prihlasky']}'";
		    $sth = $this->db->prepare($sql);
		    $sth->execute();
		}
	    }
	}
	
	
	public function ZmenaUdajuTymuJednotlivce(){
	    $sql = "UPDATE $this->sqlprihlaskyjednotlivci SET mail = '{$_POST['mail']}',prislusnost = '{$_POST['prislusnost']}',prijmeni_1 = '{$_POST['prijmeni_1']}',jmeno_1 = '{$_POST['jmeno_1']}' WHERE id_prihlasky = '{$_POST['id_prihlasky']}'";
            $sth = $this->db->prepare($sql);
	    $sth->execute();
	}
        
        
        public function ExportExcelJednotlivciZal290821(){
	     require "./libs/phpexcel/Classes/PHPExcel.php";
	     
		/** Error reporting */
	       error_reporting(E_ALL);
	       ini_set('display_errors', TRUE);
	       ini_set('display_startup_errors', TRUE);
	       date_default_timezone_set('Europe/London');

	       if (PHP_SAPI == 'cli')
		       die('This example should only be run from a Web Browser');
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		$sql1 = "SELECT $this->sqlprihlaskyjednotlivci.*,DATE_FORMAT($this->sqlprihlaskyjednotlivci.datum_narozeni,'%d.%m.%Y') AS rok_narozeni FROM $this->sqlprihlaskyjednotlivci "
		      . "WHERE "
		      . "$this->sqlprihlaskyjednotlivci.id_zavodu = $this->IdZavodu "
		      . "ORDER BY id_prihlasky ASC";
               // echo $sql1;
		
                $sth1 = $this->db->prepare($sql1);
		$sth1->execute();
		if($sth1->rowCount()){
		    $i=1;
		    while($dbdata1 = $sth1->fetchOBject()){
			$objPHPExcel->setActiveSheetIndex(0)
			    ->setCellValue('A'.$i,"bla")
			    ->setCellValue('B'.$i,$dbdata1->jmeno_1)
			    ->setCellValue('C'.$i,$dbdata1->prijmeni_1)
			    ->setCellValue('D'.$i,$dbdata1->rok_narozeni)
			    ->setCellValue('E'.$i,$dbdata1->pohlavi)
			    ->setCellValue('F'.$i,$dbdata1->prislusnost)
			    ->setCellValue('G'.$i,$dbdata1->stat)
			    ->setCellValue('H'.$i,$dbdata1->mail)
			    ->setCellValue('I'.$i,$dbdata1->telefon_1)
			    ->setCellValue('J'.$i,$dbdata1->telefon_2)
			    ->setCellValue('K'.$i,$dbdata1->tricko)
			    ->setCellValue('L'.$i,$dbdata1->ponozky)
			    ->setCellValue('M'.$i,$dbdata1->zaplaceno)
			    ->setCellValue('N'.$i,$dbdata1->poradi_podzavodu)
                            ->setCellValue('O'.$i,"bla")
                            ->setCellValue('P'.$i,$dbdata1->ids)
                            ->setCellValue('Q'.$i,$dbdata1->id_kategorie)
                            ->setCellValue('R'.$i,$dbdata1->startovne)
			    ->setCellValue('S'.$i,$dbdata1->vzkaz)
			    ->setCellValue('T'.$i,$dbdata1->poznamka_poradatele)
                            ->setCellValue('U'.$i,$dbdata1->dalsi_udaje_1)
			    ->setCellValue('V'.$i,$dbdata1->dalsi_udaje_2)
			    ->setCellValue('W'.$i,$dbdata1->dalsi_udaje_3)
			    ->setCellValue('X'.$i,$dbdata1->dalsi_udaje_4)
			    ->setCellValue('Y'.$i,$dbdata1->dalsi_udaje_5)
			    ->setCellValue('Z'.$i,$dbdata1->dalsi_udaje_6)
			    ->setCellValue('AA'.$i,$dbdata1->dalsi_udaje_7) 
                            ->setCellValue('AA'.$i,$dbdata1->id_prihlasky_tymu);  
			$i++;
		    }
		}

		$objPHPExcel->getActiveSheet()->setTitle('Přihlášky');

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="prihlasky.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
		exit;
	    }
        public function ExportExcelJednotlivci(){
		   $sql1 = "SELECT $this->sqlprihlaskyjednotlivci.*,DATE_FORMAT($this->sqlprihlaskyjednotlivci.datum_narozeni,'%d.%m.%Y') AS rok_narozeni FROM $this->sqlprihlaskyjednotlivci "
				 . "WHERE "
				 . "$this->sqlprihlaskyjednotlivci.id_zavodu = $this->IdZavodu "
				 . "ORDER BY id_prihlasky ASC";
				  // echo $sql1;
		   
			$sth1 = $this->db->prepare($sql1);
		   	$sth1->execute();
		   	if($sth1->rowCount()){
				$file = "C://webapps/export_test.csv";
				$fp = fopen ($file,"w+");
				$csv = "";

			   $i=1;

			   while($dbdata1 = $sth1->fetchOBject()){
					$csv .= "$dbdata1->jmeno_1;";
					$csv .= "$dbdata1->prijmeni_1;";
					$csv .= "$dbdata1->rok_narozeni;";
					$csv .= "$dbdata1->pohlavi;";
					$csv .= "$dbdata1->prislusnost;";
					$csv .= "$dbdata1->stat;";
					$csv .= "$dbdata1->mail;";
					$csv .= "$dbdata1->telefon_1;";
					$csv .= "$dbdata1->telefon_2;";
					$csv .= "$dbdata1->tricko;";
					$csv .= "$dbdata1->ponozky;";
					$csv .= "$dbdata1->zaplaceno;";
					$csv .= "$dbdata1->poradi_podzavodu;";
					$csv .= "$dbdata1->vzkaz;";
				   	$csv .= "$dbdata1->poznamka_poradatele;";
					$csv .= "$dbdata1->dalsi_udaje_1;";
					$csv .= "$dbdata1->dalsi_udaje_2;";
					$csv .= "$dbdata1->dalsi_udaje_3;";
					$csv .= "$dbdata1->dalsi_udaje_4;";
					$csv .= "$dbdata1->dalsi_udaje_5;";
					$csv .= "$dbdata1->dalsi_udaje_6;";
					$csv .= "$dbdata1->dalsi_udaje_7;"; 
					$csv .= "$dbdata1->id_prihlasky_tymu;\r\n"; 
			   $i++;
			   }
			   echo $csv;
			   fwrite($fp,$csv);

		   }
   
		   
		   exit;
		   }
		   
        
        
        

	public function ExportExcelJednotlivciZalZal(){
	     require "./libs/phpexcel/Classes/PHPExcel.php";
	     
		/** Error reporting */
	       error_reporting(E_ALL);
	       ini_set('display_errors', TRUE);
	       ini_set('display_startup_errors', TRUE);
	       date_default_timezone_set('Europe/London');

	       if (PHP_SAPI == 'cli')
		       die('This example should only be run from a Web Browser');
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
              /*
               $sql1 = "SELECT "
		      . "$this->sqlprihlaskyjednotlivci.*,DATE_FORMAT($this->sqlprihlaskyjednotlivci.datum_narozeni,'%d.%m.%Y') AS rok_narozeni,$this->sqlvs.vs,$this->sqlkategorie.nazev_k AS kategorie,1 AS typ_prihlasky FROM $this->sqlprihlaskyjednotlivci,$this->sqlvs,$this->sqlkategorie "
		      . "WHERE "
		      . "$this->sqlvs.id_zavodu = $this->IdZavodu AND "
		      . "$this->sqlprihlaskyjednotlivci.id_prihlasky = $this->sqlvs.id_prihlasky AND "
		      . "$this->sqlvs.typ_prihlasky = 1 AND "
		      . "$this->sqlprihlaskyjednotlivci.id_kategorie = $this->sqlkategorie.id_kategorie "
		      . "ORDER BY $this->sqlvs.vs ASC";
		
                */
                        
                /*
                $sql1 = "SELECT "
		      . "$this->sqlprihlaskyjednotlivci.*,DATE_FORMAT($this->sqlprihlaskyjednotlivci.datum_narozeni,'%d.%m.%Y') AS rok_narozeni,0 AS vs,0 AS kategorie,1 AS typ_prihlasky FROM $this->sqlprihlaskyjednotlivci "
		      . "WHERE "
		      . "$this->sqlprihlaskyjednotlivci.id_zavodu = 1"; */
                       
	
                //tymy
                
                     $sql1 = "SELECT "
		      . "$this->sqlprihlaskyjednotlivci.*,DATE_FORMAT($this->sqlprihlaskyjednotlivci.datum_narozeni,'%d.%m.%Y') AS rok_narozeni,0 AS vs,0 AS kategorie,1 AS typ_prihlasky,$this->sqlprihlaskytymy.nazev_tymu AS prislusnost,$this->sqlprihlaskytymy.id_kategorie AS kategorie FROM $this->sqlprihlaskyjednotlivci,$this->sqlprihlaskytymy "
		      . "WHERE "
		      . "$this->sqlprihlaskyjednotlivci.id_zavodu = 1 AND $this->sqlprihlaskyjednotlivci.id_prihlasky_tymu = $this->sqlprihlaskytymy.id_prihlasky";
                      
                
                
                $sth1 = $this->db->prepare($sql1);
		$sth1->execute();
		if($sth1->rowCount()){
		    $i=1;
		    while($dbdata1 = $sth1->fetchOBject()){
			$objPHPExcel->setActiveSheetIndex(0)
			    ->setCellValue('A'.$i,$dbdata1->vs)
			    ->setCellValue('B'.$i,$dbdata1->jmeno_1)
			    ->setCellValue('C'.$i,$dbdata1->prijmeni_1)
			    ->setCellValue('D'.$i,$dbdata1->rok_narozeni)
			    ->setCellValue('E'.$i,$dbdata1->pohlavi)
			    ->setCellValue('F'.$i,$dbdata1->prislusnost)
			    ->setCellValue('G'.$i,$dbdata1->stat)
			    ->setCellValue('H'.$i,$dbdata1->mail)
			    ->setCellValue('I'.$i,$dbdata1->telefon_1)
			    ->setCellValue('J'.$i,$dbdata1->telefon_2)
			    ->setCellValue('K'.$i,$dbdata1->tricko)
			    ->setCellValue('L'.$i,$dbdata1->ponozky)
			    ->setCellValue('M'.$i,$dbdata1->zaplaceno)
			    ->setCellValue('N'.$i,$dbdata1->poradi_podzavodu)
                            ->setCellValue('O'.$i,$dbdata1->kategorie)
                            ->setCellValue('P'.$i,$dbdata1->ids)
                            ->setCellValue('Q'.$i,$dbdata1->id_kategorie)
                            ->setCellValue('R'.$i,$dbdata1->startovne)
			    ->setCellValue('S'.$i,$dbdata1->vzkaz)
			    ->setCellValue('T'.$i,$dbdata1->poznamka_poradatele)
                            ->setCellValue('U'.$i,$dbdata1->dalsi_udaje_1)
			    ->setCellValue('V'.$i,$dbdata1->dalsi_udaje_2)
			    ->setCellValue('W'.$i,$dbdata1->dalsi_udaje_3)
			    ->setCellValue('X'.$i,$dbdata1->dalsi_udaje_4)
			    ->setCellValue('Y'.$i,$dbdata1->dalsi_udaje_5)
			    ->setCellValue('Z'.$i,$dbdata1->dalsi_udaje_6)
			    ->setCellValue('AA'.$i,$dbdata1->dalsi_udaje_7) 
			    ->setCellValue('AB'.$i,$dbdata1->datum_prihlaseni)  
			    ->setCellValue('AC'.$i,$dbdata1->datum_editace);  
			$i++;
		    }
		}

		$objPHPExcel->getActiveSheet()->setTitle('Přihlášky');

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="prihlasky.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
		exit;
	    }
	    
	    
	    public function CategoryList(){
		$sql1 = "SELECT id_kategorie,nazev_k AS nazev_kategorie, kod_k AS kod_kategorie,poradi_podzavodu FROM $this->sqlkategorie WHERE id_zavodu = $this->IdZavodu ORDER BY poradi";
                $sth1 = $this->db->prepare($sql1);
		$sth1->execute(Array(':id_zavodu' => $this->IdZavodu));
		if($sth1->rowCount()){
		    $kategorie = Array();
		    while($dbdata1 = $sth1->fetchObject()){
			$kategorie[$dbdata1->kod_kategorie] = Array('id_kategorie' => $dbdata1->id_kategorie, 'nazev_kategorie' => $dbdata1->nazev_kategorie, 'poradi_podzavodu' => $dbdata1->poradi_podzavodu);

		    }
		}
		return $kategorie;
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

}

?>