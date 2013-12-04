<?php
	$id = $_POST['id'];
	$cookie = $_POST['cookie'];
	$pagina = $_POST['pagina'];
	$likes = $_POST['likes'] == undefined ? "" : $_POST['likes'];
	
	$likes .= $cookie.","; //40, -> 40,50,
	//------------------
	include("../conexao.php");
	//Atualiza a linha do post, adicionando o like.
	$query = mysql_query("UPDATE inter_3_".$pagina." SET likes = ('".$likes."') WHERE id=".$id) or $output = ("Erro ao adicionar sua curtida!".mysql_error());
	
	$query2 = mysql_query("SELECT interacoes FROM inter_3_".$pagina." WHERE id=".$id);
	$interacoes = mysql_fetch_row($query2);
	$interacoes = (int)$interacoes[0];
	$interacoes ++;
	$query3 = mysql_query("UPDATE inter_3_".$pagina." SET interacoes = ('".$interacoes."') WHERE id=".$id) or $output = ("Erro ao adicionar sua curtida!".mysql_error());
	//Colocar externo esse aumento de interacoes.
	
	mysql_close($conecta);
?>