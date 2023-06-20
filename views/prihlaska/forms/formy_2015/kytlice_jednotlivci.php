<?php
    $id_meny = 1;//€
    $typ_prihlasky = 1;
    $poradi_podzavodu = 1;
?>

<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
<input type="hidden" name="id_meny" value="<?php echo $id_meny ?>" />
<input type="hidden" name="poradi_podzavodu" value="<?php echo $poradi_podzavodu ?>" />
<input type="hidden" name="zaplaceno" value="nezaplaceno" />

<div class="form-group">
    <input type="text" name="jmeno_1" class="form-control required" placeholder="Jméno" value="<?php echo (isset($udaje['jmeno_1'])) ? ($udaje['jmeno_1']) : ('') ?>" />
</div>

<div class="form-group">
    <input  type="text" name="prijmeni_1" class="form-control required" placeholder="Příjmení" value="<?php echo (isset($udaje['prijmeni_1'])) ? ($udaje['prijmeni_1']) : ('') ?>" />
</div>

<div class="form-group">
    <input  type="text" name="prislusnost" class="form-control required" placeholder="Oddíl nebo místo bydliště" value="<?php echo (isset($udaje['prislusnost'])) ? ($udaje['prislusnost']) : ('') ?>" />
</div>


<div class="row">
    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="den_narozeni" class="form-control required placeholder">
		<option value="" selected disabled>Den narození</option>
		<?php
		    for($i=1;$i<=31;$i++){
			echo '<option value="'.$i.'" '.((isset($udaje['den_narozeni']) && $udaje['den_narozeni'] == $i) ? 'selected="selected"' : '').'>'.$i.'</option>';
		    }
		?>
	    </select>
	</div>
    </div>
    
    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="mesic_narozeni" id="mesic_narozeni" class="form-control required placeholder">
		<option value="" selected disabled>Měsíc narození</option>
		<?php
		    for($k=1;$k<=12;$k++){
			echo '<option value="'.$k.'" '.((isset($udaje['mesic_narozeni']) && $udaje['mesic_narozeni'] == $k) ? 'selected="selected"' : '').'>'.$k.'</option>';
		    }
		?>
	    </select>
	</div>
    </div>

    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="rok_narozeni" class="form-control required placeholder">
		<option value="" selected disabled>Rok narození</option>
		<?php
		    for($j=1920;$j<=2014;$j++){
			    echo '<option value="'.$j.'" '.((isset($udaje['rok_narozeni']) && $udaje['rok_narozeni'] == $j) ? 'selected="selected"' : '').'>'.$j.'</option>';
		    }
		?>
	    </select>
	</div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="pohlavi" class="form-control required placeholder">
		<option value="" selected disabled>Pohlaví</option>
		<option value="M" <?php echo ((isset($udaje['pohlavi']) && $udaje['pohlavi'] == 'M') ? ('selected="selected"') : ('')) ?>>Muž</option>
		<option value="Z" <?php echo ((isset($udaje['pohlavi']) && $udaje['pohlavi'] == 'Z') ? ('selected="selected"') : ('')) ?>>Žena</option>
	    </select>
	</div>
    </div>

    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="stat" class="form-control required placeholder">
		<option value="" selected disabled>Stát</option>
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
    <input type="tel" name="telefon_1" class="form-control required" placeholder="Telefon" value="<?php echo (isset($udaje['telefon_1'])) ? ($udaje['telefon_1']) : ('') ?>" />
</div>

<div class="form-group"> 
    <input type="tel" name="telefon_2" class="form-control required" placeholder="Telefon alternativní (třeba pro případ zranění)" value="<?php echo (isset($udaje['telefon_2'])) ? ($udaje['telefon_2']) : ('') ?>" />
</div>
 <div class="checkbox">
    <label>
      <input type="checkbox" class="required" name="dalsi_udaje_2" value="" /> Souhlasím s prohlášením závodníka (<a style="text-decoration: underline" target="_blank" href="<?php echo URL ?>public/doc/prohlaseni-kytlice-2015.pdf">Stáhnout</a>)
    </label>
</div>
<div class="form-group"> 
<textarea placeholder="Vzkaz pořadateli, máte-li nějaký" class="form-control" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
</div>
<div class="form-group"> 
    <button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
</div>


