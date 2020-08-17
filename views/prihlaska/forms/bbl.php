<?php
    $id_meny = 1;
    $typ_prihlasky = 1;
?>

<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
<input type="hidden" name="id_meny" value="<?php echo $id_meny ?>" />
<input type="hidden" name="zaplaceno" value="nezaplaceno" />
<input type="hidden" name="race_id" value="<?php echo $_SESSION['race_id'] ?>" />
<input type="hidden" name="kontrola_kategorie" value="1" />

<div class="form-group"> 
    <select name="poradi_podzavodu" class="form-control required placeholder">
	<option value="" selected disabled>Vyberte závod</option>
	<option value="1" <?php echo ((isset($udaje['poradi_podzavodu']) && $udaje['poradi_podzavodu'] == 1) ? ('selected="selected"') : ('')) ?>>30 km</option>
	<option value="2" <?php echo ((isset($udaje['poradi_podzavodu']) && $udaje['poradi_podzavodu'] == 2) ? ('selected="selected"') : ('')) ?>>50 km</option>
	<option value="3" <?php echo ((isset($udaje['poradi_podzavodu']) && $udaje['poradi_podzavodu'] == 3) ? ('selected="selected"') : ('')) ?>>80 km</option>
	<option value="4" <?php echo ((isset($udaje['poradi_podzavodu']) && $udaje['poradi_podzavodu'] == 4) ? ('selected="selected"') : ('')) ?>>Předžáci, předžákyně (2014+)</option>
	<option value="5" <?php echo ((isset($udaje['poradi_podzavodu']) && $udaje['poradi_podzavodu'] == 5) ? ('selected="selected"') : ('')) ?>>Žáci, žákyně (2011-2013)</option>
	<option value="6" <?php echo ((isset($udaje['poradi_podzavodu']) && $udaje['poradi_podzavodu'] == 6) ? ('selected="selected"') : ('')) ?>>Mladší žáci, žákyně (2008-2010)</option>
	<option value="7" <?php echo ((isset($udaje['poradi_podzavodu']) && $udaje['poradi_podzavodu'] == 7) ? ('selected="selected"') : ('')) ?>>Starší žáci, žákyně (2006-2007)</option>
	<option value="9" <?php echo ((isset($udaje['poradi_podzavodu']) && $udaje['poradi_podzavodu'] == 9) ? ('selected="selected"') : ('')) ?>>Koloběžky (30km)</option>
    </select>
</div>



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
	    <select name="rok_narozeni" class="form-control required placeholder">
		<option value="" selected disabled>Rok narození</option>
		<?php
		    for($j=1920;$j<=2017;$j++){
			    echo '<option value="'.$j.'" '.((isset($udaje['rok_narozeni']) && $udaje['rok_narozeni'] == $j) ? 'selected="selected"' : '').'>'.$j.'</option>';
		    }
		?>
	    </select>
	</div>
    </div>
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
	   <select name="tricko" class="form-control placeholder  required">
		<option value="" selected>Tričko </option>
		<option value="bez">Bez trička</option>
		<?php	
                
		    $tricka = Array();
		   $tricka['S'] = 'S';
		    $tricka['M'] = 'M';
		    $tricka['L'] = 'L';
		    $tricka['XL'] = 'XL';
		    $tricka['XXL'] = 'XXL';
		    foreach($tricka as $key => $val){
			echo '<option value="'.$val.'"'.((isset($udaje['tricko']) && $udaje['tricko'] == $val) ? 'selected="selected"' : '').'>'.$val.'</option>';
		    }
		?>
	    </select>
	</div>

<input type="hidden" name="trickobez" value="bez" />

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
        <input type="checkbox" name="prohlaseni_zavodnika" class="required" /> Souhlasím s poskytnutím osobních údajů včetně dalších podmínek uvedených v předpisu závodu Bike Babí léto viz <b><a target="_blank" href="http://goodway.cz/cs/propozice/">propozice</a></b><br /><br />
    </label>
</div>

<div class="form-group"> 
<textarea placeholder="Vzkaz pořadateli, máte-li nějaký" class="form-control" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
</div>
<div class="form-group"> 
    <button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
</div>

