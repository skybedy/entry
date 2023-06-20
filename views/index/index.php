<?php if(Session::get('race_id')): ?><div class="container"><div class="jumbotron jumbotron-custom"><table class="udaje-o-zavodu" style="float:left">
	    <?php
		$str = false;
		foreach($this->Index as $val){
		    //$str .= '<tr><td>Název:</td><td>'.$val['nazev_zavodu'].' '.$val['rok_zavodu'].'</td></tr>';
		    $str .= '<tr><td>Název:</td><td>'.$val['nazev_zavodu'].'</td></tr>';
		    $str .= '<tr><td>Místo:</td><td>'.$val['misto_zavodu'].'</td></tr>';
                    //podmínka pro případ, že závod nemá jedno datum, použito na Skialp Lysá 2017, kdy to sloužilo jako přihláška na dva závody a Skialp Lysá figuroval jen jako virtuální zívod
                    if($val['den_zavodu'] != '0'){
                        //$str .= '<tr><td>Datum:</td><td>'.$val['datum_zavodu'].'</td></tr>';
                    }
                    if($val['id_zavodu'] != "46"){
                        $str .= '<tr><td>Datum:</td><td>'.$val['datum_zavodu'].'</td></tr>';
                    }
                    
		    $str .= '<tr><td>Kontakt:</td><td>'.$val['poradatel'].'</td></tr>';
		    $str .= '<tr><td>E-mail:</td><td><a target="_blank" href="mailto://'.$val['mail'].'">'.$val['mail'].'</a></td></tr>';
		    $str .= ($val['telefon'] == true) ? ('<tr><td>Telefon:</td><td>'.$val['telefon'].'</td></tr>') :('');
		    $str .= ($val['web'] == true) ? ('<tr><td>Web:</td><td><a target="_blank" href="http://'.$val['web'].'">'.$val['web'].'</a></td></tr>') :('');
		}
		echo $str;	
	    ?>
</table><?php if(Session::get('race_id') == 21000): //bolaticka 30 ?><div style="float:right;width:200px;height:150px;border:1px solid #e1e1e1;background:white url(./public/images/bezva_kolo_bolaticka_30.jpg) no-repeat top;border-radius: 6px "></div><?php endif; ?><div style="clear: both"></div></div><div class="panel panel-default"><div class="panel-heading">Kompabilita prohlížečů</div><div class="panel-body"><p>Tento přihlašovací systém je kompatibilní se všemi moderními prohlížeči jako jsou např. Chrome a všechny jeho klony, Firefox, Safari, nebo Opera.<br /> Bez větších potíží by měl systém fungovat i v prohlížečích Internet Explorer verze 9 a vyšší.</p><p><span style="color:red">V případě, že používáte Internet Explorer verze 8, nebo nižší</span>, přihlášky vám s velkou pravděpodobností korektně fungovat nebudou a v tom případě doporučujeme stáhnout si nějaký z níže uvedených prohlížečů. Je to zdarma a na Internetu vám bude určitě lépe.</p><ul>
<li><a target="_blank" href="https://www.google.cz/chrome/browser/desktop">Google Chrome</a></li> <li><a target="_blank" href="http://www.mozilla.cz/stahnout/firefox">Mozilla Firefox</a></li> <li><a target="_blank" href="http://www.opera.com/cs">Opera</a></li></ul><p>Pro bezproblémové fungování přihlašovacího systému je nutný rovněž zapnutý <span style="color:red">JavaScript</span>, který ale s velkou pravděpodobností zapnutý máte.</p></div></div></div><?php endif; ?>