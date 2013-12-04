// Classe que contém todos os métodos de posts
function Posts_Handler(object) {
	var postar_automove = false; //Remover
	var _this = this;
	var pagina = object.pagina;
	var id = object.id;
	
	// Usar false como padrão.
	var user = typeof object.user !== 'undefined' ? object.user : false;
	// Usar #lista-posts como padrão.
	var lista_posts = typeof object.lista_posts !== 'undefined' ? object.lista_posts : $('#lista-posts');
	var lista_pagination = typeof object.lista_pagination !== 'undefined' ? object.lista_pagination : $('#lista-pagination');
	// Usar #postar como padrão.
	var botao_exibe_form = typeof object.botao_exibe_form !== 'undefined' ? object.botao_exibe_form : $('#postar');
	// Usar #postar-dialog form como padrão.
	var postar_dialog = typeof object.postar !== 'undefined' ? object.postar : $('#postar-dialog');
	var form_postar = typeof object.form !== 'undefined' ? object.form : $('#postar-form');
	var fechar = typeof object.fechar !== 'undefined' ? object.fechar : $('#form-fechar');
	var user_config = typeof object.user_config !== 'undefined' ? object.user_config : $('#user_config');
	var user_config_form = typeof object.user_config_form !== 'undefined' ? object.user_config_form : $('#user-config-form');

	//Ouvinte de clique no botão
	botao_exibe_form.click(function(){
		_this.exibe_form();
	}); 
			
	//Ouvinte de submit no formulário
	form_postar.submit(function(e){
		_this.postar(e);
	});

	//Ouvinte de fechamento do formulario
	fechar.click(function(){
		_this.esconde_form();
	});
	
	
	//Postar functions
	function set_postar_dialog(postar_dialog) {
		//Postar-dialog -> Tamanho e posicionamento
		var screen_width = $(window).width();
		var screen_height = $(window).outerHeight();
		postar_dialog.css('width', screen_width+'px');
		postar_dialog.css('height', screen_height+'px');
		postar_dialog.css('left', screen_width+'px');
		postar_dialog.css('top', '0px');
		postar_dialog.css('display', 'block');
		
		//Variáveis
		var postar_form_top = $('#postar-form-top');
		var input_icone = $('#input-icone'), select_icones = $('#select-icones-wrapper');
		
		
		//var icones_scroll = new iScroll('select-icones');
		
		
		//Calcula e define as alturas
		var postar_form_bottom_height = $('#postar-form-bottom').outerHeight();
		var postar_form_top_height = screen_height - postar_form_bottom_height;
		postar_form_top.css('height', postar_form_top_height+'px');
		
		//Clicar em alterar icone
		input_icone.click(function(){
			//alert("postar-dialog height:"+postar_dialog.height()+" bottom height:"+postar_form_bottom_height+" top height:"+postar_form_top_height);
			if(select_icones.css('height')=='0px'){
				abre_select_icones(select_icones, true);
			}
			else {
				abre_select_icones(select_icones, false);
				//alert(postar_form_top_height +" "+ select_icones +" "+select_icones.children('ul').height() );
			}
		});
		//Selecionar ícone do menu.
		$(select_icones[0].getElementsByTagName('img')).click(function(){
			input_icone.children('input').attr('value', $(this).attr('alt'));
			input_icone.children('img').attr('src', 'imagens/icones/big/'+$(this).attr('alt')+'.png');
			input_icone.click();
		})
	}
	var timeout = setTimeout(function(){set_postar_dialog(postar_dialog)}, 3000);
	//set_postar_dialog(postar_dialog);

	
	function abre_select_icones(select_icones, abre){
		if(abre){
			select_icones.animate({height: '100%'}, 350);
		} else {
			select_icones.animate({height: '0px'}, 350);
		}
	}
	
	
	this.exibe_form = function(){	postar_dialog.animate({left: "0px"},500);	}
	this.esconde_form = function(){	 postar_dialog.animate({left: $(window).width()+"px"},500);	}
	this.postar = function(e){
		if(user.nome.match(/anonimo/i)){var novo_usuario = true;} else {var novo_usuario = false;}
		e.preventDefault();
		$.ajax({
			url: "includes/insere-post.php",
			type: "POST",
			data: {
				cookie: id,
				nome: $('#input-nome').val() != '' ? $('#input-nome').val() : user.nome,
				icone: $('#input-icone').children('input').attr('value'),
				mensagem: $('#input-mensagem').val(),
				pagina: pagina,
				novo_usuario: novo_usuario
			},
			success: function(){
				_this.exibe_lista();
				_this.esconde_form();
				$('#input-mensagem').val('');
				if(user) { user.get_info(); }
				if(novo_usuario){ user.auto_nome(); }
			}
		})
	}	
	
	//Botão Likes
	this.get_likes = function(botao){
		var id = $(botao).closest('article').attr('data-id');
		var curtiu;
		$.ajax({
			url: "includes/select/get-likes.php", //Vai identificar se o usuário já curtiu o post.
			type: "POST",
			data: {
				id: id, 
				cookie: user.id, 
				pagina: pagina 
			},
			dataType: "json",
			success: function(data){
				curtiu = data.curtiu;
				if(curtiu){
					botao.addClass('active'); 
					//botao.siblings('.botao_dislike').css('display', 'none');
				} // Se o usuário já tiver curtido, adiciona a classe e remove o botão de descurtir.
				
				var count = botao.attr('data-count');
				botao[0].innerHTML = curtiu ? '<img src="imagens/like/like_branco.png"></img> '+"("+count+")" : '<img src="imagens/like/like_branco.png"></img> ' + "("+count+")";
			}
		}); 
	}	
	this.set_botao = function(botao){
		$(botao).click(function(){ _this.like($(this)); });
		$(botao).each(function(){
			_this.get_likes($(this));
		})
	}
	
	this.get_torre_icon = function(){
		$.ajax({
			url: "includes/select/get-torre-icon.php",
			type: "POST",
			data: {	'pagina': pagina },
			dataType: "json",
			success: function(data){
				var maior = data.maior;
				var icone = data.maior_icone;
			}
		});
	}
	this.get_first_post = function(){
		$.ajax({
			url: "includes/select/get-first-post.php",
			type: "POST",
			data: {	'pagina': pagina },
			async: false,
			dataType: "json",
			success: function(data){
				var id = data.post_id;
				var nome = data.nome;
				var icone = data.icone;
				var mensagem = data.mensagem;
				var interacoes = data.interacoes;
			
				var html = '<article class="post destaque" data-id="'+id+'">';
					html += '<div class="post_session">';
						html += '<div class="post_img_session"><img src="imagens/icones/small/'+icone+'.png" /></div>';
						html += '<div class="post_content_session"><p class="post_mensagem">'+'<span class="post_nome">'+nome+'</span> '+mensagem+"</p></div>";
						html += '<div class="post-destaque-img"><img src="imagens/icones/small/star.png" /></div>';
					html += '</div>';
					html += '<div class="like_session"><a class="botao_like" data-count="'+interacoes+'">Gostar</a></div>';
					html += "</article>";
				
				$('#post-destaque').html(html);
			}
		});
	}
	
	this.exibe_lista = function(){
		$.ajax({
			url: "includes/lista_de_posts.php",
			dataType: "json",
			type: "POST",
			async: false, //Importantíssimo para a listagem de páginas posterior.
			data: {pagina: pagina},
			success: function(data){
				lista_posts.html('');
				for(var i = 0; i < data.length; i++){
					var nome = data[i].nome;
					var cookie = data[i].cookie;
					var mensagem = data[i].mensagem;
					var icone = data[i].icone;
					var id = data[i].id;
					var interacoes = data[i].interacoes;
					
					var html = '<li><article class="post" data-id="'+id+'">';
					html += '<div class="post_session">';
					html += '<div class="post_img_session"><img src="imagens/icones/small/'+icone+'.png" /></div>';
					html += '<div class="post_content_session"><p class="post_mensagem">'+'<span class="post_nome">'+nome+'</span> '+mensagem+"</p></div>";
					html += '</div>'; //Content-session
					html += '<div class="like_session"><a class="botao_like" data-count="'+interacoes+'">Gostar</a></div>';
					html += "</article></li>";
					
					lista_posts.append($(html));
				}			
				$(lista_pagination).jPages({
			        containerID: "lista-posts",
			        perPage      : 10,
			        first       : "primeiro",
			        previous    : "anterior",
			        next        : "próximo",
			        last        : "último"
			    });
				lista_posts.fadeOut(0);
				lista_posts.fadeIn("slow");
				//			
				_this.get_first_post();
				_this.set_botao($('.botao_like'));
				//
			}
		});
	}; this.exibe_lista();
	
	this.like = function(botao){
		var id = $(botao).closest('article').attr('data-id');
		$.ajax({
			url: "includes/select/get-likes.php", //Vai identificar se o usuário já curtiu o post.
			type: "POST",
			data: {
				id: id, 
				cookie: user.id, 
				pagina: pagina 
			},
			async: false, //Importante para manter o passo-a-passo.
			dataType: "json",
			success: function(data){
				if(data.curtiu == false){
					var likes = data.likes == null ? "" : data.likes;
					//Se não curtiu, adiciona seu id.
					$.ajax({
						url: "includes/insert/insere-like.php",
						type: "POST",
						async: false,
						data: {
							id: id,
							cookie: user.id,
							pagina: pagina,
							likes: likes
						},
						success: function(data2){
							_this.exibe_lista();
						}
					});
				} 
				else {
					//Se já curtiu, pára.
					alert("Você já curtiu este post! :)");
				}
			}
		});
	}
}
