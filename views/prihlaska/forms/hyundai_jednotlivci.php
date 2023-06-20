<?php
    $id_meny = 1;
    $typ_prihlasky = 1;
    $poradi_podzavodu = 1;
?>
<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
<input type="hidden" name="id_meny" value="<?php echo $id_meny ?>" />
<input type="hidden" name="poradi_podzavodu" value="<?php echo $poradi_podzavodu ?>" />
<input type="hidden" name="poradi_podzavodu" value="<?php echo $poradi_podzavodu ?>" />
<input type="hidden" name="zaplaceno" value="nezaplaceno" />
<input type="hidden" name="prislusnost" value="Hyundai Team" />

<div class="form-group">
    <input type="text" name="jmeno_1" class="form-control required" placeholder="Jméno / Name" value="<?php echo (isset($udaje['jmeno_1'])) ? ($udaje['jmeno_1']) : ('') ?>" />
</div>

<div class="form-group">
    <input  type="text" name="prijmeni_1" class="form-control required" placeholder="Příjmení / Surname" value="<?php echo (isset($udaje['prijmeni_1'])) ? ($udaje['prijmeni_1']) : ('') ?>" />
</div>


<div class="row">
    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="rok_narozeni" class="form-control required placeholder">
		<option value="" selected disabled>Rok narození / Birth year</option>
		<?php
		    for($j=1920;$j<=2019;$j++){
			    echo '<option value="'.$j.'" '.((isset($udaje['rok_narozeni']) && $udaje['rok_narozeni'] == $j) ? 'selected="selected"' : '').'>'.$j.'</option>';
		    }
		?>
	    </select>
	</div>
    </div>
    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="pohlavi" class="form-control required placeholder">
		<option value="" selected disabled>Pohlaví / Sex</option>
		<option value="M" <?php echo ((isset($udaje['pohlavi']) && $udaje['pohlavi'] == 'M') ? ('selected="selected"') : ('')) ?>>Muž</option>
		<option value="Z" <?php echo ((isset($udaje['pohlavi']) && $udaje['pohlavi'] == 'Z') ? ('selected="selected"') : ('')) ?>>Žena</option>
	    </select>
	</div>
    </div>

    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="stat" class="form-control required placeholder">
		<option value="" selected disabled>Stát / country</option>
		<?php
		    foreach($this->seznam_statu as $key => $val){
			echo '<option value="'.$key.'"'.((isset($udaje['stat']) && $udaje['stat'] == $key) ? 'selected="selected"' : '').'>'.$val.'</option>';
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
    <input type="tel" name="telefon_1" class="form-control" placeholder="Telefon - nepovinné, uveďte jen v případě, pokud chcete dostat SMS s Vašim časem / Phone" value="<?php echo (isset($udaje['telefon_1'])) ? ($udaje['telefon_1']) : ('') ?>" />
</div>
<div class="form-group"> 
    <select name="dalsi_udaje_1" class="form-control required placeholder">
        <option value="" selected disabled>Zaměstnanec Hyundai / Rodinný příslušník / Employee of Hyundai / Family member</option>
        <option value="zamestanenec" <?php echo ((isset($udaje['dalsi_udaje_1']) && $udaje['dalsi_udaje_1'] == 'zamestnanec') ? ('selected="selected"') : ('')) ?>>Zaměstnanec</option>
        <option value="rodinny_prislusnik" <?php echo ((isset($udaje['dalsi_udaje_1']) && $udaje['dalsi_udaje_1'] == 'rodinny_prislusnik') ? ('selected="selected"') : ('')) ?>>Rodiný přílsušník</option>
    </select>
</div>


  <div class="checkbox">
    <label>
        <input type="checkbox" name="souhlas_osobni_udaje" class="required" /> Propozice, ke stažení <a target="_blank" href="https://entry.timechip.cz/public/doc/hyundai_beh_propozice.pdf">ZDE</a>
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" name="souhlas_vseobecne_podminky" class="required" /> Souhlasím se všeobecnými podmínkami, ke stažení <a target="_blank" href="https://entry.timechip.cz/public/doc/hyundai_beh_vseobecne_podminky.pdf">ZDE</a>
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox" name="souhlas_podminky_zavodu" class="required" /> Souhlasím se zpracováním osobních údajů, ke stažení <a target="_blank"  href="https://entry.timechip.cz/public/doc/hyundai_beh_zpracovani_osobnich_udaju.pdf">ZDE</a>
    </label>
</div>

<div class="form-group"> 
<textarea placeholder="Vzkaz pořadateli, máte-li nějaký / Message to organizer" class="form-control" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
</div>
<div class="form-group"> 
    <button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
</div>

