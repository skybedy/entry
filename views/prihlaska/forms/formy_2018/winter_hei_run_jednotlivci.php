<?php
    $id_meny = 1;
    $typ_prihlasky = 1;
    $poradi_podzavodu = 1;
    $vlny = Array();
    /*
    $vlny[1] = "9:30";
    $vlny[2] = "9:45";
    $vlny[3] = "10:00";
    $vlny[4] = "10:15";
    $vlny[5] = "10:30";
    $vlny[6] = "10:45";
    $vlny[7] = "11:00";
    $vlny[8] = "11:15";
    $vlny[9] = "11:30";
    $vlny[10] = "11:45";
    $vlny[11] = "12:00";
    $vlny[12] = "12:15";
    $vlny[13] = "12:30";
    $vlny[14] = "12:45";
    $vlny[15] = "13:00";
    */
    
    /*
    $vlny[0] = "9:30";
    $vlny[1] = "9:45";
    $vlny[2] = "10:00";
    $vlny[3] = "10:15";
    $vlny[4] = "10:30";
    $vlny[5] = "10:45";
    $vlny[6] = "11:00";
    $vlny[7] = "11:15";
    $vlny[8] = "11:30";
    $vlny[9] = "11:45";
    $vlny[10] = "12:00";
    $vlny[11] = "12:15";
    $vlny[12] = "12:30";
    $vlny[13] = "12:45";
    $vlny[14] = "13:00";
    */
    
    
   // $vlny[0] = "10:00";
    //$vlny[1] = "10:20";
    //$vlny[2] = "10:40";
    $vlny[3] = "11:00";
    $vlny[4] = "11:20";
    $vlny[5] = "11:40";
    $vlny[6] = "12:00";
    $vlny[7] = "12:20";
    $vlny[8] = "12:40";
    $vlny[9] = "13:00";
    $vlny[10] = "13:20";
    $vlny[11] = "13:40";
?>

<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
<input type="hidden" name="id_meny" value="<?php echo $id_meny ?>" />
<input type="hidden" name="zaplaceno" value="nezaplaceno" />
<input type="hidden" name="poradi_podzavodu" value="<?php echo $poradi_podzavodu ?>" />

<div class="form-group">
    <input type="text" name="jmeno_1" class="form-control required" placeholder="Jméno / Firstname" value="<?php echo (isset($udaje['jmeno_1'])) ? ($udaje['jmeno_1']) : ('') ?>" />
</div>

<div class="form-group">
    <input  type="text" name="prijmeni_1" class="form-control required" placeholder="Příjmení / Surname" value="<?php echo (isset($udaje['prijmeni_1'])) ? ($udaje['prijmeni_1']) : ('') ?>" />
</div>

<div class="form-group">
    <input  type="text" name="prislusnost" class="form-control required" placeholder="Oddíl nebo místo bydliště / Team or city of residence" value="<?php echo (isset($udaje['prislusnost'])) ? ($udaje['prislusnost']) : ('') ?>" />
</div>
<div class="form-group"> 
    <select name="rok_narozeni" class="form-control required placeholder">
        <option value="" selected disabled>Rok narození / Year of birth</option>
        <?php
            for($j=1919;$j<=2003;$j++){
                    echo '<option value="'.$j.'" '.((isset($udaje['rok_narozeni']) && $udaje['rok_narozeni'] == $j) ? 'selected="selected"' : '').'>'.$j.'</option>';
            }
        ?>
    </select>
</div>

<div class="row">
    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="pohlavi" class="form-control required placeholder">
		<option value="" selected disabled>Pohlaví / Gender</option>
		<option value="M" <?php echo ((isset($udaje['pohlavi']) && $udaje['pohlavi'] == 'M') ? ('selected="selected"') : ('')) ?>>Muž</option>
		<option value="Z" <?php echo ((isset($udaje['pohlavi']) && $udaje['pohlavi'] == 'Z') ? ('selected="selected"') : ('')) ?>>Žena</option>
	    </select>
	</div>
    </div>

    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="stat" class="form-control required placeholder">
		<option value="" selected disabled>Stát / Country</option>
		<?php
		    foreach($this->seznam_statu as $key => $val){
			echo '<option value="'.$key.'"'.((isset($udaje['stat']) && $udaje['stat'] == $key) ? 'selected="selected"' : '').'>'.$val.'</option>';
		    }
		?>
	    </select>
	</div>
    </div>
    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="tricko" class="form-control placeholder  required">
		<option value="" selected>Tričko / Shirt (+250 Kč, volitelné)</option>
                <option value="bez">Bez trička</option>';

		<?php		
		    $tricka = Array();
		    $tricka['S'] = 'S';
		    $tricka['M'] = 'M';
		    $tricka['L'] = 'L';
		    $tricka['XL'] = 'XL';
		    $tricka['XXL'] = 'XXL';
		    foreach($tricka as $key => $val){
			echo '<option value="'.$val.'"'.((isset($udaje['tricko']) && $udaje['tricko'] == $val) ? 'selected="selected"' : '').'>'.$key.'</option>';
		    }
		?>
	    </select>
	</div>
    </div>
    
</div>
<div class="checkbox">
    <label>
        <input type="checkbox" name="dalsi_udaje_2" /> Chci se účastnit doprovodného programu Heipark day za 100 Kč
    </label>
</div>

<div class="form-group">
    <input  type="email" name="mail" class="required form-control" placeholder="E-mail" value="<?php echo (isset($udaje['mail'])) ? ($udaje['mail']) : ('') ?>" />
</div>

<div class="form-group"> 
    <input type="tel" name="telefon_1" class="form-control required" placeholder="Telefon / Phone" value="<?php echo (isset($udaje['telefon_1'])) ? ($udaje['telefon_1']) : ('') ?>" />
</div>

<div class="form-group"> 
    <input type="tel" name="telefon_2" class="form-control required" placeholder="Telefon alternativní (třeba pro případ zranění) / Emergency phone" value="<?php echo (isset($udaje['telefon_2'])) ? ($udaje['telefon_2']) : ('') ?>" />
</div>

<div class="form-group"> 
    <select name="dalsi_udaje_1" class="form-control required placeholder">
        <option value="" selected disabled>Výběr vlny</option>
        <?php
            $i = 0;
            foreach($this->vlny as $val){
                if($val <= 20){
                    echo '<option value="'.$vlny[$i].'"';
                    if(isset($_GET['dalsi_udaje_1'])){
                        if($udaje['dalsi_udaje_1'] == $vlny[$i]){
                            echo ' selected="selected" ';
                        }
                    }
                    echo '>'.$vlny[$i].'</option>';  
                }
                $i++;
            }
        ?>
    </select>
</div>


<div class="checkbox">
    <label>
        <input type="checkbox" name="souhlas_osobni_udaje" class="required" /> Souhlasím s poskytnutím osobních údajů pro potřeby této registrace
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" name="souhlas_vseobecne_podminky" class="required" /> Souhlasím se všeobecnými podmínkami, ke stažení <a target="_blank" href="https://entry.timechip.cz/public/doc/hei_run_vseobecne_podminky.pdf">ZDE</a>
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" name="souhlas_podminky_zavodu" class="required" /> Souhlasím s pravidly a podmínkami, ke stažení <a target="_blank"  href="https://entry.timechip.cz/public/doc/hei_run_pravidla_podminky.pdf">ZDE</a>
    </label>
</div>
    
    
    <div class="form-group"> 
<textarea placeholder="Vzkaz pořadateli, máte-li nějaký / Message for the organizer" class="form-control" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
</div>
<div class="form-group"> 
    <button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
</div>