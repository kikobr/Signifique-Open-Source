<?php
	$user = "root";
	$password = "mupyehbom";
	$servidor = "localhost";
	$banco = "inter-3";

	//---------------------------------------------
	$conecta = mysql_connect($servidor, $user, $password) or die("Falha ao conectar ao banco de dados! "+mysql_error());
	$select_db = mysql_select_db($banco, $conecta) or die("Falha ao conectar ao banco de dados! (2) "+mysql_error());

?>