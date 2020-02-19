<?php
    $id_meny = 1;
    $typ_prihlasky = 1;
    $poradi_podzavodu = 1;
    
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
            for($j=1919;$j<=2018;$j++){
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

<div class="form-group">
    <input  type="email" name="mail" class="required form-control" placeholder="E-mail" value="<?php echo (isset($udaje['mail'])) ? ($udaje['mail']) : ('') ?>" />
</div>

<div class="form-group"> 
    <input type="tel" name="telefon_1" class="form-control required" placeholder="Telefon / Phone" value="<?php echo (isset($udaje['telefon_1'])) ? ($udaje['telefon_1']) : ('') ?>" />
</div>

<div class="form-group"> 
    <input type="tel" name="telefon_2" class="form-control required" placeholder="Telefon alternativní (třeba pro případ zranění) / Emergency phone" value="<?php echo (isset($udaje['telefon_2'])) ? ($udaje['telefon_2']) : ('') ?>" />
</div>


<div class="checkbox">
    <label>
        <input type="checkbox" name="souhlas_osobni_udaje" class="required" /> Souhlasím s poskytnutím osobních údajů pro potřeby této registrace
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" name="souhlas_vseobecne_podminky" class="required" /> Souhlasím se všeobecnými podmínkami, ke stažení <a target="_blank" href="https://entry.timechip.cz/public/doc/hei_duatlon_souhlas.pdf">ZDE</a>
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" name="souhlas_podminky_zavodu" class="required" /> Souhlasím s pravidly a podmínkami, ke stažení <a target="_blank"  href="https://entry.timechip.cz/public/doc/hei_duatlon_pravidla_podminky.pdf">ZDE</a>
    </label>
</div>
    
    
    <div class="form-group"> 
<textarea placeholder="Vzkaz pořadateli, máte-li nějaký / Message for the organizer" class="form-control" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
</div>
<div class="form-group"> 
    <button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
</div>