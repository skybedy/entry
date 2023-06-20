$(function(){
	$('.delete_prihlasku').click(function(){
	    if(confirm('Pozor, tato akce se nedá vrátit !!!') == true){
		if(confirm('Končí sranda, opravdu jsi si jist ???') == true){
		    return true;
		}	    
		return false;
	    }
	    return false;
	});
	
	$('.delete_prihlasku_tymy').click(function(){
	    if(confirm('Pozor, tato akce se nedá vrátit !!!') == true){
		if(confirm('Končí sranda, opravdu jsi si jist ???') == true){
		    return true;
		}	    
		return false;
	    }
	    return false;
	});
	
	$('button.edit_individual').on('click', function() {
	    var myModalIndividual = $('#EditModalIndividual');
	    var id_prihlasky = $(this).closest('tr').attr('id');
	    var prijmeni_1 = $(this).closest('tr').find('td.prijmeni_1').text();
	    var jmeno_1 = $(this).closest('tr').find('td.jmeno_1').text();
	    var prislusnost = $(this).closest('tr').find('td.prislusnost').text();
	    var mail = $(this).closest('tr').find('td.mail').text();
	    var kategorie = $(this).closest('tr').find('td.kategorie').text();
	    var startovne = $(this).closest('tr').find('td.startovne').text();
	    var tricko = $(this).closest('tr').find('td.tricko').text();
	    var platba = $(this).closest('tr').find('td.platba').text();
	    var telefon_1 = $(this).closest('tr').find('td.telefon_1').text();
	    var telefon_2 = $(this).closest('tr').find('td.telefon_2').text();
		var datum_narozeni = $(this).closest('tr').find('td.datum_narozeni').text();
            var poznamka_poradatele = $(this).closest('tr').find('td.vzkazy_poznamky .label_poznamka_poradatele').attr("data-content");
	    $('#id_prihlasky', myModalIndividual).val(id_prihlasky);
	    $('#prijmeni_1', myModalIndividual).val(prijmeni_1);
	    $('#jmeno_1', myModalIndividual).val(jmeno_1);
	    $('#prislusnost', myModalIndividual).val(prislusnost);
	    $('#telefon_1', myModalIndividual).val(telefon_1);
	    $('#telefon_2', myModalIndividual).val(telefon_2);
	    $('#mail', myModalIndividual).val(mail);
	    $('#kategorie option:contains('+kategorie+')').prop('selected',true); //vybere položku v selectu ne podle value, ale podle textu
	    $('#startovne', myModalIndividual).val(startovne);
	    $('#tricko', myModalIndividual).val(tricko);
		$('#datum_narozeni', myModalIndividual).val(datum_narozeni);
		var datum_narozeni = $(this).closest('tr').find('td.datum_narozeni').text();
	    $('#platba option[value="'+platba+'"]').prop('selected',true);
            //pokud se to nejprv nevyprazdnilo, tak tam zustala viset poznamka od jineho zavodnika
            $('#poznamka_poradatele', myModalIndividual).text("");
            $('#poznamka_poradatele', myModalIndividual).text(poznamka_poradatele);

	    myModalIndividual.modal({ show: true });
	    return false;
	});
        
        $('.label_vzkaz').on('mouseover', function(ev) {
            console.log(ev);
        });
        
        $('.label_vzkaz').on('mouseout', function(ev) {
            console.log(ev);
        });
        
	
	$('button.edit_team').on('click', function() {
	    var myModalTeam = $('#EditModalTeam');
	    var id_prihlasky = $(this).closest('tr').attr('id');
	    var nazev_tymu = $(this).closest('tr').find('td.nazev_tymu').text();
	    var mail = $(this).closest('tr').find('td.mail').text();
	    var startovne = $(this).closest('tr').find('td.startovne').text();
	    var platba = $(this).closest('tr').find('td.platba').text();
	    $('#id_prihlasky', myModalTeam).val(id_prihlasky);
	    $('#nazev_tymu', myModalTeam).val(nazev_tymu);
	    $('#mail', myModalTeam).val(mail);
	    $('#startovne', myModalTeam).val(startovne);
	    $('#platba option[value="'+platba+'"]').prop('selected',true);
	    myModalTeam.modal({ show: true });
	    return false;
	});
	
	$('button.edit_team_individual').on('click', function() {
	    var myModalTeamIndividual = $('#EditModalTeamIndividual');
	    var id_prihlasky = $(this).parent().attr('id');
	    var prijmeni_1 = $(this).closest('tr').find('td.prijmeni_1').text();
	    var jmeno_1 = $(this).closest('tr').find('td.jmeno_1').text();
	    var prislusnost = $(this).closest('tr').find('td.prislusnost').text();
	    var mail = $(this).closest('tr').find('td.mail_jednotlivec').text();
	    $('#id_prihlasky', myModalTeamIndividual).val(id_prihlasky);
	    $('#prijmeni_1', myModalTeamIndividual).val(prijmeni_1);
	    $('#jmeno_1', myModalTeamIndividual).val(jmeno_1);
	    $('#prislusnost', myModalTeamIndividual).val(prislusnost);
	    $('#mail', myModalTeamIndividual).val(mail);
	    myModalTeamIndividual.modal({ show: true });
	    return false;
	});
        
        
        $('[data-toggle="popover"]').popover();
        
        
    });
    
    

    
    