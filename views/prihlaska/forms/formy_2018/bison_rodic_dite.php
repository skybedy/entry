<?php
        $pocet_clenu = Session::get('pocet_clenu');
?>

<h4><strong>Počet členů týmu</strong></h4>
<div class="form-group">
    <select class="form-control" id="vyber_zavodu" onchange="window.location = 'prihlaska/pocet-clenu/'+this.options[this.selectedIndex].value+'';" name="pocet_clenu">	  
	<option value="">Zadejte počet členů týmu</option>
	<option value="2" <?php echo ((isset($pocet_clenu) && $pocet_clenu == 2) ? ('selected="selected"') : ('')) ?>>2</option>
	<option value="3" <?php echo ((isset($pocet_clenu) && $pocet_clenu == 3) ? ('selected="selected"') : ('')) ?>>3</option>
	<option value="4" <?php echo ((isset($pocet_clenu) && $pocet_clenu == 4) ? ('selected="selected"') : ('')) ?>>4</option>
	<option value="5" <?php echo ((isset($pocet_clenu) && $pocet_clenu == 5) ? ('selected="selected"') : ('')) ?>>5</option>
	<option value="6" <?php echo ((isset($pocet_clenu) && $pocet_clenu == 6) ? ('selected="selected"') : ('')) ?>>6</option>
    </select>
</div>

<?php
    if(Session::get('poradi_podzavodu') == true){
    $typ_prihlasky = 2;
    $id_meny = 2;
?>  
<input type="hidden" name="id_meny" value="<?php echo $id_meny ?>" />
<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
<input type="hidden" name="poradi_podzavodu" value="<?php echo $poradi_podzavodu ?>" />
<input type="hidden" name="zaplaceno" value="nezaplaceno" />
<input type="hidden" name="pocet_clenu" value="<?php echo $pocet_clenu ?>" />
<input type="hidden" name="id_kategorie" value="524" />

<h4>Tým</h4>

<div class="form-group">
    <input name="nazev_tymu" class="form-control required" placeholder="Název týmu" value="<?php echo (isset($udaje['nazev_tymu'])) ? ($udaje['nazev_tymu']) : ('') ?>" />
</div>

<div class="form-group">
    <input name="mail_tym" class="form-control required email" placeholder="E-mail" value="<?php echo (isset($udaje['mail_tym']) ? $udaje['mail_tym'] : '') ?>" /><br><br>
</div>




    
    
    <?php
    $str = '';
    for($i=1;$i<=$pocet_clenu;$i++){
	$str .= '<h4>Zavodnik '.$i;
        if($i == 1){
            $str .= " - vedoucí týmu, povinný věk nad 18 let";
        }
        $str .= "</h4>";
	
	$str .= '<div class="form-group">';
	$str .= '<input name="jmeno_1_'.$i.'" class="form-control required" placeholder="Jméno" value="'.(isset($udaje['jmeno_1_'.$i]) ? $udaje['jmeno_1_'.$i] : '').'" />';
	$str .= '</div>';
	
	$str .= '<div class="form-group">';
	$str .= '<input name="prijmeni_1_'.$i.'" class="form-control required" placeholder="Příjmení" value="'.(isset($udaje['prijmeni_1_'.$i]) ? $udaje['prijmeni_1_'.$i] : '').'" />';
	$str .= '</div>';

	$str .= '<div class="form-group">';
	$str .= '<input name="prislusnost_'.$i.'" class="form-control required" placeholder="Obec nebo město" value="'.(isset($udaje['prislusnost_'.$i]) ? $udaje['prislusnost_'.$i] : '').'" />';
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
	for($k=1920;$k<=2016;$k++){
	    $str .= '<option value="'.$k.'" '.((isset($udaje['rok_narozeni_'.$i]) && $udaje['rok_narozeni_'.$i] == $k) ? 'selected="selected"' : '').'>'.$k.'</option>';
	}
	$str .= '</select>';
	$str .= '</div></div>';
	$str .= '</div>';
	
	$str .= '<div class="row">';
	$str .= '<div class="col-lg-4">';
	$str .= '<div class="form-group">';
	$str .= '<select name="pohlavi_'.$i.'" class="form-control required placeholder">';  
	$str .=	 '<option value="">Pohlaví</option>';  
	$str .=  '<option value="M"'.((isset($udaje['pohlavi_'.$i]) && $udaje['pohlavi_'.$i] == 'M') ? ' selected="selected"' : '').'>Muž</option>';  
	$str .=  '<option value="Z"'.((isset($udaje['pohlavi_'.$i]) && $udaje['pohlavi_'.$i] == 'Z') ? ' selected="selected"' : '').'>Žena</option>';  
	$str .= '</select>';
	$str .= '</div></div>';

	$str .= '<div class="col-lg-4">';
	$str .= '<div class="form-group">';
	$str .= '<select name="stat_'.$i.'" class="form-control required placeholder">';
	$str .= '<option value="">Stát</option>';
	foreach($this->seznam_statu as $key => $val){
	    $str .= '<option value="'.$key.'"'.((isset($udaje['stat_'.$i]) && $udaje['stat_'.$i] == $key) ? 'selected="selected"' : '').'>'.$val.'</option>';
	}
	$str .= '</select>';
	$str .= '</div></div>';
	$str .= '</div>';
	$str .= '<br /><br />';
    }
    echo $str
?>
    <div class="form-group"> 
    <textarea placeholder="Vzkaz pořadateli, máte-li nějaký" class="form-control" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
    </div>
    <div class="form-group"> 
	<button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
    </div>

<?php	
    }
?> 
    
    

