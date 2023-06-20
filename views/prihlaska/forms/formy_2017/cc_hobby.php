<?php
    $id_meny = 1;//Kč
    $typ_prihlasky = 1;
    $poradi_podzavodu = 1;
?>
<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
<input type="hidden" name="id_meny" value="<?php echo $id_meny ?>" />
<input type="hidden" name="poradi_podzavodu" value="<?php echo $poradi_podzavodu ?>" />
<input type="hidden" name="zaplaceno" value="nezaplaceno" />
<span style="color:red">Před vyplněním formuláře si ještě jednou ujasněte, že se chcete opravdu přihlásit do závodů Hobby a ne do závodů MČR, nebo Poháru CAMS.</span>
<div class="form-group">
    <label for="jmeno">Jméno</label>
    <input id="jmeno" type="text" name="jmeno_1" class="form-control required" placeholder="Jméno" value="<?php echo (isset($udaje['jmeno_1'])) ? ($udaje['jmeno_1']) : ('') ?>" />
</div>

<div class="form-group">
    <label for="prijmeni">Prijmeni</label>
    <input  id="prijmeni" type="text" name="prijmeni_1" class="form-control required" placeholder="Příjmení" value="<?php echo (isset($udaje['prijmeni_1'])) ? ($udaje['prijmeni_1']) : ('') ?>" />
</div>
 <div class="checkbox">
    <label>
      <input type="checkbox" name="open" value="1" <?php echo (isset($udaje['open'])) ? ("checked") : ('') ?> /> Open (zašktnete pouze v případě, je-li vám více než 40 let, ale chcete startovat v kategorii Open)
    </label>
</div>
<div class="form-group">
 <label for="obec">Tým nebo město/obec</label>
 <input id="obec" type="text" name="prislusnost" class="form-control required" placeholder="Tým nebo město/obec" value="<?php echo (isset($udaje['prislusnost'])) ? ($udaje['prislusnost']) : ('') ?>" />
</div>

<div class="form-group">
 <label for="ids">Startovní číslo - ve <a target="_blank" style="text-decoration: underline" href="<?php echo URL?>prihlaska/vypis-prihlasek">výpisu přihlášek</a> si zkontrolujte, zda je požadované startovní číslo volné</label>
 <input id="ids" type="text" name="ids" class="form-control required" placeholder="Startovní číslo" value="<?php echo (isset($udaje['ids'])) ? ($udaje['ids']) : ('') ?>" />
</div>



<div class="form-group"> 
    <label>Den narození</label>

    <select name="den_narozeni" class="form-control required placeholder">
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
    <select name="mesic_narozeni" id="mesic_narozeni" class="form-control required placeholder">
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
   <select name="rok_narozeni" class="form-control required placeholder">
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
    <select name="pohlavi" class="form-control required placeholder">
	<option value="" selected disabled>Pohlaví</option>
	<option value="M" <?php echo ((isset($udaje['pohlavi']) && $udaje['pohlavi'] == 'M') ? ('selected="selected"') : ('')) ?>>Muž</option>
	<option value="Z" <?php echo ((isset($udaje['pohlavi']) && $udaje['pohlavi'] == 'Z') ? ('selected="selected"') : ('')) ?>>Žena</option>
    </select>
</div>
<div class="form-group"> 
   <label>Stát</label>
    <select name="stat" class="form-control required placeholder">
	<option value="" selected disabled>Stát</option>
	<?php
	    foreach($this->seznam_statu as $key => $val){
		echo '<option value="'.$key.'"'.((isset($udaje['stat']) && $udaje['stat'] == $key) ? 'selected="selected"' : '').'>'.$val.'</option>';
	    }
	?>
    </select>
</div>


<div class="form-group"> 
  <label>Zdravotní pojišťovna</label>
  <select name="dalsi_udaje_1" class="form-control required placeholder">
	<option value="" selected disabled>Zdravotní pojišťovna</option>
	<?php
	    foreach($this->zdravotni_pojistovny as $val){
		echo '<option value="'.$val->kod_pojistovny.'"'.((isset($udaje['dalsi_udaje_1']) && $udaje['dalsi_udaje_1'] == $val->kod_pojistovny) ? 'selected="selected"' : '').'>'.$val->nazev_pojistovny.'</option>';
	    }
	?>
    </select>
</div>


<div class="form-group"> 
   <label>Značka motocyklu</label>
    <select name="dalsi_udaje_2" class="form-control required placeholder">
	<option value="" selected disabled>Značka motocyklu</option>
	<?php
	    foreach($this->znacky_motocyklu as  $val){
		echo '<option value="'.$val->id_motocyklu.'"'.((isset($udaje['dalsi_udaje_2']) && $udaje['dalsi_udaje_2'] == $val->id_motocyklu) ? 'selected="selected"' : '').'>'.$val->nazev_motocyklu.'</option>';
	    }
	?>
    </select>
</div>

<div class="form-group"> 
   <label>Objem mtoru</label>
   <select name="dalsi_udaje_3" class="form-control required placeholder">
	<option value="" selected disabled>Objem motoru</option>
	<?php
	    foreach($this->objemy_motoru as $val){
		echo '<option value="'.$val->objem_motoru.'"'.((isset($udaje['dalsi_udaje_3']) && $udaje['dalsi_udaje_3'] == $val->objem_motoru) ? 'selected="selected"' : '').'>'.$val->objem_motoru.'</option>';
	    }
	?>
    </select>
</div>


<div class="form-group"> 
    <label for="znacka_prilby">Značka přilby (nepovinné)</label>
    <input id="znacka_prilby" name="dalsi_udaje_4" class="form-control" placeholder="Značka přilby (nepovinné)" value="<?php echo (isset($udaje['dalsi_udaje_4'])) ? ($udaje['dalsi_udaje_4']) : ('') ?>" />
</div>

<div class="form-group"> 
    <label for="homologace_prilby">Homologace přilby (nepovinné)</label>
    <input id="homologace_prilby" name="dalsi_udaje_5" class="form-control" placeholder="Homologace přilby (nepovinné)" value="<?php echo (isset($udaje['dalsi_udaje_5'])) ? ($udaje['dalsi_udaje_5']) : ('') ?>" />
</div>

<div class="form-group">
    <label for="mail">E-mail</label>
    <input id="mail" type="email" name="mail" class="required form-control" placeholder="E-mail" value="<?php echo (isset($udaje['mail'])) ? ($udaje['mail']) : ('') ?>" />
</div>

<div class="form-group"> 
  <label for="telefon_1">Telefon</label>
   <input id="telefon_1" type="tel" name="telefon_1" class="form-control required" placeholder="Telefon" value="<?php echo (isset($udaje['telefon_1'])) ? ($udaje['telefon_1']) : ('') ?>" />
</div>

<div class="form-group"> 
   <label for="telefon_2">Telefon alternativní (třeba pro případ zranění)</label>
    <input id="telefon_2" type="tel" name="telefon_2" class="form-control required" placeholder="Telefon alternativní (třeba pro případ zranění)" value="<?php echo (isset($udaje['telefon_2'])) ? ($udaje['telefon_2']) : ('') ?>" />
</div>


<div class="form-group"> 
<textarea placeholder="Vzkaz pořadateli, máte-li nějaký" class="form-control" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
</div>
<div class="form-group"> 
    <button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
</div>

