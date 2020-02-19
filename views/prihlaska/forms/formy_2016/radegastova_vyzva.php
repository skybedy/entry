<?php
    $pocet_clenu = Session::get('pocet_clenu');
    $typ_prihlasky = 2;
    $id_meny = 1;
    $poradi_podzavodu = 1;
    $cesta = "./public/doc/ubytovaci_kapacita.txt";
    $csv = fopen($cesta,"r");
    $kapacita = Array();
    while($data = fgetcsv($csv,1000,";")){
	$kapacita[] = $data[1];
    }
?>  

<input type="hidden" name="id_meny" value="<?php echo $id_meny ?>" />
<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
<input type="hidden" name="poradi_podzavodu" value="<?php echo $poradi_podzavodu ?>" />
<input type="hidden" name="zaplaceno" value="nezaplaceno" />
<input type="hidden" name="pocet_clenu" value="<?php echo $pocet_clenu ?>" />

<h4><strong>Tým</strong></h4>

<div class="form-group">
    <input name="nazev_tymu" class="form-control required" placeholder="Název týmu" value="<?php echo (isset($udaje['nazev_tymu'])) ? ($udaje['nazev_tymu']) : ('') ?>" />
</div>

<div class="form-group">
    <input name="mail_tym" class="form-control required email" placeholder="Kontaktní e-mail" value="<?php echo (isset($udaje['mail_tym']) ? $udaje['mail_tym'] : '') ?>" />
</div>

<div class="row">
    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="id_kategorie" class="form-control required placeholder">
		<option value="" selected disabled>Výběr kategorie</option>
		    <?php
			if($this->vyber_kategorii){
			    foreach($this->vyber_kategorii as $val){
				echo '<option value="'.$val['id_kategorie'].'"'.((isset($udaje['id_kategorie']) && $udaje['id_kategorie'] == $val['id_kategorie']) ? ' selected="selected"' : '').'>'.$val['nazev_k'].'</option>';
			    }
			}
		    ?>
	    </select>
	</div>
    </div>
