<?php
	$id = $_POST['id'];
	$cookie = $_POST['cookie'];
	$pagina = $_POST['pagina'];
	
	//------------------
	include("../conexao.php");
	$query = mysql_query("SELECT likes, interacoes FROM inter_3_".$pagina." WHERE id=".$id) or die("Erro (6)");
	$row = mysql_fetch_row($query);
	$likes_string = $row[0]; //13,85,654,82,5,67,
	$likes = explode(",", $likes_string);
	$interacoes = $row[1];
	
	$curtiu = false;
	foreach($likes as $num){
		if((int)$num == (int)$cookie){
			$curtiu = true;
		}
	}
	
	mysql_close($conecta);
	
	echo json_encode(array("curtiu"=> $curtiu, "likes"=>$likes_string, "likes_num"=>$interacoes));
?>