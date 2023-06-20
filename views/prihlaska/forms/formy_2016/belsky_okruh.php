<?php
    $id_meny = 1;//Kč
    $typ_prihlasky = 1;
    $poradi_podzavodu = 1;
?>
<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
<input type="hidden" name="id_meny" value="<?php echo $id_meny ?>" />
<input type="hidden" name="poradi_podzavodu" value="<?php echo $poradi_podzavodu ?>" />
<input type="hidden" name="zaplaceno" value="nezaplaceno" />

<div class="form-group"> 
    <label>Výběr tratě</label>
    <select name="poradi_podzavodu" class="form-control required placeholder">
	<option value="" selected disabled>Vyberte závod</option>
	<option value="1" <?php echo ((isset($udaje['poradi_podzavodu']) && $udaje['poradi_podzavodu'] == 1) ? ('selected="selected"') : ('')) ?>>Hlavní závod 32km (od 16 let)</option>
	<option value="2" <?php echo ((isset($udaje['poradi_podzavodu']) && $udaje['poradi_podzavodu'] == 2) ? ('selected="selected"') : ('')) ?>>Dětský okruh 8km (do 15 let)</option>
	<option value="3" <?php echo ((isset($udaje['poradi_podzavodu']) && $udaje['poradi_podzavodu'] == 3) ? ('selected="selected"') : ('')) ?>>Dětský okruh 4km (do 13 let)</option>
	<option value="4" <?php echo ((isset($udaje['poradi_podzavodu']) && $udaje['poradi_podzavodu'] == 4) ? ('selected="selected"') : ('')) ?>>Dětský okruh 2km (do 11 let)</option>
	<option value="5" <?php echo ((isset($udaje['poradi_podzavodu']) && $udaje['poradi_podzavodu'] == 5) ? ('selected="selected"') : ('')) ?>>Odrážedla (do 5 let)</option>
    </select>
</div>



<div class="form-group">
    <label for="jmeno">Jméno</label>
    <input id="jmeno" type="text" name="jmeno_1" class="form-control input-sm required" placeholder="Jméno" value="<?php echo (isset($udaje['jmeno_1'])) ? ($udaje['jmeno_1']) : ('') ?>" />
</div>

<div class="form-group">
    <label for="prijmeni">Prijmeni</label>
    <input  id="prijmeni" type="text" name="prijmeni_1" class="form-control input-sm  required" placeholder="Příjmení" value="<?php echo (isset($udaje['prijmeni_1'])) ? ($udaje['prijmeni_1']) : ('') ?>" />
</div>

<div class="form-group">
 <label for="obec">Tým nebo město/obec</label>
 <input id="obec" type="text" name="prislusnost" class="form-control  input-sm  required" placeholder="Tým nebo město/obec" value="<?php echo (isset($udaje['prislusnost'])) ? ($udaje['prislusnost']) : ('') ?>" />
</div>




<div class="form-group"> 
    <label>Den narození</label>

    <select name="den_narozeni" class="form-control input-sm  required placeholder">
	<option value="" selected disabled>Den narození</option>
	<?php
	    for($i=1;$i<=31;$i++){
		echo '<option value="'.$i.'" '.((isset($udaje['den_narozeni']) && $udaje['den_narozeni'] == $i) ? 'selected="selected"' : '').'>'.$i.'</option>';
	    }
	?>
    </select>
</div>
<div class="form-group"> 
    <label>Měsíc narození</label>
    <select name="mesic_narozeni" id="mesic_narozeni" class="form-control input-sm  required placeholder">
	<option value="" selected disabled>Měsíc narození</option>
	<?php
	    for($k=1;$k<=12;$k++){
		echo '<option value="'.$k.'" '.((isset($udaje['mesic_narozeni']) && $udaje['mesic_narozeni'] == $k) ? 'selected="selected"' : '').'>'.$k.'</option>';
	    }
	?>
    </select>
</div>
<div class="form-group"> 
   <label>Rok narození</label>
   <select name="rok_narozeni" class="form-control input-sm required placeholder">
	<option value="" selected disabled>Rok narození</option>
	<?php
	    for($j=1920;$j<=2014;$j++){
		    echo '<option value="'.$j.'" '.((isset($udaje['rok_narozeni']) && $udaje['rok_narozeni'] == $j) ? 'selected="selected"' : '').'>'.$j.'</option>';
	    }
	?>
    </select>
</div>


<div class="form-group"> 
   <label>Pohlaví</label>
    <select name="pohlavi" class="form-control input-sm required placeholder">
	<option value="" selected disabled>Pohlaví</option>
	<option value="M" <?php echo ((isset($udaje['pohlavi']) && $udaje['pohlavi'] == 'M') ? ('selected="selected"') : ('')) ?>>Muž</option>
	<option value="Z" <?php echo ((isset($udaje['pohlavi']) && $udaje['pohlavi'] == 'Z') ? ('selected="selected"') : ('')) ?>>Žena</option>
    </select>
</div>
<div class="form-group"> 
   <label>Stát</label>
    <select name="stat" class="form-control input-sm required placeholder">
	<option value="" selected disabled>Stát</option>
	<?php
	    foreach($this->seznam_statu as $key => $val){
		echo '<option value="'.$key.'"'.((isset($udaje['stat']) && $udaje['stat'] == $key) ? 'selected="selected"' : '').'>'.$val.'</option>';
	    }
	?>
    </select>
</div>


<div class="form-group">
    <label for="mail">E-mail</label>
    <input id="mail" type="email" name="mail" class="required form-control input-sm" placeholder="E-mail" value="<?php echo (isset($udaje['mail'])) ? ($udaje['mail']) : ('') ?>" />
</div>

<div class="form-group"> 
  <label for="telefon_1">Telefon</label>
   <input id="telefon_1" type="tel" name="telefon_1" class="form-control  input-smrequired" placeholder="Telefon" value="<?php echo (isset($udaje['telefon_1'])) ? ($udaje['telefon_1']) : ('') ?>" />
</div>

<div class="form-group"> 
   <label for="telefon_2">Telefon alternativní (třeba pro případ zranění)</label>
    <input id="telefon_2" type="tel" name="telefon_2" class="form-control  input-smrequired" placeholder="Telefon alternativní (třeba pro případ zranění)" value="<?php echo (isset($udaje['telefon_2'])) ? ($udaje['telefon_2']) : ('') ?>" />
</div>
 <div class="checkbox">
    <label>
	<input type="checkbox" name="elite" value="1" <?php echo (isset($udaje['open'])) ? ("checked") : ('') ?> /> <span style="color:red">Kategorie ELITE</span> (zašktnete pouze v případě, patříte-li do kategorie ELITE, <a style="text-decoration: underline" target="_blank" href="http://www.prajzska.eu/?page_id=447">bližší info zde</a>)
    </label>
</div>

<div class="form-group"> 
<textarea placeholder="Vzkaz pořadateli, máte-li nějaký" class="form-control input-sm" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
</div>
<div class="form-group"> 
    <button type="submit" class="form-control input-sm btn btn-primary">Zkontrolovat údaje</button>
</div>
