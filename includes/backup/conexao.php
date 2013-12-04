<?php 
	$user = "kikoherrsc";
	$password = "Tonhao666";
	$servidor = "dbmy0105.whservidor.com";
	$banco = "kikoherrsc";
	
	//---------------------------------------------
	$conecta = mysql_connect($servidor, $user, $password) or die("Falha ao conectar ao banco de dados! "+mysql_error());
	$select_db = mysql_select_db($banco, $conecta) or die("Falha ao conectar ao banco de dados! (2) "+mysql_error());

?>