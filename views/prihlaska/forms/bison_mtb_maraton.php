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
	    <select name="rok_narozeni" class="form-control required placeholder">
		<option value="" selected disabled>Rok narodenia</option>
		<?php
		    for($j=1920;$j<=2018;$j++){
			    echo '<option value="'.$j.'" '.((isset($udaje['rok_narozeni']) && $udaje['rok_narozeni'] == $j) ? 'selected="selected"' : '').'>'.$j.'</option>';
		    }
		?>
	    </select>
	</div>
    </div>
    
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
    <label>Ponožky jsou relevantní pouze po objednání startovního balíčku</label>
    <select name="ponozky" class="form-control placeholder">
        <option value="" selected>Číslo ponožek</option>
        <?php		
            foreach($this->ponozky as $key => $val){
                echo '<option value="'.$val.'"'.((isset($udaje['ponozky']) && $udaje['ponozky'] == $val) ? 'selected="selected"' : '').'>'.$key.'</option>';
            }
        ?>
    </select>
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
<hr>
<h4>Kategorie studenti <span  class="glyphicon glyphicon-question-sign pojisteni_popover"  data-toggle="popover" title="Informace o kategorii studenti" data-content="Pretekári sa môžu prihlásiť ak majú Internacional Student Identity Card / ISIC/ alebo INDEX, absolventi predkladajú kópiu diplomu o ukončení štúdia v roku 2017/2018. Štartovať môžu študenti (denní aj externí) všetkých troch foriem štúdia (bakalárske, magisterské, doktorandské), absolventi vysokoškolského štúdia, rok po ukončení VŠ štúdia, vek do 28 rokov. Štartovať môžu aj zahraniční študenti študujúci na VŠ v SR.
                              Štartovať môžu aj žiaci 4. Ročníka strednej školy študujúci v školskom roku 2018/2019. Na prezentácii treba predložiť potvrdenie o návšteve školy. 
                              V případě, že se vás tato kategorie týká, napište do níže uvedeného políčka název školy" aria-hidden="true"></span>
</h4>
<div class="form-group">
    <input  type="text" name="dalsi_udaje_1" class="form-control" placeholder="Název školy" value="<?php echo (isset($udaje['dalsi_udaje_1'])) ? ($udaje['dalsi_udaje_1']) : ('') ?>" />
</div>

<hr>

<div class="radio">
    <label><input type="radio" name="dalsi_udaje_2" class="required" value="bez_balicku"><a target="_blank" href="http://www.bikepoint.sk/maraton/startovne">Štartovné bez štartovného balíčka - - bez stravy a nápoja - 9€ / 250Kč</a></label>
</div>
<div class="radio">
    <label><input type="radio" name="dalsi_udaje_2" class="required" value="balicek"><a target="_blank" href="http://www.bikepoint.sk/maraton/startovne">Štartovné so štartovným balíčkom - 18 € / 500Kč</a></label>
</div>
<p>Potrobnější info ke startovním balíčkům naleznete v <b><a href="https://www.bikepoint.sk/maraton/startovne">propozicích</a></b></p>





<div class="form-group"> 
<textarea placeholder="Odkaz usporiadateľovi, ak máte nejaký" class="form-control" name="vzkaz" cols="40" rows="5"><?php echo (isset($udaje['vzkaz'])) ? ($udaje['vzkaz']) : ('') ?></textarea>
</div>
<div class="form-group"> 
    <button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
</div>


