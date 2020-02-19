<?php
        $pocet_clenu = Session::get('pocet_clenu');
        $vlny = Array();
        $cas_vlny = Array('10:00','10:15','10:30','10:45','11:00','11:15','11:30','11:45','12:00','12:15','12:30','12:45','13:00'); 
        $pocet_lidi_do_vlny = 25;
        if($_SESSION['race_id'] == 68){
            $vseobecne_podminky = 'https://entry.timechip.cz/public/doc/aktivity_race_vseobecne_podminky.pdf';
            $pravidla_podminky = 'https://entry.timechip.cz/public/doc/aktivity_race_pravidla_podminky.pdf';
        }
        elseif($_SESSION['race_id'] == 65){
            $vseobecne_podminky = 'https://entry.timechip.cz/public/doc/hei_run_vseobecne_podminky_2019.pdf';
            $pravidla_podminky = 'https://entry.timechip.cz/public/doc/hei_run_pravidla_podminky_2019.pdf';
        }

?>

<h4><strong>Počet členů týmu</strong></h4>
<div class="form-group">
    <select class="form-control" id="vyber_zavodu" onchange="window.location = 'prihlaska/pocet-clenu/'+this.options[this.selectedIndex].value+'';" name="vyber_zavodu">	  
	<option value="">Zadejte počet členů týmu</option>
        <?php
            for($i=4;$i<=20;$i++){
                echo '<option value="'.$i.'"';
                if($pocet_clenu == $i){
                    echo ' selected="selected"';
                }
                echo '>'.$i.'</option>';
            }
        ?>
    </select>
</div>
<hr>
<?php
    if(Session::get('poradi_podzavodu') == true){
    $tricka = Array();
    $tricka['S'] = 'S';
    $tricka['M'] = 'M';
    $tricka['L'] = 'L';
    $tricka['XL'] = 'XL';
    $tricka['XXL'] = 'XXL';
    $typ_prihlasky = 2;
    $id_meny = 1;
?>  





<input type="hidden" name="id_meny" value="<?php echo $id_meny ?>" />
<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
<input type="hidden" name="poradi_podzavodu" value="<?php echo Session::get('poradi_podzavodu') ?>" />
<input type="hidden" name="zaplaceno" value="nezaplaceno" />
<input type="hidden" name="pocet_clenu" value="<?php echo $pocet_clenu ?>" />

<h4>Tým</h4>

<div class="form-group">
    <input name="nazev_tymu" class="form-control required" placeholder="Název týmu" value="<?php echo (isset($udaje['nazev_tymu'])) ? ($udaje['nazev_tymu']) : ('') ?>" />
</div>
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
	for($k=1920;$k<=2016;$k++){
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
	$str .= '<select name="tricko_'.$i.'" class="form-control placeholder required">';
	$str .= '<option value="">Tričko (+250 Kč,volitelné)</option>';
	$str .= '<option value="bez">Bez trička</option>';
	foreach($tricka as $key => $val){
	    $str .= '<option value="'.$val.'"'.((isset($udaje['tricko_'.$i]) && $udaje['tricko_'.$i] == $val) ? 'selected="selected"' : '').'>'.$key.'</option>';
	}
	$str .= '</select>';
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

<div class="checkbox">
    <label>
        <input type="checkbox" name="souhlas_vseobecne_podminky" class="required" /> Souhlasím se všeobecnými podmínkami, ke stažení <a target="_blank" href="<?php echo $vseobecne_podminky ?>">ZDE</a>
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" name="souhlas_podminky_zavodu" class="required" /> Souhlasím s pravidly a podmínkami, ke stažení <a target="_blank"  href="<?php echo $pravidla_podminky ?>">ZDE</a>
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
    
    

