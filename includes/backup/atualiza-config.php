<?php
	$cookie = $_POST['cookie'];
	$nome = $_POST['nome'];
	
	include('conexao.php');
	
	// Atualiza usuários
	$query2 = mysql_query("UPDATE inter_3_users SET nome='".$nome."' WHERE cookie=".$cookie) or die("Erro ao atualizar!");
	// Atualiza as últimas mensagens
	$query3 = mysql_query("UPDATE inter_3_torre SET nome='".$nome."' WHERE cookie=".$cookie) or die("Falha ao atualizar!");

	mysql_close($conecta);
?>