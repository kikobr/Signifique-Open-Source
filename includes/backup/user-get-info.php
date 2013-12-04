<?php
	$cookie = $_POST['cookie'];
	
	//------------------
	include("conexao.php");
	$query = mysql_query("SELECT nome, cookie, primeiro_acesso FROM inter_3_users WHERE cookie=".$cookie) or die("Erro (6)");
	while($campo = mysql_fetch_assoc($query)){
		$nome = $campo['nome'];
		$cookie = $campo['cookie'];
		$primeiro_acesso = $campo['primeiro_acesso'];
		
		$usuario = array('nome'=>$nome, 'cookie'=>$cookie, 'primeiro_acesso'=>$primeiro_acesso);
	}
	mysql_close($conecta);
	
	echo json_encode($usuario);
?>