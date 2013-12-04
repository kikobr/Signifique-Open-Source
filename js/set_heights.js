//$(function(){
	console.log('aeeeee');
	var header_height = $('header').outerHeight();
	var footer_height= $('footer').height();
	var total_height = $(window).height();
	var conteudo_height = total_height - header_height - footer_height;
	$('#conteudo-wrapper').height(conteudo_height);
	//Corrige os Bugs do scroll no Android
	//var scroll = new iScroll('conteudo-wrapper');
	//var icones_scroll = new iScroll('select-icones'); //Tirar para a rolagem no iOS
	
	//touchScroll('conteudo-wrapper'); 	
	var scroll = new iScroll('conteudo-wrapper');
	
	touchScroll('select-icones-wrapper');
	var icones_scroll = new iScroll('select-icones-wrapper'); //Melhora um pouco o deslize dos icones
		
	console.log('aoooooohahahah');
//});
