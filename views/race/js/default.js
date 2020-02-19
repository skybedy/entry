$(function(){
	$('#zmena_udaju').submit(function(){
		var url = $(this).attr('action');
		var data = $(this).serialize();
		//alert(data);
		
		$.post(url,data,function(o){
			//alert(o.text);
			$('#content').html(o[1]);
			
		},'html');
		return false;
	});
});