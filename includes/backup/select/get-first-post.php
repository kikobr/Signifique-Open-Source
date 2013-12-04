<?php
	$pagina = $_POST['pagina'];
	
	//------------------
	include("../conexao.php");
	//Seleciona a id do post mais curtido
	$query = mysql_query("SELECT id FROM inter_3_".$pagina." ORDER BY interacoes DESC, id DESC") or die("Erro (6)");
	$row = mysql_fetch_row($query);
	$post_id = $row[0];
	
	$query2 = mysql_query("SELECT * FROM inter_3_".$pagina." WHERE id=".$post_id);
	while($campo = mysql_fetch_assoc($query2)){
		$nome = $campo['nome'];
		$icone = $campo['icone'];
		$mensagem = $campo['mensagem'];
		$interacoes = $campo['interacoes'];
	}
	
	mysql_close($conecta);
	
	echo json_encode(array('post_id'=>$post_id, 'nome'=>$nome, 'icone'=>$icone, 'mensagem'=>$mensagem, 'interacoes'=>$interacoes));
?>