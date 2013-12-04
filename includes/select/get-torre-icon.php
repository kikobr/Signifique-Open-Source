<?php
	$pagina = $_POST['pagina'];
	
	$pagina = addslashes($pagina);
	
	//------------------
	include("../conexao.php");
	$query = mysql_query("SELECT icone FROM inter_3_".$pagina) or die("Erro (6)");
	$icones = array();
	while($campo = mysql_fetch_assoc($query)){
		array_push($icones, $campo['icone']);
	}
	/* --------------------- Icone da Torre -------------------- */
	// Pegar as quantidade de cada icone na lista completa
	$ocorrencias = array_count_values($icones); //Object {appstore.png: 77, firefox.png: 9, guy.png: 5, chrome.png: 6}		
	$maior = 0;
	$maior_icone;
	foreach($ocorrencias as $icone=>$num){
		if((int)$num > $maior){
			$maior = (int)$num;
			$maior_icone = $icone;
		}
	}
	/*-----------------------------------------------------------*/
	
	mysql_close($conecta);
	
	echo json_encode(array('ocorrencias'=>$ocorrencias, "maior"=>$maior, 'maior_icone'=>$maior_icone));
?>