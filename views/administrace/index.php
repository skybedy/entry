<?php
    $category_list = $this->CategoryList;
    
    $tricka = $this->Tricka;
    $platba = Array("zaplaceno" => 'Zaplaceno',"nezaplaceno" => 'Nezaplaceno');
    $tricka = Array();
    $tricka['Bez trička'] = 'bez';
    $tricka['S-pánské'] = 'S-male';
    $tricka['M-pánské'] = 'M-male';
    $tricka['L-pánské'] = 'L-male';
    $tricka['XL-pánské'] = 'XL-male';
    $tricka['XXL-pánské'] = 'XXL-male';
    $tricka['S-dámské'] = 'S-female';
    $tricka['M-dámské'] = 'M-female';
    $tricka['L-dámské'] = 'L-female';
    $tricka['XL-dámské'] = 'XL-female';
    $tricka['104-dětské'] = '104-child';
    $tricka['116-dětské'] = '116-child';
    $tricka['128-dětské'] = '128-child';
    $tricka['140-dětské'] = '140-child';
    $tricka['152-dětské'] = '152-child';
    $tricka['165-dětské'] = '165-child';
    $typ_prihlasky = 1;
    if(Session::get('race_id') == 1 AND YEAR == 2017){
        $typ_prihlasky = 5;
    }
    
?>

<div class="modal" id="EditModalIndividual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Editace údajů</h4>
	    </div>
		<div class="modal-body">
		    <form method="post" action="<?php echo URL.'administrace/zmena-udaju'; ?>">
			<input type="hidden" name="typ_prihlasky" value="<?php echo $typ_prihlasky ?>" />
			<div class="form-group">
			    <input class="form-control" id="id_prihlasky" name="id_prihlasky"  />
			</div>
			<div class="form-group">
			    <input class="form-control" id="prijmeni_1" name="prijmeni_1"  />
			</div>
			<div class="form-group">
			    <input class="form-control" id="jmeno_1" name="jmeno_1"  />
			</div>
			<div class="form-group">
			    <input class="form-control" id="datum_narozeni" name="datum_narozeni"  />
			</div>
			<div class="form-group">
			    <input class="form-control" id="prislusnost" name="prislusnost"  />
			</div>
			<div class="form-group">
			    <input class="form-control" id="telefon_1" name="telefon_1"  />
			</div>
			<div class="form-group">
			    <input class="form-control" id="mail" name="mail"  />
			</div>
			<div class="form-group">
			    <select id="kategorie" name="kategorie" class="form-control">
				<?php
				    $string = '<option></option>'; //pokud se to tu nedá, tak u dvouřádkového selecetu se objevuje jen jeden option
				    foreach($category_list as $key => $value){
					$string .= '<option value="'.$value['id_kategorie'].'|'.$value['poradi_podzavodu'].'">';
					$string .= $value['nazev_kategorie'].' ('.$key.')</option>';
				    }
				    echo $string;
				?>
			    </select>
    			</div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input class="form-control" id="startovne" name="startovne"  />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input class="form-control" id="tricko" name="tricko"  />
                                </div>
                            </div>
                        </div>
			<div class="form-group">
			    <select id="platba" name="platba" class="form-control">
				<?php
				    $string = '<option></option>';
				    foreach($platba as $key => $data1){
					$string .= '<option value="'.$key.'"';
					$string .= ' >'.$data1.'</option>'; 
				    }
				    echo $string;
				?>
			    </select>
    			</div>
                        <div class="form-group"> 
                            <textarea id="poznamka_poradatele" placeholder="Poznámka pořadatele" class="form-control" name="poznamka_poradatele" cols="40" rows="5"></textarea>
                        </div>
			<button type="button" class="btn btn-primary" data-dismiss="modal">Zavřít</button>
			<button type="submit" class="btn btn-danger delete_prihlasku" name="delete">Smazat</button>
			<button type="submit" class="btn btn-success" >Uložit změny</button>
		    </form>
		</div>
	</div>
    </div>
