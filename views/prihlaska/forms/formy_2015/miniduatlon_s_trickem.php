<?php
    //tričko tady není povinné, takže nemá required
    $id_meny = 1;//€
    $typ_prihlasky = 1;
?>
<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
<input type="hidden" name="id_meny" value="<?php echo $id_meny ?>" />
<input type="hidden" name="poradi_podzavodu" value="1" />
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
		<option value="" selected>Tričko</option>
		<option value="">Bez trička</option>
		<?php		
		    $tricka = Array();
		    
		    $tricka['S pánské bavlněné (+135)'] = 'S pánské bavlněné';
		    $tricka['M pánské bavlněné (+135)'] = 'M pánské bavlněné';
		    $tricka['L pánské bavlněné (+135)'] = 'L pánské bavlněné';
		    $tricka['XL pánské bavlněné (+135)'] = 'XL pánské bavlněné';
		    $tricka['XXL pánské bavlněné (+135)'] = 'XXL pánské bavlněné';
		    $tricka['XS dámské bavlněné (+135)'] = 'XS dámské bavlněné';
		    $tricka['S dámské bavlněné (+135)'] = 'S dámské bavlněné';
		    $tricka['M dámské bavlněné (+135)'] = 'M dámské bavlněné';
		    $tricka['L dámské bavlněné (+135)'] = 'L dámské bavlněné';
		    $tricka['XL dámské bavlněné (+135)'] = 'XL dámské bavlněné';
		    $tricka['S pánské funkční (+315)'] = 'S pánské funkční';
		    $tricka['M pánské funkční (+315)'] = 'M pánské funkční';
		    $tricka['L pánské funkční (+315)'] = 'L pánské funkční';
		    $tricka['XL pánské funkční (+315)'] = 'XL pánské funkční';
		    $tricka['XXL pánské funkční (+315)'] = 'XXL pánské funkční';
		    $tricka['XS dámské funkční (+315)'] = 'XS dámské funkční';
		    $tricka['S dámské funkční (+315)'] = 'S dámské funkční';
		    $tricka['M dámské funkční (+315)'] = 'M dámské funkční';
		    $tricka['L dámské funkční (+315)'] = 'L dámské funkční';
		    $tricka['XL dámské funkční (+315)'] = 'XL dámské funkční';
		   

		    /*
		    $tricka[1] = 'S pánské bavlněné';
		    $tricka[2] = 'M pánské bavlněné';
		    $tricka[3] = 'L pánské bavlněné';
		    $tricka[4] = 'XL pánské bavlněné';
		    $tricka[5] = 'XXL pánské bavlněné';
		    $tricka[6] = 'XS dámské bavlněné';
		    $tricka[7] = 'S dámské bavlněné';
		    $tricka[8] = 'M dámské bavlněné';
		    $tricka[9] = 'L dámské bavlněné';
		    $tricka[10] = 'XL dámské bavlněné';
		    $tricka[11] = 'S pánské funkční';
		    $tricka[12] = 'M pánské funkční';
		    $tricka[13] = 'L pánské funkční';
		    $tricka[14] = 'XL pánské funkční';
		    $tricka[15] = 'XXL pánské funkční';
		    $tricka[16] = 'XS dámské funkční';
		    $tricka[17] = 'S dámské funkční';
		    $tricka[18] = 'M dámské funkční';
		    $tricka[19] = 'L dámské funkční';
		    $tricka[20] = 'XL dámské funkční';
			*/
		    
		    
		    
		    
		    
		    foreach($tricka as $key => $val){
			echo '<option value="'.$key.'"'.((isset($udaje['tricko']) && $udaje['tricko'] == $val) ? 'selected="selected"' : '').'>'.$val.'</option>';
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
<textarea placeholder="Vzkaz pořadateli, máte-li nějaký" class="form-control" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
</div>
<div class="form-group"> 
    <button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
</div>

