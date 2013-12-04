<div id="torre">
	<h1>Signifique</h1>
	<div id="contato-info">
		<div><img src="imagens/icone-logo.png" alt="Signifique Logo" /></div>
		<div>
			<p>
				Projeto interdisciplinar de Design de Mobilidade de um site sobre comunicação no ambiente universitário, onde as pessoas que frequentam o Campus Morumbi escrevem mensagens e ressignificam o local, através de textos e pictogramas.
			</p>
		</div>
	</div>
	<?php 
		$integrantes = array(
			array(
				'nome' => 'Diego Lohans',
				'icone' => '',
				'mensagem' => ''
			),
			array(
				'nome' => 'Douglas Monteiro',
				'icone' => '',
				'mensagem' => ''
			),	
			array(
				'nome' => 'Kiko Herrschaft',
				'icone' => '',
				'mensagem' => ''
			),
			array(
				'nome' => 'Kainã Oliveira',
				'icone' => '',
				'mensagem' => ''
			),
			array(
				'nome' => 'Leandro Negrelli',
				'icone' => '',
				'mensagem' => ''
			),
			array(
				'nome' => 'Ricardo Gomes',
				'icone' => '',
				'mensagem' => ''
			),
			array(
				'nome' => 'Vitor Alexandre',
				'icone' => '',
				'mensagem' => ''
			),
			array(
				'nome' => 'Wesley Santos',
				'icone' => '',
				'mensagem' => ''
			),
		);
		$metade = (int)sizeof($integrantes)/2;
	?>
	<?php 
		function post($nome, $icone, $mensagem){
	?>
		<article class="post contato">
			<section class="info">
				<div class="icone">
					<img src="imagens/icones/small/<?php $icone; ?>.png">
				</div><!-- icone -->
				<div class="mensagem">
					<h2><?php echo $nome; ?></h2>
					<p><?php echo $mensagem; ?></p>
				</div><!-- mensagem -->
			</section><!-- info-section -->
			<section class="rodape-faixa">					
			</section>				
		</article><!-- Post -->
	<?php 
	}
	?>
	<div id="contato-posts">	
		<div class="esquerda">
			<?php 			
				for($i = 0; $i < $metade; $i ++){
					post($integrantes[$i]['nome'],$integrantes[$i]['icone'],$integrantes[$i]['mensagem']);	
				}
			?>
		</div>
		<div class="direita">
			<?php 			
				for($i = $metade; $i < sizeof($integrantes); $i ++){
					post($integrantes[$i]['nome'],$integrantes[$i]['icone'],$integrantes[$i]['mensagem']);	
				}
			?>
		</div>
	</div>
</div>