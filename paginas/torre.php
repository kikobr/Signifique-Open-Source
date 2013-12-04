<script type="text/javascript" src="js/jPages.js"></script> <!-- Usado em Posts_handler -->
<script type="text/javascript" src="js/Posts_Handler.js"></script>
<script type="text/javascript" src="js/User.js"></script>
<?php
	include("header.php");
?>
<script type="text/javascript">
	$(document).ready(function(){
		var pagina = "<?php echo $pagina ?>";
		var id = "<?php echo $id; ?>";
		
		//A classe User guarda as informações do usuário
		var user = new User(id);
		//A classe Posts_Handler guarda tudo que for referente a funções de posts,
		//controle dos botões, e tal.
		var posts = new Posts_Handler({
			id: id, 
			pagina: pagina, 
			user: user
		}); 
		user.exibe_lista = function() { posts.exibe_lista(); } //Precisa ser definida depois da posts instanciada.	
		//---------
		yepnope('js/set_heights.js');	 
	});
</script>
<section id="conteudo-wrapper">
	<section id="conteudo">
		<!--
		<span>Latitude: <?php if(isset($_POST['latitude']))echo $_POST['latitude']; ?></span>
		<span>Longitude: <?php if(isset($_POST['longitude']))echo $_POST['longitude']; ?></span>
		-->
		<div id="post-destaque"></div>
		<ul id="lista-posts"></ul>
		<div id='pagination'>
			<div id="lista-pagination"></div>
			<div style="clear:both;"></div>
		</div>
	</section>
</section>

<div id="postar-dialog" style="display:none;">
	<form id="postar-form">
		<div id="postar-form-top">
			<h2>Nova Mensagem</h2>
			<input type="text" id="input-nome" placeholder="Qual seu nome? :)" required="required" />
			<textarea id="input-mensagem" placeholder="Mensagem" required="required"></textarea>
			<div id="select-icones-wrapper">
				<div id="select-icones">
					<ul>
						<h2>Selecione seu ícone</h2>
						<li><img src="imagens/icones/small/pct-amb-sonora-balao.png" alt="pct-amb-sonora-balao" /></li>
						<li><img src="imagens/icones/small/pct-arquitetura-balao.png" alt="pct-arquitetura-balao" /></li>
						<li><img src="imagens/icones/small/pct-conexao-balao.png" alt="pct-conexao-balao" /></li>
						<li><img src="imagens/icones/small/pct-design-digital-balao.png" alt="pct-design-digital-balao" /></li>
						<li><img src="imagens/icones/small/pct-fotografia-balao.png" alt="pct-fotografia-balao" /></li>
						<li><img src="imagens/icones/small/pct-games-balao.png" alt="pct-games-balao" /></li>
						<li><img src="imagens/icones/small/pct-grafico-balao.png" alt="pct-grafico-balao" /></li>
						<li><img src="imagens/icones/small/pct-moda-balao.png" alt="pct-moda-balao" /></li>
						<li><img src="imagens/icones/small/pct-otimismo-balao.png" alt="pct-otimismo" /></li>
						<li><img src="imagens/icones/small/pct-pessimismo-balao.png" alt="pct-pessimismo" /></li>
						
					</ul>
				</div>
			</div>
		</div>
		<div id="postar-form-bottom">
				<div id="input-icone">
					<input type="hidden" name="icone" value="pct-otimismo" />
					<img src="imagens/icones/big/pct-otimismo.png" height="100" />
				</div>
			<input class="botao-destaque" type="submit" value="Enviar"></input>
		</div>
	</form>
	
	<a id="form-fechar"><img src="imagens/close.png" /></a>
	<a id="user-config"><img src="imagens/config.png" /></a>
	<form id="user-config-form">
		<a id="user-config-fechar"><img src="imagens/close.png" /></a>
		<p>Atualize seu nome</p>
		<input id="user-config-nome" type="text" placeholder="Nome" >
		<input type="submit" value="Atualizar" class="botao-destaque" >
	</form>
	<div id="user-config-form-fundo"></div>
</div>
<!--
<script type="text/javascript" src="js/set_heights.js"></script>
-->
<footer>
	<div id="postar">
		<p>Nova mensagem</p>
	</div>
</footer>