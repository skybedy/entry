<h1>Výpis přihlášek</h1>
<div id="left">
	<?php	if(!$this->VypisPrihlasek): ?>
			<p>Na tento závod ještě není nikdo přihlášen.</p>
	<?php else:	echo $this->VypisPrihlasek; ?>
	<?php endif; ?>
</div>
<!-- reklamy --> 
<div id="reklamy" style="margin-top: 50px">
    <div class="reklama">
	<a class="nadpis" target="_blank" href="http://www.visalajka.cz">Oraz na Visalajích</a>
	<p class="obsah">Horská chata Visalajka, celoroční ubytování v Beskydech za dobré peníze.</p>
	<a class="link" target="_blank" href="http://www.visalajka.cz">www.visalajka.cz</a>
    </div>
    <div class="reklama">
	<a class="nadpis" target="_blank" href="http://www.timechip.cz">TimeChip</a>
	<p class="obsah">Zpracování výsledků závodů pomocí čipové technologie za dostupné ceny.</p>
	<a class="link" target="_blank" href="http://www.timechip.cz">www.timechip.cz</a>
    </div>
    <?php
	if($this->reklamy){
	    $str = '';
	    foreach($this->reklamy as $val){
		$str .= '<div class="reklama">';
		$str .= '<a class="nadpis" target="_blank" href="http://'.$val['odkaz'].'">'.$val['nazev'].'</a>';
		$str .= '<p class="obsah">'.$val['obsah'].'</p>';
		$str .= '<a class="link" target="_blank" href="http://'.$val['odkaz'].'">'.$val['odkaz'].'</a>';

		$str .= '</div>';
	    }
	    echo $str;		
	}
    ?>
</div>
