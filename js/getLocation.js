var Posicao = new Object;

//O geoPosition.js é utilizado para suavizar os bugs de navegadores.
//Poderia ser usado direto o navigator.geolocation.getCurrentPosition(funct);
if (geoPosition.init()){
	geoPosition.getCurrentPosition(posicao_succed, posicao_failed);
} else {
	alert("Desculpe, para acessar esta página nós precisamos autenticar sua posição atual, e seu navegador não oferece este recurso. :/");
}

function posicao_succed(position){
	Posicao.latitude = position.coords.latitude;
	Posicao.longitude = position.coords.longitude;
	$('#conteudo')[0].innerHTML += "<p> Latitude: "+Posicao.latitude+"</p>";
	$('#conteudo')[0].innerHTML += "<p> Longitude: "+Posicao.longitude+"</p>";
	//---------------------
	continua();
	//---------------------
}
function posicao_failed(erro) {
	if(erro.code == 1) {alert("Para acessar a página, nós precisamos autenticar a sua localização! :/");}
	alert("Erro");
}