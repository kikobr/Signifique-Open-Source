<?php
	$cookie = $_POST['cookie'];
	$nome = $_POST['nome'];
	$icone = $_POST['icone'];
	$mensagem = $_POST['mensagem'];
	$pagina = $_POST['pagina'];
	$novo_usuario = $_POST['novo_usuario'];
	
	
	$cookie = addslashes($cookie);
	$nome = addslashes($nome);
	$icone = addslashes($icone);
	$mensagem = addslashes($mensagem);
	$pagina = addslashes($pagina);
	$novo_usuario = addslashes($novo_usuario);
	
	
	//------------------
	include("conexao.php");
	//Adiciona uma linha
	$query = mysql_query("INSERT INTO inter_3_".$pagina." (cookie, nome, mensagem, icone) VALUES ('".$cookie."', '".$nome."', '".$mensagem."', '".$icone."')") or die("Erro ao submeter seu post! (6)");

	if($novo_usuario){
		// Atualiza usuários
		$query2 = mysql_query("UPDATE inter_3_users SET nome='".$nome."' WHERE cookie=".$cookie) or die("Erro ao atualizar!");
		// Atualiza as últimas mensagens
		$query3 = mysql_query("UPDATE inter_3_".$pagina." SET nome='".$nome."' WHERE cookie=".$cookie) or die("Falha ao atualizar!");
	}
	
	mysql_close($conecta);
?>