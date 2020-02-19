<?php
    if(Session::get('poradi_podzavodu') == true){
    $typ_prihlasky = 2;
    $id_meny = 2;
?>  
<input type="hidden" name="id_meny" value="<?php echo $id_meny ?>" />
<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
<input type="hidden" name="poradi_podzavodu" value="<?php echo $poradi_podzavodu ?>" />
<input type="hidden" name="zaplaceno" value="nezaplaceno" />
<input type="hidden" name="pocet_clenu" value="2" />

<h4>Tým</h4>

<div class="form-group">
    <input name="nazev_tymu" class="form-control required" placeholder="Název týmu" value="<?php echo (isset($udaje['nazev_tymu'])) ? ($udaje['nazev_tymu']) : ('') ?>" />
</div>

<div class="form-group">
    <input name="mail_tym" class="form-control required email" placeholder="E-mail" value="<?php echo (isset($udaje['mail_tym']) ? $udaje['mail_tym'] : '') ?>" />
</div>
<div class="form-group">
    <input  type="tel" name="telefon_1_tym" class="form-control required" placeholder="Telefon" value="<?php echo (isset($udaje['telefon_1_tym'])) ? ($udaje['telefon_1_tym']) : ('') ?>" />
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
</div><br><br>
<?php
    $str = '';
    for($i=1;$i<=2;$i++){
	$str .= '<h4>Zavodnik '.$i;
        if($i == 1){
            $str .= " - vedoucí týmu, povinný věk nad 18 let";
        }
        else{
            $str .= " - dítě, ročník 2011 a mladší";
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
	$str .= '<select name="rok_narozeni_'.$i.'" class="form-control required placeholder">';  
	$str .=	 '<option value="">Rok narození</option>';  
	for($k=1920;$k<=2018;$k++){
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
	$str .= '';
    }
    echo $str
?>
    
<hr>
<div class="checkbox">
    <label>
        <input type="checkbox" name="souhlas_osobni_udaje" class="required" /> Souhlasím s poskytnutím osobních údajů pro potřeby této registrace
    </label>
</div>

    <div class="form-group"> 
    <textarea placeholder="Vzkaz pořadateli, máte-li nějaký" class="form-control" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
    </div>
    <div class="form-group"> 
	<button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
    </div>

<?php	
    }
?> 
    
    

