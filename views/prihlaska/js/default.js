$(function(){
	
    $('#prihlasovaci_formular').validate();

    $('#prihlasovaci_formular_enduro_wrapper').on('click', '#prihlasovaci_formular_enduro', function(){
	    $(this).validate({
            rules:{
                etapa: {
                    required: true
                }
            }
        });
    });
    
      $('input, textarea').placeholder({customClass: 'my-placeholder'});   
    
    // tyhle funkce se asi vůbec nepoužívají
    $('#prihlasoaci_formular').submit(function(){
	var url = $(this).attr('action');
	var data = $(this).serialize();
	$.post(url,data,function(val){
	    $('#content').html('<div>'+ val +'</div>');
	},'html');
	return false;
    });

    $('select').change(function() {
	if ($(this).children('option:first-child').is(':selected')) {
	  $(this).addClass('placeholder');
	} else {
	 $(this).removeClass('placeholder');
	}
    });
    
     $(".pojisteni_popover").popover({
	 trigger: "hover"
     }); 


    $('#prihlasovaci_formular').submit(function(){
        if($('input[name="kontrola_kategorie"]').val() != null){
            var poradi_podzavodu = $('select[name="poradi_podzavodu"] option:selected').val();
            if(poradi_podzavodu === undefined){
                var poradi_podzavodu =  $('input[name="poradi_podzavodu"]').val();
            }
            var rok_narozeni = $('select[name="rok_narozeni"] option:selected').val();
            var pohlavi = $('select[name="pohlavi"] option:selected').val();
            var data = 'event_order='+poradi_podzavodu+'&rok_narozeni='+rok_narozeni+'&pohlavi='+pohlavi;
            //var url = 'http://api.timechip.loc/prihlasky/kontrola-kategorie/2018/47';
            //var url = 'https://api.timechip.cz/prihlasky/kontrola-kategorie/2019/61';
            $.get(url,data,function(val){
                if(!val){
                    alert("Pro zadanou kombinaci roku narození a pohlaví není nadefinovaná kategorie, pro jistotu si zkontrolujte zadání");
                }
            });
        }
        //return false;
    });
});