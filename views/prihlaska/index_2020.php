

<?php 
    if(Session::get('race_id') == true ){
	$race_id = Session::get('race_id');
    }
    else{
	 header('Location: '.URL.'prihlaska/vybrat-zavod');
    }
    (Session::get('udaje') == true) ? ($udaje = unserialize(Session::get('udaje'))) : ($udaje = false);
    
    if(isset($this->xhrFinish)){
	echo $this->xhrFinish; 
    }
 ?> 

<script id="hlaska_po_prihlaseni" type="text/x-handlebars-template">
    <div class="panel panel-default hlaska"><div class="panel-body">
	{{{hlaska}}}
   </div></div>
</script>   



<script id="enduro_form" type="text/x-handlebars-template">
    <h5><strong>Přihlašovací formulář</strong></h5>
    <h6 class="text-right"><i>Položky označené hvězdičkou jsou povinné</i></h6>

    <form id="prihlasovaci_formular_enduro">
	<input type="hidden" name="ido" value="{{racer_details.ido}}" />   
	<input type="hidden" name="poradi_podzavodu" value="{{poradi_podzavodu}}" />   
	<h6>Třída a kategorie</h6>

	<div class="form-group">
	    <!-- Chtělo to atribut name, jinak jquery validate řval  -->
	    <label>Třída *</label>
	    <select class="form-control required placeholder" id="poradi_podzavodu" name="id_zavodu">	
		<option value="" selected disabled>Třída *</option>
		{{#each category_list}}
		    <option value="{{poradi_podzavodu}}" {{selected poradi_podzavodu ../poradi_podzavodu}}>{{nazev_podzavodu}}</option>
		{{/each}}
	    </select>
	</div>

	<div class="form-group">
	    <label>Kategorie *</label>
	    <select class="form-control required placeholder" name="id_kategorie">
		<option value="" selected disabled>Výběr kategorie</option>
		{{{Category category_list poradi_podzavodu racer_details.id_kategorie}}}
	    </select>
	</div>
	<div class="form-group">
	<label>Závodní dny *</label><br>
	    <label class="checkbox-inline"><input type="checkbox" name="etapa" value="1" {{Checked racer_details.etapa "1"}}>Sobota</label>
	    <label class="checkbox-inline"><input type="checkbox" name="etapa" value="2" {{Checked racer_details.etapa "2"}}>Neděle</label>
	</div><br>
	
	<h6>Osobní údaje</h6>

	<div class="form-group"> 
	    <label>Startovní číslo *</label>
	    <input type="text" name="race_number" class="form-control required" placeholder="Start. číslo *" value="{{racer_details.race_number}}" {{Readonly racer_details.race_number}} />
	</div>
	<div class="form-group"> 
	    <label>Jméno *</label>
	    <input type="text" name="jmeno" class="form-control required" placeholder="Jméno *"  value="{{racer_details.jmeno}}" {{Readonly racer_details.jmeno}}/>
	</div>
	<div class="form-group"> 
	    <label>Příjmení *</label>
	    <input  type="text" name="prijmeni" class="form-control required" placeholder="Příjmení *" value="{{racer_details.prijmeni}}" {{Readonly racer_details.prijmeni}} />
	</div>
	<div class="form-group"> 
	    <label>Pohlaví *</label>
	    <select name="pohlavi" class="form-control required placeholder" {{Readonly racer_details.pohlavi}}>
		<option value="" selected disabled>Pohlaví</option>
		<option value="M" {{SelectedString "M" racer_details.pohlavi}}>Muž</option>
		<option value="Z" {{SelectedString "Z" racer_details.pohlavi}}>Žena</option>
	    </select>
	</div>
	
	
	<div class="form-group"> 
	    <label>Den narození *</label>
	    <select name="den_narozeni" class="form-control required placeholder" {{Readonly racer_details.den_narozeni}}>
		<option value="" selected disabled>Den narození *</option>
		    {{#each kalendar.days_of_month}}
			<option value="{{this}}" {{selected this ../racer_details.den_narozeni}}>{{this}}</option>
		    {{/each}}

	    </select>
	</div>
	<div class="form-group"> 
	    <label>Měsíc narození *</label>
	    <select name="mesic_narozeni" class="form-control required placeholder" {{Readonly racer_details.mesic_narozeni}}>
		<option value="" selected disabled>Měsíc narození *</option>
		    {{#each kalendar.months_of_year}}
			<option value="{{this}}" {{selected this ../racer_details.mesic_narozeni}}>{{this}}</option>
		    {{/each}}

	    </select>
	</div>
	<div class="form-group"> 
	    <label>Rok narození *</label>
	    <select name="rocnik" class="form-control required placeholder" {{Readonly racer_details.rocnik}}>
		<option value="" selected disabled>Rok narození *</option>
		{{{years racer_details.rocnik}}}
	    </select>
	</div>

	<!-- ADRESA -->
	<div class="form-group"> 
	    <label>Ulice + č.p *</label>
	    <input type="text" name="ulice" class="form-control required" placeholder="Ulice + č.p. *" value="{{racer_details.ulice}}" {{Readonly racer_details.ulice}} />
	</div>
	<div class="form-group"> 
	    <label>Město/obec *</label>
	    <input type="text" name="obec" class="form-control required" placeholder="Město nebo obec *" value="{{racer_details.obec}}" {{Readonly racer_details.obec}} />
	</div>
	<div class="form-group"> 
	    <label>PSČ *</label>
	    <input type="text" name="zip" class="form-control required" placeholder="PSČ *" value="{{racer_details.zip}}" {{Readonly racer_details.zip}} />
	</div>
	<div class="form-group"> 
	    <label>Stát *</label>
	    <select name="stat" class="form-control required placeholder" {{Readonly racer_details.stat}}>
		<option value="" selected disabled>Stát *</option>
		    {{#each enduro_server_data.staty}}
			<option value="{{@key}}" {{SelectedString @key ../racer_details.stat}}>{{this}}</option>
		    {{/each}}
	    </select>
	</div>


	<div class="form-group"> 
	    <label>E-mail *</label>
	    <input type="mail" name="mail" class="form-control required email" placeholder="E-mail *" value="{{racer_details.mail}}" {{Readonly racer_details.mail}} />
	</div>
	<div class="form-group"> 
	    <label>Telefon *</label>
	    <input type="text" name="telefon" class="form-control required" placeholder="Telefon *" value="{{racer_details.telefon}}" {{Readonly racer_details.telefon}} />
	</div>
	<div class="form-group"> 
	    <label>Zdravotní pojišťovna *</label>
	    <select name="zdravotni_pojistovna" class="form-control required placeholder" {{Readonly racer_details.zdravotni_pojistovna}}>
		<option value="" selected disabled>Zdravotní pojišťovna *</option>
		    {{#each enduro_server_data.zdravotni_pojistovny}}
			<option value="{{kod_pojistovny}}" {{selected kod_pojistovny ../racer_details.zdravotni_pojistovna}}>{{nazev_pojistovny}}</option>
		    {{/each}}
	    </select>
	</div>


	<div class="form-group"> <!-- tymy -->
	    <label>Název týmu *</label>
	    <select name="id_tymu" class="form-control required placeholder">
		<option value="" selected disabled>Název teamu *</option>
		    {{#each enduro_server_data.tymy}}
			<option value="{{id_tymu}}" {{selected id_tymu ../racer_details.id_tymu}}>{{nazev_tymu}}</option>
		    {{/each}}
		</select>
	</div>
	<div class="form-group"> 
	    <label>Typ licenece</label>
	    <select name="id_typu_licence" class="form-control required placeholder">
		<option value="" selected disabled>Typ licence *</option>
		    {{#each enduro_server_data.typy_licence}}
			<option value="{{id_typu_licence}}" {{selected id_typu_licence ../racer_details.id_typu_licence}}>{{nazev_licence}}</option>
		    {{/each}}

	    </select>
	</div>
	<div class="form-group"> 
	    <label>Číslo licence</label>
	    <input type="text" name="cislo_licence" class="form-control" placeholder="Číslo licence" value="{{racer_details.cislo_licence}}" />
	</div><br>

	<!-- Motocykl -->	
	<h6>Motocykl a přilba</h6>
	<div class="form-group"> 
	    <label>2T/4T/Elektro *</label>
	    <select name="id_2t4t" class="form-control required placeholder">
		<option value="" selected disabled>2T/4T/Elektro *</option>
		{{#each enduro_server_data.seznam_2t4t}}
		    <option value="{{id_2t4t}}" {{selected id_2t4t ../racer_details.id_2t4t}}>{{nazev_2t4t}}</option>
		{{/each}}
	    </select>
	</div>

	<div class="form-group"> 
	    <label>Značka motocyklu *</label>
	    <select name="id_motocyklu" class="form-control required placeholder">
		<option value="" selected disabled>Značka motocyklu *</option>
		{{#each enduro_server_data.znacky_motocyklu}}
		    <option value="{{id_motocyklu}}" {{selected id_motocyklu ../racer_details.id_motocyklu}}>{{nazev_motocyklu}}</option>
		{{/each}}
	    </select>
	</div>
	<div class="form-group"> 
	    <label>Typ motocyklu *</label>
	    <input type="text" name="typ_motocyklu" class="form-control  required" placeholder="Typ motocyklu" value="{{racer_details.typ_motocyklu}}" />
	</div>
	<div class="form-group"> 
	    <label>Číslo rámu (posledních 6 číslic)</label>
	    <input type="text" name="cislo_ramu" class="form-control" placeholder="Číslo rámu (posledních 6 číslic)" value="{{racer_details.cislo_ramu}}" />
	</div>

	
	<!-- Motocykl a přilba -->			
	<div class="form-group"> 
	    <label>Objem motoru *</label>
	    <select name="objem_motoru" class="form-control required placeholder">
		<option value="" selected disabled>Objem motoru *</option>
		{{#each enduro_server_data.objemy_motoru}}
		    <option value="{{objem_motoru}}" {{selected objem_motoru ../racer_details.objem_motoru}}>{{objem_motoru}}</option>
		{{/each}}
	    </select>
	</div>
	<div class="form-group"> 
	    <label>Počet válců *</label>
	    <select name="pocet_valcu" class="form-control required placeholder">
		<option value="" selected disabled>Počet válců *</option>
		{{#each enduro_server_data.pocty_valcu}}
		    <option value="{{pocet_valcu}}" {{selected pocet_valcu ../racer_details.pocet_valcu}}>{{pocet_valcu}}</option>
		{{/each}}
	    </select>
	</div>
	<div class="form-group"> 
	    <label>Znaka přilby</label>
	    <input type="text" name="znacka_prilby" class="form-control" placeholder="Značka přilby" value="{{racer_details.znacka_prilby}}" />
	</div>
	<div class="form-group"> 
	    <label>Homologace přilby</label>
	    <input type="text" name="homologace_prilby" class="form-control" placeholder="Homologace přilby" value="{{racer_details.homologace_prilby}}" />
	</div>
	<div class="form-group"> 
	    <button type="submit" class="form-control btn btn-primary">Zkontrolovat údaje</button>
	</div>
    </form>
</script>


<script id="enduro_control_table" type="text/x-handlebars-template">
    <img id="spinner" src="./public/images/ajax-loader-big.gif" />
    <h5><strong>Kontrola údajů</strong></h5>
    <table class="table table-hover" style="background:white">
	<tr>
	    <td>Třída</td>
	    <td>{{NazevPodzavodu racer_details.poradi_podzavodu}}</td>
	</tr>
	<tr>
	    <td>Kategorie</td>
	    <td>{{NazevKategorie racer_details.poradi_podzavodu racer_details.id_kategorie}}</td>
	</tr>
	<tr>
	    <td>Startovní číslo</td>
	    <td>{{racer_details.race_number}}</td>
	</tr>
	<tr>
	    <td>Jméno a příjmení</td>
	    <td>{{racer_details.jmeno}} {{racer_details.prijmeni}}</td>
	</tr>
	<tr>
	    <td>Pohlavi</td>
	    <td>{{NazevPohlavi racer_details.pohlavi}}</td>
	</tr>
	<tr>
	    <td>Datum narození</td>
	    <td>{{racer_details.den_narozeni}}.{{racer_details.mesic_narozeni}}.{{racer_details.rocnik}}</td>
	</tr>	
	<tr>
	    <td>Ulice</td>
	    <td>{{racer_details.ulice}}</td>
	</tr>	
	<tr>
	    <td>Místo bydliště</td>
	    <td>{{racer_details.obec}}</td>
	</tr>	
	<tr>
	<td>PSČ</td>
	    <td>{{racer_details.zip}}</td>
	</tr>	
	<td>Stát</td>
	    <td>{{racer_details.stat}}</td>
	</tr>	
	<td>E-mail</td>
	    <td>{{racer_details.mail}}</td>
	</tr>	
	<td>Telefon</td>
	    <td>{{racer_details.telefon}}</td>
	</tr>	
	<td>Zdravotní pojišťovna</td>
	    <td>{{NazevPojistovny racer_details.zdravotni_pojistovna}}</td>
	</tr>	
	<td>Team</td>
	    <td>{{NazevTymu racer_details.id_tymu}}</td>
	</tr>	
	<tr>
	    <td>Typ licence</td>
	    <td>{{NazevLicence racer_details.id_typu_licence}}</td>
	</tr>
	{{{NepovinnaPolozka 'Číslo licence' racer_details.cislo_licence}}}
	<tr>
	    <td>2T/4T</td>
	    <td>{{Nazev2t4t racer_details.id_2t4t}}</td>
	</tr>
	<tr>
	    <td>Značka motocyklu</td>
	    <td>{{NazevMotocyklu racer_details.id_motocyklu}}</td>
	</tr>
	{{{NepovinnaPolozka 'Typ motocyklu' racer_details.typ_motocyklu}}}
	{{{NepovinnaPolozka 'Číslo rámu' racer_details.cislo_ramu}}}
	<tr>
	    <td>Objem motoru</td>
	    <td>{{racer_details.objem_motoru}}</td>
	</tr>
	<tr>
	    <td>Počet válců</td>
	    <td>{{racer_details.pocet_valcu}}</td>
	</tr>
	{{{NepovinnaPolozka 'Značka přilby' racer_details.znacka_prilby}}}
	{{{NepovinnaPolozka 'Homologace přilby' racer_details.homologace_prilby}}}


    </table>

    <div class="form-group">
	<button id="opravit_udaje" type="button" class="form-control btn btn-danger">Opravit údaje - zvolte v případě, že údaje potřebuje opravit</button>
    </div>
    <div class="form-group"> 
	<button id="odeslat_prihlasku" type="button" class="form-control btn btn-success">Odeslat přihlášku - zvolte pouze v případě, že údaje jsou OK a můžete je odeslat</button>
    </div>
</script>

<div class="container">
    <div class="row">
	<div class="clearfix">
	    <div class="col-lg-12">
		<div class="panel panel-default contact">
		    <div class="panel-body padding-bottom-none">
			<!-- musí se vždy ve formuláři nastavit ručně id etapy -->
   



			<?php if($race_id == 46) : ?> 
			     <div id="prihlasovaci_formular_enduro_wrapper">
                                 <?php if($race_id == 46){ ?>
                                     <p>Registrace prostřednictvím Internetu již byla ukončena. Na závody nicméně bude možné přihlásit se i v den závodu přímo na místě.</p>     
                                 <?php }
                                        else{
                                 ?>
                              
					<form id="overeni_udaju_enduro">
				    <div class="form-group">
					 <input type="text" name="race_number" class="form-control" placeholder="Zadejte své startovní číslo" />
				    </div>
				    <div class="form-group">
					 <input type="mail" name="mail" class="form-control" placeholder="Zadejte váš E-mail" />
				    </div>
				    <div class="form-group"> 
					<button type="submit" id="overeni_udaju_enduro_button" class="form-control btn btn-primary">Odeslat</button>
				    </div>
				</form>
                                     <p>V případě, že se vám nedaří přihlásit, napište na <a href="mailto:info@timechip.cz">info@timechip.cz</a>, nebo zavolejte na 776131313</a><p>
                        <?php } ?>
                            
                            </div>  
			
                         <?php else: //vše ostatní ?>
			    <h5><strong>Přihlašovací formulář</strong></h5>
			    <!-- formulář pro vše krom endura -->
			    <form action="<?php echo URL;?>prihlaska/xhrOvereni" id="prihlasovaci_formular"  method="post">
			    <?php
				switch($race_id){
                                    case 106000: 
                                        require 'forms/dvojice_plus_kapitan.php';
				    break;
                                    case 2:  //winter hei run
					echo '<p>Na tento závod je možné přihlásit se pouze <a style="text-decoration: underline" href="https://www.aktivitytour.cz/registrace-winter-hei-run">ZDE.</a></p>';
				    break;
                                    case 4:  //winter hei run
					echo '<p>Na tento závod je možné přihlásit se pouze <a style="text-decoration: underline" href="http://www.perunmaraton.cz/cz/registrace">ZDE.</a></p>';
				    break;
                                    case 5:  //mtb bike jam
					echo '<p>Na tento závod je možné přihlásit se pouze <a style="text-decoration: underline" href="http://nachodska24hoursmtb.cz/registration.html">ZDE.</a></p>';
				    break;
                                    case 6:  //belsky okruh
                                            require 'forms/belsky_okruh.php';
				    break;
					case 9: 
						require 'forms/beskydsky_biatlon_dvojice.php';
					break;
					case 10: //alis run
						//require 'forms/alis_run.php';
                                            require 'forms/konec_prihlasek.php';
				    break;
                                    case 14: //hobby sikl
                                            require 'forms/cc_hobby.php';
                                    break;
                                    case 11: //Aktivity duatlon
                                            echo '<p>Na tento závod je možné přihlásit se pouze <a style="text-decoration: underline" href="https://www.aktivitytour.cz/portfolio/heipark-duatlon">ZDE.</a></p>';
                                    break;
                                    case 12: //NJ pulmaraton
                                            echo '<p>Na tento závod je možné přihlásit se pouze <a style="text-decoration: underline" href="http://www.welzluvkvadriatlon.cz/registrace">ZDE.</a></p>';
                                    break;
                                    case 15: //Zátoopek
                                            echo '<p>Na tento závod je možné přihlásit se pouze <a style="text-decoration: underline" href="http://beh-roznov.koprivnice.org">ZDE.</a></p>';
                                    break;
                                    case 18: // Sokolov
                                            echo '<p>Na tento závod je možné přihlásit se pouze <a style="text-decoration: underline" href="https://www.sokolovska24mtb.cz/registrace/">ZDE.</a></p>';
                                    break;
                                    
                                    case 20: //hobby trnavka
                                            require 'forms/konec_prihlasek.php';
                                    break;
                                    case 21: //zubri
                                            echo '<p>Na tento závod je možné přihlásit se pouze <a style="text-decoration: underline" href="http://sport.mesto-zubri.cz/aktualne/biatlonovy-zavod-svobody-a474">ZDE.</a></p>';
                                    break;
                                    case 22: //hlucinsky_pulmaraton
						require 'forms/hlucinsky_pulmaraton.php';
                                    break;
                                    case 23: //3xtop
						require 'forms/3xtop.php';
                                    break;
                                    case 31: //zubri
                                            echo '<p>Na tento závod je možné přihlásit se pouze <a style="text-decoration: underline" href="http://www.prilepskyzblunk.cz">ZDE.</a></p>';
                                    break;
                                    case 32: //tauris
                                            echo '<p>Na tento závod je možné přihlásit se pouze <a style="text-decoration: underline" href="https://www.blaticko.sk/prihlasovanie-zlom-vaz">ZDE.</a></p>';
                                    break;
                                    case 34: //rača
                                            require 'forms/konec_prihlasek.php';
                                    break;
                                    case 38: //osecanska_slapka
                                        require 'forms/osecanska_slapka.php';
                                    break;
                                    case 40: //cc hobby sikl 2
                                            require 'forms/konec_prihlasek.php';
                                    break;
                                    case 47: //cc hobby liberec
                                        require 'forms/konec_prihlasek.php';
                                    break;
                                    case 48: //cc hobby liberec
                                        require 'forms/konec_prihlasek.php';
                                    break;
                                    case 41: //rača
                                            echo '<p>Na tento závod je možné přihlásit se pouze <a style="text-decoration: underline" href="http://www.zapomenutehory.cz/registrace">ZDE.</a></p>';
                                    break;
                                
                                
                                


                                    
                         case 68: //aktivity race
					if(Session::get('poradi_podzavodu')){
					    $poradi_podzavodu = Session::get('poradi_podzavodu');
					}
					else{
					    $poradi_podzavodu = false;
					}
				    ?>
					<div class="form-group">
					    <select class="form-control" id="vyber_zavodu"z onchange="window.location = 'prihlaska/poradi-podzavodu/'+this.options[this.selectedIndex].value+'';" name="vyber_zavodu">	  
						<option value="">Vyberte, který se závodů chcete absolvovat</option>
						<option value="1" <?php echo ((isset($poradi_podzavodu) && $poradi_podzavodu == 1) ? ('selected="selected"') : ('')) ?>>Jednotlivci</option>
						<option value="2" <?php echo ((isset($poradi_podzavodu) && $poradi_podzavodu == 2) ? ('selected="selected"') : ('')) ?>>Týmy</option>
						<option value="3" <?php echo ((isset($poradi_podzavodu) && $poradi_podzavodu == 3) ? ('selected="selected"') : ('')) ?>>MINI AKTIVITY RACE</option>
					    </select>
					</div>
				    <?php
                                    
                                   if($poradi_podzavodu == 1){
					    require 'forms/winter_hei_run_jednotlivci.php';
					}					
					elseif ($poradi_podzavodu == 2) {
					    require 'forms/winter_hei_run_tymy.php';
					}
                                        else{
                                            require 'forms/default.php';
                                        }
				    break; 				    
                                
                                
                                
                                    
                                    case 1;
					if(Session::get('pocet_clenu')){
					    $pocet_clenu = Session::get('pocet_clenu');
					}
					else{
					    $pocet_clenu = false;
					}
				?>
					<h4><strong>Počet členů týmu</strong></h4>
					<div class="form-group">
					    <select class="form-control" id="vyber_zavodu" onchange="window.location = 'prihlaska/pocet-clenu/'+this.options[this.selectedIndex].value+'';" name="vyber_zavodu">	  
						<option value="">Zadejte počet členů týmu</option>
                                                <?php
                                                    $str = "";
                                                    $max_pocet_clenu = 5;
                                                    for($i = 1;$i <= $max_pocet_clenu;$i++){
                                                        $selected = "";
                                                        if($i == $pocet_clenu) $selected = ' selected="selected" ';
                                                        $str .= '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
                                                    }
                                                    echo $str;
                                                ?>
                                                
					    </select>
					</div>

				<?php
                                    if($pocet_clenu){
                                        require 'forms/ctyrkolky_sikl.php';
                                    }
                                    break; //konec 
                                    
                                    case 27: //bbl
					if(Session::get('poradi_podzavodu')){
					    $poradi_podzavodu = Session::get('poradi_podzavodu');
					}
					else{
					    $poradi_podzavodu = false;
					}
				    ?>
					<div class="form-group">
					    <select class="form-control" id="vyber_zavodu" onchange="window.location = 'prihlaska/poradi-podzavodu/'+this.options[this.selectedIndex].value+'';" name="vyber_zavodu">	  
						<option value="">Vyberte, který se závodů chcete absolvovat</option>
						<option value="1" <?php echo ((isset($poradi_podzavodu) && $poradi_podzavodu == 1) ? ('selected="selected"') : ('')) ?>>Závod jednotlivců</option>
						<option value="8" <?php echo ((isset($poradi_podzavodu) && $poradi_podzavodu == 8) ? ('selected="selected"') : ('')) ?>>Závod dvojic</option>
					    </select>
					</div>
				    <?php
					if($poradi_podzavodu == 1){
                                            require 'forms/bbl.php';
                                            //require 'forms/konec_prihlasek.php';
					}
					else{
					    require 'forms/bbl_dvojice.php';
                                            //require 'forms/konec_prihlasek.php';
					}
				    break; //konec bbl

                                    
                                    
                                    
                                    default:
					require 'forms/default.php';
				    }
				?>
			    </form>
			
			<?php endif; // konec formů ?> 
		    </div>
		</div>
	    </div>
	</div>
    </div>
</div>
<!-- tady jsou tyhle scripty záměrně.. pokud byly v hlavičce jako ostatní, Handlebars řvaly na stránkách, na kterých nebyly šablony --> 
<script type="text/javascript" src="<?php echo URL ?>views/prihlaska/js/handlebars.js"></script>
<script type="text/javascript" src="<?php echo URL ?>views/prihlaska/js/enduro.js"></script>  