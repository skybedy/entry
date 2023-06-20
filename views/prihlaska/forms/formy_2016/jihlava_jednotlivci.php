<?php
    //tričko tady není povinné, takže nemá required
    $id_meny = 2;//€
    $typ_prihlasky = 1;
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
    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="tricko" class="form-control placeholder">
		<option value="" selected>Tričko (+250Kč, nepovinné)</option>
		<option value="">Bez trička</option>
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
    <input type="tel" name="telefon_1" class="form-control required" placeholder="Telefon" value="<?php echo (isset($udaje['telefon_1'])) ? ($udaje['telefon_1']) : ('') ?>" />
</div>

<div class="form-group"> 
    <input type="tel" name="telefon_2" class="form-control required" placeholder="Telefon alternativní (třeba pro případ zranění)" value="<?php echo (isset($udaje['telefon_2'])) ? ($udaje['telefon_2']) : ('') ?>" />
</div>
<div class="form-group"> 
    <input name="dalsi_udaje_1" class="form-control" placeholder="Značka kola (třeba pro případ odcizení, nepovinné)" value="<?php echo (isset($udaje['dalsi_udaje_1'])) ? ($udaje['dalsi_udaje_1']) : ('') ?>" />
</div>
 <div class="checkbox">
    <label>
      <input type="checkbox" name="open" value="1" <?php echo (isset($udaje['open'])) ? ("checked") : ('') ?> /> Open, (zašktnete pouze v případě, že vám je letos více než 39 let a chcete startovat v kategorii Open)
    </label>
</div>
 <div class="checkbox">
    <label>
      <input type="checkbox" name="dalsi_udaje_2" value="pojisteni"  <?php echo (isset($udaje['dalsi_udaje_2'])) ? ("checked") : ('') ?> /> Pojištění České Pojišťovny, (+306Kč, nepovinné)
    </label>
    <span  class="glyphicon glyphicon-question-sign pojisteni_popover"  data-toggle="popover" title="Obecné informace o pojišťění" data-content="Doba nezbytného léčení DNL-D  200,- Kč. Trvalé následky úrazu 600 000,- Kč Smrt následkem úrazu 300 000,- Kč" aria-hidden="true"></span>
</div>
<div class="form-group"> 
<textarea placeholder="Vzkaz pořadateli, máte-li nějaký" class="form-control" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
</div>
<div class="form-group"> 
    <button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
</div>
