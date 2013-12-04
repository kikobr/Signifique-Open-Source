<?php
	$pagina = $_POST['pagina'];
	$pagina = addslashes($pagina);
	
	//------------------
	include("conexao.php");
	$query = mysql_query("SELECT * FROM inter_3_".$pagina." ORDER BY id DESC") or die("Erro (6)");
	$lista = array();
	while($campo = mysql_fetch_assoc($query)){
		$nome = $campo['nome'];
		$cookie = $campo['cookie'];
		$mensagem = $campo['mensagem'];
		$icone = $campo['icone'];
		$id = $campo['id'];
		$interacoes = $campo['interacoes'];
		
		$lista_subitem = array('nome'=>$nome, 'cookie'=>$cookie, 'mensagem'=>$mensagem, 'icone'=>$icone, 'id'=>$id, 'interacoes'=>$interacoes);
		array_push($lista,$lista_subitem);
	}
	mysql_close($conecta);
	
	echo json_encode($lista);
?>