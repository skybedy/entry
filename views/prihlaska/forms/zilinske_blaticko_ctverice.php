<?php
        $pocet_clenu = 4;
        $vlny = Array();
       /* $cas_vlny = Array('10:30','10:33','10:36','10:39','10:42','10:45','10:48','10:51','10:54','10:57','11:00','11:03','11:06','11:09','11:12','11:15','11:18','11:21','11:24',
                            '11:27','11:30','11:33','11:36','11:39','11:42','11:45','11:48','11:51','11:54','11:57','12:00','12:03','12:06','12:09','12:12','12:15','12:18','12:21',
                            '12:24','12:27','12:30','12:33','12:36','12:39','12:42','12:45','12:48','12:51','12:54','12:57','13:00','13:03','13:06');   */
        
            $cas_vlny = Array('10:30','10:33','10:36','10:39','10:42','10:45','10:48','10:51','10:54','10:57','11:00','11:03','11:06','11:09','11:12','11:15','11:18','11:21','11:24',
                        '11:27','11:30','11:33','11:36','11:39','11:42','11:45','11:48','11:51','11:54','11:57','12:00','12:03','12:06','12:09','12:12','12:15','12:18','12:21',
                        '12:24','12:27','12:30','12:33','12:36','12:39','12:42','12:45','12:51','12:57');   
    
        
        
        $pocet_lidi_do_vlny = 10;
        
        
?>

<?php
    if(Session::get('poradi_podzavodu') == true){
    $tricka = Array();
    $tricka['S'] = 'S';
    $tricka['M'] = 'M';
    $tricka['L'] = 'L';
    $tricka['XL'] = 'XL';
    $tricka['XXL'] = 'XXL';
    $typ_prihlasky = 2;
    $id_meny = 2;
?>  





<input type="hidden" name="id_meny" value="<?php echo $id_meny ?>" />
<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
<input type="hidden" name="poradi_podzavodu" value="<?php echo Session::get('poradi_podzavodu') ?>" />
<input type="hidden" name="zaplaceno" value="nezaplaceno" />
<input type="hidden" name="pocet_clenu" value="<?php echo $pocet_clenu ?>" />
<input type="hidden" name="ticko" value="bez" />

<h4>Tým</h4>

<div class="form-group">
    <input name="nazev_tymu" class="form-control required" placeholder="Název týmu" value="<?php echo (isset($udaje['nazev_tymu'])) ? ($udaje['nazev_tymu']) : ('') ?>" />
</div>
<?php  //print_r ($this->vlny) ?>
<div class="form-group"> 
    <select name="tym_dalsi_udaje_3" class="form-control required placeholder">
        <option value="" selected disabled>Výběr vlny</option>
        <?php
            $i = 0;
            foreach($this->vlny as $val){
                if($val < $pocet_lidi_do_vlny){
                    echo '<option value="'.$cas_vlny[$i].'"';
                    if(isset($_GET['dalsi_udaje_1'])){
                        if($udaje['dalsi_udaje_1'] == $cas_vlny[$i]){
                            echo ' selected="selected" ';
                        }
                    }
                    echo '>'.$cas_vlny[$i].' (počet volných míst = '.($pocet_lidi_do_vlny - $val).')</option>';  
                }
                $i++;
            }
        ?>
    </select>
</div>

<hr>


    
    
    <?php
    $str = '';
    for($i=1;$i<=$pocet_clenu;$i++){
	$str .= '<h4>Zavodnik '.$i;
        $str .= "</h4>";
	$str .= '<div class="form-group">';
	$str .= '<input name="jmeno_1_'.$i.'" class="form-control required" placeholder="Jméno" value="'.(isset($udaje['jmeno_1_'.$i]) ? $udaje['jmeno_1_'.$i] : '').'" />';
	$str .= '</div>';
	$str .= '<div class="form-group">';
	$str .= '<input name="prijmeni_1_'.$i.'" class="form-control required" placeholder="Příjmení" value="'.(isset($udaje['prijmeni_1_'.$i]) ? $udaje['prijmeni_1_'.$i] : '').'" />';
	$str .= '</div>';
	$str .= '<div class="form-group">';
	$str .= '<input name="mail_'.$i.'" class="form-control required" placeholder="E-mail" value="'.(isset($udaje['mail_'.$i]) ? $udaje['mail_'.$i] : '').'" />';
	$str .= '</div>';

	
	$str .= '<div class="form-group">';
	$str .= '<select name="rok_narozeni_'.$i.'" class="form-control required placeholder">';  
	$str .=	 '<option value="">Rok narození</option>';  
	for($k=1920;$k<=2018;$k++){
	    $str .= '<option value="'.$k.'" '.((isset($udaje['rok_narozeni_'.$i]) && $udaje['rok_narozeni_'.$i] == $k) ? 'selected="selected"' : '').'>'.$k.'</option>';
	}
	$str .= '</select>';
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
        $str .= '<div class="col-lg-4">';
	

	$str .= '<div class="form-group">';
        	/*
	$str .= '<select name="tricko_'.$i.'" class="form-control placeholder required">';
	$str .= '<option value="">Tričko (+8€, volitelné)</option>';
	$str .= '<option value="bez">Bez trička</option>';
	foreach($tricka as $key => $val){
	    $str .= '<option value="'.$val.'"'.((isset($udaje['tricko_'.$i]) && $udaje['tricko_'.$i] == $val) ? 'selected="selected"' : '').'>'.$key.'</option>';
	}
	$str .= '</select>';*/
	$str .= '</div></div>';	
	$str .= '</div>';
	$str .= '<hr>';
    }
    echo $str
?>
<hr>
<h4>Kapitán týmu</h4>

<div class="form-group">
    <input type="text" name="tym_dalsi_udaje_1" class="form-control required" placeholder="Jméno / Firstname" value="<?php echo (isset($udaje['tym_dalsi_udaje_1'])) ? ($udaje['tym_dalsi_udaje_1']) : ('') ?>" />
</div>

<div class="form-group">
    <input  type="text" name="tym_dalsi_udaje_2" class="form-control required" placeholder="Příjmení / Surname" value="<?php echo (isset($udaje['tym_dalsi_udaje_2'])) ? ($udaje['tym_dalsi_udaje_2']) : ('') ?>" />
</div>

<div class="form-group">
    <input  type="email" name="mail_tym" class="form-control required" placeholder="E-mail" value="<?php echo (isset($udaje['mail_tym'])) ? ($udaje['mail_tym']) : ('') ?>" />
</div>

<div class="form-group">
    <input  type="tel" name="telefon_1_tym" class="form-control required" placeholder="Telefon / Phone" value="<?php echo (isset($udaje['telefon_1_tym'])) ? ($udaje['telefon_1_tym']) : ('') ?>" />
</div>
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
    
    

