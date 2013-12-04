<?php
	if(isset($_POST['pagina'])){$pagina = $_POST['pagina'];}
	/*----*/
	// Usuários Cadastrados
	/*----*/
	//Se tiver o cookie, já está cadastrado e está tudo lindo.
	if(isset($_COOKIE['inter_3_users'])){
		$id = $_COOKIE['inter_3_users'];
		//setcookie("inter_3_users", "", time()-3600); //Exclui o cookie. Usar se der merda.
	}
	//Se não tiver o cookie, cadastrar no banco de dados e criar o novo cookie eterno (id).
	else {
		include('../includes/conexao.php');
		//Pega o último usuário cadastrado e define o cookie do próximo usuário.
		$query = mysql_query("SELECT cookie FROM `inter_3_users` ORDER BY primeiro_acesso DESC limit 1") or die("Erro ao conectar ao banco de dados! (3)");
		while($campo = mysql_fetch_assoc($query)){
			$ultimo_cookie = $campo['cookie'];
			$novo_cookie = ((int)$ultimo_cookie) + 1;
		}
				
		//Cria novo cookie para expirar no apocalipse.
		setcookie("inter_3_users", $novo_cookie, time()+(10 * 365 * 24 * 60 * 60));
		//Cadastra o novo usuário no banco de dados.
		$query_insert = mysql_query("INSERT into inter_3_users () VALUES ()") or die("Erro! (5)");
		
		//Uso a variável id para evitar bugs de timing com a definição de cookies
		//Às vezes o cookie só é percebido quando recarregar a página. Como quero usar esse dado
		//de imediato, vou referenciar tudo a essa variável id e criá-la aqui também.
		$id = $novo_cookie;
		
		mysql_close($conecta); //Fecha a conexão.
	}
	
?>
<header>
	<h1><?php echo $pagina; ?></h1>
</header>