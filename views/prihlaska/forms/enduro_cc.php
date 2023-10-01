<?php
    $pocet_clenu = 2;
   $typ_prihlasky = 7;
    
?>  
<input type="hidden" name="id_meny" value="<?php echo $id_meny ?>" />
<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
<input type="hidden" name="poradi_podzavodu" value="<?php echo Session::get('poradi_podzavodu') ?>" />
<input type="hidden" name="zaplaceno" value="nezaplaceno" />
<input type="hidden" name="pocet_clenu" value="2" />

<h4>Tým</h4>

<div class="form-group">
    <input name="nazev_tymu" class="form-control required" placeholder="Název týmu" value="<?php echo (isset($udaje['nazev_tymu'])) ? ($udaje['nazev_tymu']) : ('') ?>" />
</div>

<div class="form-group">
    <input name="mail_tym" class="form-control required email" placeholder="E-mail" value="<?php echo (isset($udaje['mail_tym']) ? $udaje['mail_tym'] : '') ?>" />
</div>




    
    
    <?php
    $str = '';
    for($i=1;$i<=2;$i++){
	$str .= '<h4>Zavodnik '.$i.'</h4>';
	
	$str .= '<div class="form-group">';
	$str .= '<input name="jmeno_1_'.$i.'" class="form-control required" placeholder="Jméno" value="'.(isset($udaje['jmeno_1_'.$i]) ? $udaje['jmeno_1_'.$i] : '').'" />';
	$str .= '</div>';
	
	$str .= '<div class="form-group">';
	$str .= '<input name="prijmeni_1_'.$i.'" class="form-control required" placeholder="Příjmení" value="'.(isset($udaje['prijmeni_1_'.$i]) ? $udaje['prijmeni_1_'.$i] : '').'" />';
	$str .= '</div>';

	
	
	$str .= '<div class="row">';
        $str .= '<div class="col-lg-4">';
	$str .= '<div class="form-group">';
	$str .= '<select name="rok_narozeni_'.$i.'" class="form-control required placeholder">';  
	$str .=	 '<option value="">Rok narození</option>';  
	for($k=1920;$k<=2017;$k++){
	    $str .= '<option value="'.$k.'" '.((isset($udaje['rok_narozeni_'.$i]) && $udaje['rok_narozeni_'.$i] == $k) ? 'selected="selected"' : '').'>'.$k.'</option>';
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
	
        
        
        $str .= '<div class="form-group">';
	$str .= '<select name="tricko_'.$i.'" class="form-control placeholder">';
	$str .= '<option value="">Tričko</option>';
	$str .= '<option value="">Bez trička</option>';
	foreach($tricka as $key => $val){
	    $str .= '<option value="'.$val.'"'.((isset($udaje['tricko_'.$i]) && $udaje['tricko_'.$i] == $val) ? 'selected="selected"' : '').'>'.$key.'</option>';
	}
	$str .= '</select>';
	$str .= '</div>';
	
	$str.= '<input type="hidden" name="trickobez_'.$i.'" value="bez" />';
        
        $str .= '<div class="form-group">';
	$str .= '<input name="mail_'.$i.'" class="form-control required email" placeholder="E-mail" value="'.(isset($udaje['mail_'.$i]) ? $udaje['mail_'.$i] : '').'" />';
	$str .= '</div>';
	
	$str .= '<div class="form-group">';
	$str .= '<input name="telefon_1_'.$i.'" class="form-control required" placeholder="Telefon" value="'.(isset($udaje['telefon_1_'.$i]) ? $udaje['telefon_1_'.$i] : '').'" />';
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


    
    

