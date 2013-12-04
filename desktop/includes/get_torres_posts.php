<?php
	//Manter na mesma ordem da variável torres_height em DialogHandler.js
	$torres = array('inter_3_atelies', 'inter_3_biblioteca', 'inter_3_cinzeirao', 'inter_3_estudios', 'inter_3_galpao');
	$torre = $_POST['torre'];
	
	$info = (object) array(
		'principal' => array(
			'nome' => '',
			'icone' => '',
			'mensagem' => '',
			'likes' => '',
			'dislikes' => ''
		),
		'post1' => array(
			'nome' => '',
			'icone' => '',
			'mensagem' => ''
		),
		'post2' => array(
			'nome' => '',
			'icone' => '',
			'mensagem' => ''
		)
	);
	
	$total_posts = 0;
	$torres_heights = array();

	include('conexao.php');
	
	$primeiro = mysql_query("SELECT nome, mensagem, icone, likes FROM inter_3_".$torre.' order by interacoes DESC, postagem DESC limit 1') or die ('Erro na query');
	$primeiro_return = mysql_fetch_row($primeiro);
	$info -> principal['nome'] = $primeiro_return[0];
	$info -> principal['mensagem'] = $primeiro_return[1];
	$info -> principal['icone'] = $primeiro_return[2];
	$info -> principal['likes'] = $primeiro_return[3];
	
	$secundarios = mysql_query("SELECT nome, mensagem, icone FROM inter_3_".$torre.' order by id DESC limit 2') or die ('Erro na query');
	$i = 1;
	while ($row = mysql_fetch_assoc($secundarios)){		
		eval("\$info -> post".$i."['nome'] = \$row['nome'];");
		eval("\$info -> post".$i."['mensagem'] = \$row['mensagem'];");
		eval("\$info -> post".$i."['icone'] = \$row['icone'];");
		$i ++;
	}
	
	mysql_close($conecta);

	echo json_encode(array("principal"=>$info->principal, "post1"=>$info->post1, "post2"=>$info->post2));
	
?>