</div>
<div class="modal" id="EditModalTeam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Editace údajů týmu</h4>
	    </div>
		<div class="modal-body">
		    <form method="post" action="<?php echo URL.'administrace/zmena-udaju-tymy'; ?>">
			<input type="hidden" name="typ_prihlasky" value="2" />
			<div class="form-group">
			    <input class="form-control" id="id_prihlasky" name="id_prihlasky"  />
			</div>
			<div class="form-group">
			    <input class="form-control" id="nazev_tymu" name="nazev_tymu"  />
			</div>
                        
                        <div class="form-group">
			    <select id="kategorie" name="kategorie" class="form-control">
				<?php
				    $string = '<option></option>'; //pokud se to tu nedá, tak u dvouřádkového selecetu se objevuje jen jeden option
				    foreach($category_list as $key => $value){
					$string .= '<option value="'.$value['id_kategorie'].'|'.$value['poradi_podzavodu'].'">';
					$string .= $value['nazev_kategorie'].' ('.$key.')</option>';
				    }
				    echo $string;
				?>
			    </select>
    			</div>
			<div class="form-group">
			    <input class="form-control" id="mail" name="mail"  />
			</div>
			<div class="form-group">
			    <input class="form-control" id="startovne" name="startovne"  />
			</div>
			<div class="form-group">
			    <select id="platba" name="platba" class="form-control">
				<?php
				    $string = '<option></option>';
				    foreach($platba as $key => $data1){
					$string .= '<option value="'.$key.'"';
					$string .= ' >'.$data1.'</option>'; 
				    }
				    echo $string;
				?>
			    </select>
    			</div>
			<button type="button" class="btn btn-primary" data-dismiss="modal">Zavřít</button>
			<button type="submit" class="btn btn-danger delete_prihlasku_tymy" name="delete_tym">Smazat</button>
			<button type="submit" class="btn btn-success" >Uložit změny</button>
		    </form>
		</div>
	</div>
    </div>
</div>
<div class="modal" id="EditModalTeamIndividual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Editace údajů člena týmu</h4>
	    </div>
		<div class="modal-body">
		    <form method="post" action="<?php echo URL.'administrace/zmena-udaju-tymu-jednotlivce'; ?>">
			<div class="form-group">
			    <input class="form-control" id="id_prihlasky" name="id_prihlasky"  />
			</div>
			<div class="form-group">
			    <input class="form-control" id="prijmeni_1" name="prijmeni_1"  />
			</div>
			<div class="form-group">
			    <input class="form-control" id="jmeno_1" name="jmeno_1"  />
			</div>
			<div class="form-group">
			    <input class="form-control" id="prislusnost" name="prislusnost"  />
			</div>
			<div class="form-group">
			    <input class="form-control" id="mail" name="mail"  />
			</div>
			<button type="button" class="btn btn-primary" data-dismiss="modal">Zavřít</button>
			<button type="submit" class="btn btn-success" >Uložit změny</button>
		    </form>
		</div>
	</div>
    </div>
</div>

