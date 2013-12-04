<?php
	//Manter na mesma ordem da variável torres_height em DialogHandler.js
	$torres = array('inter_3_atelies', 'inter_3_biblioteca', 'inter_3_cinzeirao', 'inter_3_estudios', 'inter_3_galpao');
	$total_posts = 0;
	$torres_heights = array();
	
	include('conexao.php');
	
	//Get total posts
	foreach($torres as $torre){
		$query = mysql_query("SELECT COUNT(id) FROM ".$torre) or die("Erro (6)");
		$count = mysql_fetch_row($query);
		$count = (int)$count[0];
		$total_posts += $count;
		array_push($torres_heights, $count);
	}
	mysql_close($conecta);

	echo json_encode(array("total_posts"=> $total_posts, "torres_heights"=>$torres_heights));
	
?>