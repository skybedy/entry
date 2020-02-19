<div class="container"><div class="panel contact"><div class="panel-body padding-bottom-none">
<?php
	if(Session::get('race_id') == 118){
		$str = 'V prípade, že vám e-mail nepríde, nenájdete sa v zozname prihlásených alebo narazíte na iný problém, kontaktujte nás prosím prostredníctvom e-mailu na <a href="mailto:timechip@timechip.cz">timechip@timechip.cz</a> alebo telefonicky na čísle +420 776 13 13 13. /  Abban az esetben, ha nem kapná meg üzenetünket, ha nem találja a nevét a listán vagy bármely más probléma esetén, kérem vegye fel velünk a kapcsolatot a <a href="mailto:timechip@timechip.cz">timechip@timechip.cz</a> e-mail címen vagy telefonon a +420 776 13 13 13-as telefonszámon.';
	}
	else{
		$str = 'Děkujeme za přihlášení, na vaši e-mailovou adresu byla odeslána zpráva s dalšími informacemi.<br />
V případě, že vám e-mail nepřijde (zkontrolujte si i složku s nevyžádanou poštou), nenajdete se ve výpisu přihlášek, nebo narazíte na jiný problém, kontaktujte nás prosím buď prostřednictvím e-mailu na <a href="mailto:timechip@timechip.cz">timechip@timechip.cz</a>, nebo telefonicky
na +420 776131313.';
	}
?>
<p><?php echo $str; ?></p>
</div></div></div>