<?php
    $str = '<div class="container-fluid">';
    //$str .= '<h5>Ke každému závodníkoví je možno přidat si vlastní poznámku v editaci jeho údajů</h5><hr>';
  /*  $str .= '<h5 style="color:red">Moji milí pořadatelé, na žádost některých urputných pochtívačů :-) jsem dopsal funkci, která pošle mail přihlášenému v okamžiku, kdy mu ve "Změně údajů" dáte status "Zaplaceno" a dáte "Uložit změny".<br>Funkce to udělá pouze jednou, takže se nemusíte bát, že při případné další změně, třeba jména, to bude posílat mail znovu.<br>'
            . 'Bacha, nefunguje to obráceně, pokud někomu dáte omylem "Zaplaceno" a pak mu vrátíte "Nezaplaceno", žádný mail o omylu závodníkovi nepřijde, to si už musíte pořešit sami<br>'
            . 'V téhle chvíli už jsem dost utahaný, takže dotyčnému přijde prostinký text "<span style="text-decoration:underline">Potvrzujeme zaplacení startovneho ve výši xxx Kč.Děkujeme a těšíme se na vaši účast.</span>", takže mě klidně můžete inspirovat svými nápady o jiném textu.<br>'
            . 'Zatím to funguje jen u jednotlivců, týmy zas někdy příště, i tak jsem tomu věnoval půlden života.<br>'
            . 'Pokud by jste narazili na nějaký problém, budu vám vděčný za jakékoliv info, génius byl Einstein, nikoli já.<br> 31.1.19,  mk. </h5>'; */
    
  
	//$str .= '<p>V současné době nefunguje export do Excelu, což je způsobeno ukončenou podporou knihovny pro to sloužící. Nejspíš další týden musím najít a zprovoznit jinou.</p>';
	
	if($this->VypisPrihlasek['jednotlivci']){
	$pocet_prihlasek = count($this->VypisPrihlasek['jednotlivci']);
	$str .=  '<table class="table table-bordered table-striped table-hover zmena_udaju">';
	$str .=  '<thead><th class="text-center">VS</th><th>Příjmení</th><th>Jméno</th><th>Tým/Bydliště</th><th>E-mail</th><th class="text-center">Telefon1</th><th>Kategorie</th><th class="text-center">Narození</th><th class="text-center">Tričko</th><th class="text-center">Startovné</th><th class="text-center">Platba</th><th class="text-center">Vzkazy<br>Poznámky</th><th class="text-center">Přihlášeno</th><th class="text-center" colspan="2">Změna údajů</th></thead>';
	$i = 1;	
	foreach($this->VypisPrihlasek['jednotlivci'] as $data){
	    $str .= '<tr id="'.$data->id_prihlasky.'">';
	    $str .= '<td class="text-center">'.$data->vs.'</td>';
	    $str .= '<td class="prijmeni_1">'.$data->prijmeni_1.'</td>';
	    $str .= '<td class="jmeno_1">'.$data->jmeno_1.'</td>';
	    $str .= '<td class="prislusnost">'.$data->prislusnost.'</td>';
	    $str .= '<td class="mail">'.$data->mail.'</td>';
	    $str .= '<td class="text-center telefon_1">'.$data->telefon_1.'</td>';
	   // $str .= '<td class="kategorie">'.$data->nazev.','.$data->kategorie;
	    $str .= '<td class="kategorie">';
            
            
            foreach($category_list as $key => $value){
		if($data->id_kategorie == $value['id_kategorie']){
		    $str .= $value['nazev_kategorie'].' ('.$key.')';
		}
	    }
	   
            $str .= '</td>';
	    $str .= '<td class="text-center datum_narozeni">'.$data->datum_narozeni.'</td>';
	    $str .= '<td class="text-center tricko">'.$data->tricko.'</td>';
	    $str .= '<td class="text-center startovne">'.$data->startovne.'</td>';
	    $str .= '<td class="text-center platba">'.$data->zaplaceno.'</td>';
	    $str .= '<td class="text-center vzkazy_poznamky">';
	    if($data->vzkaz){
		//$str .= 'Excel';
                //$str .= '<span style="cursor:pointer" class="label label-success label_vzkaz">Vzkaz</span>';
                $str .= '<span style="cursor:pointer" class="label label-success label_vzkaz" data-trigger="hover" type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left" data-content="'.$data->vzkaz.'">Vzkaz</span> ';
	    }
            if($data->poznamka_poradatele){
                $str .= '<span style="cursor:pointer" class="label label-danger label_poznamka_poradatele" data-trigger="hover" type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left" data-content="'.$data->poznamka_poradatele.'">Poznámka</span>';
            }
	    $str .= '</td>';
	    $str .= '<td class="text-center">'.$data->datum_prihlaseni.'</td>';
	    $str .= '<td class="text-center"><button type="button" class="btn btn-primary btn-xs edit_individual" data-toggle="modal">Editovat</button></td>';
	    $str .= '</tr>';
	    $i++;
	}
	$str .= '</table>';
	$str .= '<hr />';
    }

    if($this->VypisPrihlasek['tymy']){
	$str .=  '<table class="table table-bordered table-hover zmena_udaju">';
	$str .= '<thead><th class="text-center">VS</th><th>Název týmu</th><th>Kategorie</th><th>E-mail</th><th class="text-center">Startovné</th><th class="text-center">Platba</th><th class="text-center">Vzkaz/Dotaz</th><th class="text-center">Edit</th><th>Příjmení</th><th>Jméno</th><th class="text-center">Narození</th><th>Tým/Bydliště</th><th class="text-center">Tri</th><th>E-mail</th><th class="text-center">Telefon</th><th class="text-center">Edit</th></thead>';
	$pocet_prihlasek = count($this->VypisPrihlasek['tymy']);
	$str .= '<h4>Týmy, celkový počet '.$pocet_prihlasek.'</h4>';
	$k = 1;
	foreach ($this->VypisPrihlasek['tymy'] as $key => $value){
	    $pocet_clenu = count($value[0]);
	    $str .= '<tr id="'.$value['id_prihlasky'].'">';
	    $str .= '<td rowspan="'.$pocet_clenu.'" class="text-center rowspan">'.$value['vs'].'</td>';
	    $str .= '<td rowspan="'.$pocet_clenu.'" class="rowspan nazev_tymu">'.$value['nazev_tymu'].'</td>';
	    
	    $str .= '<td rowspan="'.$pocet_clenu.'" class="rowspan kategorie">';
	    
	    foreach($category_list as $key => $value1){
		if($value['id_kategorie'] == $value1['id_kategorie']){
		    $str .= $value1['nazev_kategorie'].' ('.$key.')';
		}
	    }
	    $str .= '</td>';

	    $str .= '<td rowspan="'.$pocet_clenu.'" class="rowspan mail">'.$value['mail'].'</td>';
	    $str .= '<td rowspan="'.$pocet_clenu.'" class="text-center rowspan startovne">'.$value['startovne'].'</td>';
	    $str .= '<td rowspan="'.$pocet_clenu.'" class="text-center rowspan platba">'.$value['zaplaceno'].'</td>';
	    
	    $str .= '<td rowspan="'.$pocet_clenu.'" class="rowspan text-center">';
	    if($value['vzkaz']){
		$str .= 'Excel';
	    }
	    $str .= '</td>';
	    
	    
	    $str .= '<td rowspan="'.$pocet_clenu.'" class="text-center rowspan"><button type="button" class="btn btn-primary btn-xs edit_team" data-toggle="modal">Editovat</button></td>';
	    $i = 1;
	    foreach($value[0] as $key => $value1){
		if($i == 1){
		    $str .= '<td class="prijmeni_1">'.$value1['prijmeni_1'].'</td>';
		    $str .= '<td class="jmeno_1">'.$value1['jmeno_1'].'</td>';
		    $str .= '<td class="text-center">'.$value1['datum_narozeni'].'</td>';
		    $str .= '<td class="prislusnost">'.$value1['prislusnost'].'</td>';
                    $str .= '<td class="text-center">'.$value1['tricko'].'</td>';
                    $str .= '<td class="mail_jednotlivec">'.$value1['mail'].'</td>';
		    $str .= '<td class="text-center">'.$value1['telefon_1'].'</td>';
		    $str .= '<td id="'.$value1['id_prihlasky'].'" class="text-center"><button type="button" class="btn btn-primary btn-xs edit_team_individual" data-toggle="modal">Editovat</button></td>';
		}
		else{
		    $str .= '<tr>';
		    $str .= '<td class="prijmeni_1">'.$value1['prijmeni_1'].'</td>';
		    $str .= '<td class="jmeno_1">'.$value1['jmeno_1'].'</td>';
		    $str .= '<td class="text-center">'.$value1['datum_narozeni'].'</td>';
		    $str .= '<td class="prislusnost">'.$value1['prislusnost'].'</td>';
                    $str .= '<td class="text-center">'.$value1['tricko'].'</td>';
		    $str .= '<td class="mail_jednotlivec">'.$value1['mail'].'</td>';
		    $str .= '<td class="text-center">'.$value1['telefon_1'].'</td>';
		    $str .= '<td id="'.$value1['id_prihlasky'].'" class="text-center"><button type="button" class="btn btn-primary btn-xs edit_team_individual" data-toggle="modal">Editovat</button></td>';
		    $str .= '</tr>';
		}

	       $i++;
	    }
	    $str .= '</tr>';  
	    $k++;
	}
	$str .= '</table>';
    }
    $str .= '<div>';
    echo $str;
    
?>

