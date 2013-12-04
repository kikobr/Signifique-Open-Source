<?php
	$cookie = $_POST['cookie'];
	$nome = $_POST['nome'];
	
	include('conexao.php');
	
	// Atualiza usuários
	$query2 = mysql_query("UPDATE inter_3_users SET nome='".$nome."' WHERE cookie=".$cookie) or die("Erro ao atualizar!");
	// Atualiza as últimas mensagens
	$query4 = mysql_query("UPDATE inter_3_biblioteca SET nome='".$nome."' WHERE cookie=".$cookie) or die("Falha ao atualizar!");
	$query5 = mysql_query("UPDATE inter_3_galpao SET nome='".$nome."' WHERE cookie=".$cookie) or die("Falha ao atualizar!");
	$query6 = mysql_query("UPDATE inter_3_atelies SET nome='".$nome."' WHERE cookie=".$cookie) or die("Falha ao atualizar!");
	$query7 = mysql_query("UPDATE inter_3_cinzeirao SET nome='".$nome."' WHERE cookie=".$cookie) or die("Falha ao atualizar!");
	$query8 = mysql_query("UPDATE inter_3_estudios SET nome='".$nome."' WHERE cookie=".$cookie) or die("Falha ao atualizar!");
	$query9 = mysql_query("UPDATE inter_3_banca_design_digital SET nome='".$nome."' WHERE cookie=".$cookie) or die("Falha ao atualizar!");

	mysql_close($conecta);
?>