</div>




    
    
    <?php
    $str = '';
    
    	$str .= '<div class="row">';
	$str .= '<div class="col-lg-8">';
	$str .= '<div class="form-group">';
	$str .= '<select name="dalsi_udaje_1" class="form-control required placeholder">';  
	$str .=	 '<option value="">Typ ubytování</option>';  
	//$str .=  '<option value="Chatka"'.((isset($udaje['dalsi_udaje_1']) && $udaje['dalsi_udaje_1'] == 'Chatka') ? ' selected="selected"' : '').'>Chatka</option>';  
	//$str .=  '<option value="Budova"'.((isset($udaje['dalsi_udaje_1']) && $udaje['dalsi_udaje_1'] == 'Budova') ? ' selected="selected"' : '').'>Budova</option>';  
	$str .=  '<option value="Stan"'.((isset($udaje['dalsi_udaje_1']) && $udaje['dalsi_udaje_1'] == 'Stan') ? ' selected="selected"' : '').'>Stan</option>';  
	$str .=  '<option value="Vlastni"'.((isset($udaje['dalsi_udaje_1']) && $udaje['dalsi_udaje_1'] == 'Vlastni') ? ' selected="selected"' : '').'>Vlastní ubytování</option>';  
	$str .= '</select>';
	$str .= '</div></div>';
	$str .= '<div class="col-lg-4">';
	$str .= '<div class="form-group">';
	$str .= '<select name="dalsi_udaje_2" class="form-control  placeholder">';
	$str .= '<option value="">Počet noclehů</option>';
	$str .= '<option value="2"'.((isset($udaje['dalsi_udaje_2']) && $udaje['dalsi_udaje_2'] == '2') ? ' selected="selected"' : '').'>Pátek-Neděle</option>';
	$str .= '<option value="1"'.((isset($udaje['dalsi_udaje_2']) && $udaje['dalsi_udaje_2'] == '1') ? ' selected="selected"' : '').'>Sobota-Neděle</option>';
	$str .= '</select>';
	$str .= '</div></div>';
	$str .= '</div>';

    
    
    for($i=1;$i<=$pocet_clenu;$i++){
	$str .= '<h4><strong>Zavodnik '.$i.'</strong></h4>';
	$str .= '<div class="form-group">';
	$str .= '<input name="jmeno_1_'.$i.'" class="form-control required" placeholder="Jméno" value="'.(isset($udaje['jmeno_1_'.$i]) ? $udaje['jmeno_1_'.$i] : '').'" />';
	$str .= '</div>';
	
	$str .= '<div class="form-group">';
	$str .= '<input name="prijmeni_1_'.$i.'" class="form-control required" placeholder="Příjmení" value="'.(isset($udaje['prijmeni_1_'.$i]) ? $udaje['prijmeni_1_'.$i] : '').'" />';
	$str .= '</div>';

	$str .= '<div class="form-group">';
	$str .= '<input name="prislusnost_'.$i.'" class="form-control required" placeholder="Tým nebo místo bydliště bez čp, ulice a PSČ (např. Ostrava)" value="'.(isset($udaje['prislusnost_'.$i]) ? $udaje['prislusnost_'.$i] : '').'" />';
	$str .= '</div>';
	
	
	
	$str .= '<div class="row">';
	$str .= '<div class="col-lg-4">';
	$str .= '<div class="form-group">';
	$str .= '<select name="den_narozeni_'.$i.'" class="form-control required placeholder">';  
	$str .=	 '<option value="">Den narození</option>';  
	for($k=1;$k<=31;$k++){
	    $str .= '<option value="'.$k.'" '.((isset($udaje['den_narozeni_'.$i]) && $udaje['den_narozeni_'.$i] == $k) ? 'selected="selected"' : '').'>'.$k.'</option>';
	}
	$str .= '</select>';
	$str .= '</div></div>';
	$str .= '<div class="col-lg-4">';
	$str .= '<div class="form-group">';
	$str .= '<select name="mesic_narozeni_'.$i.'" class="form-control required placeholder">';  
	$str .=	 '<option value="">Měsíc narození</option>';  
	for($k=1;$k<=12;$k++){
	    $str .= '<option value="'.$k.'" '.((isset($udaje['mesic_narozeni_'.$i]) && $udaje['mesic_narozeni_'.$i] == $k) ? 'selected="selected"' : '').'>'.$k.'</option>';
	}
	$str .= '</select>';
	$str .= '</div></div>';
	$str .= '<div class="col-lg-4">';
	$str .= '<div class="form-group">';
	$str .= '<select name="rok_narozeni_'.$i.'" class="form-control required placeholder">';  
	$str .=	 '<option value="">Rok narození</option>';  
	for($k=1920;$k<=2014;$k++){
	    $str .= '<option value="'.$k.'" '.((isset($udaje['rok_narozeni_'.$i]) && $udaje['rok_narozeni_'.$i] == $k) ? 'selected="selected"' : '').'>'.$k.'</option>';
	}
	$str .= '</select>';
	$str .= '</div></div>';
	$str .= '</div>';
	
	
	
	$str .= '<div class="row">';
	$str .= '<div class="col-lg-4">';
	$str .= '<div class="form-group">';
	$str .= '<select name="stat_'.$i.'" class="form-control required placeholder">';
	$str .= '<option value="">Stát</option>';
	foreach($this->seznam_statu as $key => $val){
	    $str .= '<option value="'.$key.'"'.((isset($udaje['stat_'.$i]) && $udaje['stat_'.$i] == $key) ? 'selected="selected"' : '').'>'.$val.'</option>';
	}
	$str .= '</select>';
	$str .= '</div></div>';
	$str .= '<div class="col-lg-4">';
	$str .= '<div class="form-group">';
	$str .= '<select name="pohlavi_'.$i.'" class="form-control required placeholder">';  
	$str .=	 '<option value="">Pohlaví</option>';  
	$str .=  '<option value="M"'.((isset($udaje['pohlavi_'.$i]) && $udaje['pohlavi_'.$i] == 'M') ? ' selected="selected"' : '').'>Muž</option>';  
	$str .=  '<option value="Z"'.((isset($udaje['pohlavi_'.$i]) && $udaje['pohlavi_'.$i] == 'Z') ? ' selected="selected"' : '').'>Žena</option>';  
	$str .= '</select>';
	$str .= '</div></div>';
	/*
        $str .= '<div class="col-lg-4">';
	$str .= '<div class="form-group">';
	$str .= '<select name="tricko_'.$i.'" class="form-control  placeholder">';
	$str .= '<option value="">Tričko (+200 Kč)</option>';
	$str .= '<option value="">Nechci tričko</option>';
	foreach($this->tricka as $key => $val){
	    $str .= '<option value="'.$val.'"'.((isset($udaje['tricko_'.$i]) && $udaje['tricko_'.$i] == $val) ? 'selected="selected"' : '').'>'.$key.'</option>';
	}
	$str .= '</select>';
	$str .= '</div></div>';
	*/
        $str .= '</div>';
	
	
	
	
	
	
	$str .= '<div class="form-group">';
	$str .= '<input name="mail_'.$i.'" class="form-control required email" placeholder="E-mail" value="'.(isset($udaje['mail_'.$i]) ? $udaje['mail_'.$i] : '').'" />';
	$str .= '</div>';
	
	$str .= '<div class="form-group">';
	$str .= '<input name="telefon_1_'.$i.'" class="form-control required" placeholder="Telefon" value="'.(isset($udaje['telefon_1_'.$i]) ? $udaje['telefon_1_'.$i] : '').'" />';
	$str .= '</div>';
	
	$str .= '<div class="form-group">';
	$str .= '<input name="telefon_2_'.$i.'" class="form-control required" placeholder="Telefon alternativní (třeba pro případ zranění)" value="'.(isset($udaje['telefon_2_'.$i]) ? $udaje['telefon_2_'.$i] : '').'" />';
	$str .= '</div>';
    }
    echo $str
?>
    <div class="form-group"> 
    <textarea placeholder="Vzkaz pořadateli, máte-li nějaký" class="form-control" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
    </div>
    <div class="form-group"> 
	<button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
    </div>
    
    

