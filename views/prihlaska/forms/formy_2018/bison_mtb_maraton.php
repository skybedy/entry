<input type="hidden" name="typ_prihlasky" value="1" />
<input type="hidden" name="id_meny" value="1" />
<input type="hidden" name="zaplaceno" value="nezaplaceno" />
<input type="hidden" name="poradi_podzavodu" value="<?php echo $poradi_podzavodu ?>" />


<div class="form-group">
    <input type="text" name="jmeno_1" class="form-control required" placeholder="Meno" value="<?php echo (isset($udaje['jmeno_1'])) ? ($udaje['jmeno_1']) : ('') ?>" />
</div>

<div class="form-group">
    <input  type="text" name="prijmeni_1" class="form-control required" placeholder="Priezvisko" value="<?php echo (isset($udaje['prijmeni_1'])) ? ($udaje['prijmeni_1']) : ('') ?>" />
</div>

<div class="form-group">
    <input  type="text" name="prislusnost" class="form-control required" placeholder="Tým alebo miesto bydliska" value="<?php echo (isset($udaje['prislusnost'])) ? ($udaje['prislusnost']) : ('') ?>" />
</div>


<div class="row">
    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="den_narozeni" class="form-control required placeholder">
		<option value="" selected disabled>Deň narodenia</option>
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
		<option value="" selected disabled>Mesiac narodenia</option>
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
		<option value="" selected disabled>Rok narodenia</option>
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
		<option value="" selected disabled>Pohlavie</option>
		<option value="M" <?php echo ((isset($udaje['pohlavi']) && $udaje['pohlavi'] == 'M') ? ('selected="selected"') : ('')) ?>>Muž</option>
		<option value="Z" <?php echo ((isset($udaje['pohlavi']) && $udaje['pohlavi'] == 'Z') ? ('selected="selected"') : ('')) ?>>Žena</option>
	    </select>
	</div>
    </div>

    <div class="col-lg-4">
	<div class="form-group"> 
	    <select name="stat" class="form-control required placeholder">
		<option value="" selected disabled>Štát</option>
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
    <input type="tel" name="telefon_1" class="form-control required" placeholder="Telefón" value="<?php echo (isset($udaje['telefon_1'])) ? ($udaje['telefon_1']) : ('') ?>" />
</div>

<div class="form-group"> 
    <input type="tel" name="telefon_2" class="form-control required" placeholder="Telefón alternatívny (treba pre priepad zranenia)" value="<?php echo (isset($udaje['telefon_2'])) ? ($udaje['telefon_2']) : ('') ?>" />
</div>

<div class="radio">
    <label><input type="radio" name="ostatni_udaje_1" class="required" value="7.5"><a target="_blank" href="http://www.bikepoint.sk/maraton/startovne">Štartovné bez štartovného balíčka - - bez stravy a nápoja - 7,5 €</a></label>
</div>
<div class="radio">
    <label><input type="radio" name="ostatni_udaje_1" class="required" value="15"><a target="_blank" href="http://www.bikepoint.sk/maraton/startovne">Štartovné so štartovným balíčkom - 15 €</a></label>
</div>





<div class="form-group"> 
<textarea placeholder="Odkaz usporiadateľovi, ak máte nejaký" class="form-control" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
</div>
<div class="form-group"> 
    <button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
</div>


