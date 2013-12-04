<?php 
	//Puxa o plugin
	require "scssphp/scss.inc.php";
	
	//Cria uma instância com as configurações do SCSS a ser criado
	$scss = new scssc();
	$scss->setFormatter("scss_formatter"); //scss_formatter, scss_formatter_nested, scss_formatter_compressed
	$scss->addImportPath('../css/scss'); //Importantíssimo pra se usar a chamada @import
	
	//new scss_server($sourceDir, $cacheDir, $scss)
	$server = new scss_server("../css/scss", "../css", $scss);
	$server->serve();
?>