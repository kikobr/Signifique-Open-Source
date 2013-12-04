<?php
	$torre = $_POST['torre'];
	$principal = $_POST['principal']; //Array: icone, nome, mensagem, likes, dislikes
	$posts = array($_POST['post1'], $_POST['post2']);
?>
<div id="torre">
	<h1><?php echo $torre['nome'] ?></h1>
	<div id='torre-info'>
		<!-- Icone principal -->
		<div>
			<div id="torre-icone">
				<img src="imagens/icones/big/<?php echo $principal['icone']; ?>.png" />
			</div>
			<div id="torre-foto">
				<img src="imagens/fotos/<?php echo $torre['foto']; ?>" />
			</div>
		</div>
		
		<div>
			<section class="esquerda">
				<article class="post principal">
					<section class="info">
						<div class="icone"><img src="imagens/icones/small/<?php echo $principal['icone']; ?>.png"/></div>
						<div class="mensagem">
							<h2><?php echo $principal['nome']; ?></h2>
							<p><?php echo $principal['mensagem']; ?></p>
						</div>
					</section><!-- info -->
					<section class="rodape-faixa">
					</section>
				</article><!-- /post-principal -->
				<p>
					<?php echo $torre['info']; ?>
				</p>
			</section><!-- /esquerda -->
			<section class="direita">
				<?php 
					foreach($posts as $post){
						echo '<article class="post">';
							echo '<section class="info">';
								echo '<div class="icone">';
									echo '<img src="imagens/icones/small/'.$post['icone'].'.png"/>';
								echo '</div>';
								echo '<div class="mensagem">';
									echo '<h2>'.$post['nome'].'</h2>';
									echo '<p>'.$post['mensagem'].'</p>';
								echo '</div>';
							echo '</section>';
						echo '</article>';
					}
				?>
			</section><!-- /direita -->
			<div style="clear:both;"></div>
		</div>
		
		
	</div><!-- /torre-info -->
</div>