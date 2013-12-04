function DialogHandler(object){
	var _this = this;
	var container = $('#'+object.container);
	var dialog = document.createElement('section');
	//Set #dialog
	dialog.setAttribute('id', 'dialog');
	//Posiciona dialog
	this.posiciona = function(){
		var dialog_width = $(window).width()/2.3;
		//Pega a altura do novo conteúdo
		var dialog_height = $(dialog).outerHeight();
		var dialog_top = ($(window).outerHeight() - dialog_height)/2;
		var dialog_left = ($(window).width())/2;
		$(dialog).css({
			'width' : dialog_width+'px',
			'left': dialog_left+'px', 
			'top':  dialog_top+'px'
		});
		//alert($(window).outerHeight()+' e '+dialog_height);
	}
	this.posiciona();
	container.append(dialog);
	
	//Total Posts
	this.total_posts = 0;
	this.torres_height = {
		'atelies' : 0,
		'biblioteca': 0,
		'cinzeirao' : 0,
		'estudios' : 0,
		'galpao' : 0
	};
	this.get_torres_info = function(){
		$.ajax({
			url: 'includes/get_torres_info.php',
			type: 'POST',
			data: {},
			dataType: 'json',
			async: false,
			success: function(data){
				_this.total_posts = data.total_posts;
				console.log('total_posts = '+_this.total_posts); // --------------------- Deletar
				//Passa as alturas de cada torre para o objeto torres_height
				index = 0;
				for (var torre in _this.torres_height) {
				    // checar se esta propriedade pertence realmente ao objeto
				    if(_this.torres_height.hasOwnProperty(torre)){
				    	eval('_this.torres_height.'+torre+' = data.torres_heights[index];');
				   	    console.log(torre+"= "+data.torres_heights[index]); // ------------------ Deletar
				   	    index ++;
				    }
				}
				console.log(_this.torres_height); // ------------------- Deletar
			}
		});
	}	
	this.get_torres_info();
	
	this.load_torre = function(torre){
		if(torre == 'contato'){
			//Carrega a HTML dentro do container
			$.ajax({
				url: 'includes/torre_contato.php',
				type: "POST",
				data: {},
				dataType: 'html',
				success: function(data) {
					$(dialog).fadeOut(0);
					$(dialog).html('');
					$(dialog).append(data);
					_this.show_torre();
				}
			});
		}
		else {
			$.ajax({
				url: 'includes/get_torres_posts.php',
				type: 'POST',
				data: { torre: torre },
				dataType: 'json',
				async: false,
				success: function(data){	
					//Carrega a HTML dentro do container
					$.ajax({
						url: 'includes/torre_dialog.php',
						type: "POST",
						data: {
							torre: eval('torres_info.'+torre),
							principal: data.principal,
							/*
							 principal {
							 	nome,
							 	icone,
							 	mensagem,
							 	likes,
							 }						 
							 */
							post1: data.post1,
							post2: data.post2
						},
						async: false,
						dataType: 'html',
						success: function(data) {
							$(dialog).fadeOut(0);
							$(dialog).html('');
							$(dialog).append(data);
							_this.show_torre();
						}
					});
				}	
			});
		}	
		
	}
	//this.load_torre('biblioteca');
	
	var torres_info = {
		biblioteca : {
			nome: "Biblioteca",
			foto: "biblioteca.jpg",
			info: "A biblioteca localizada no prédio é o coração do campus, este é o principal ambiente de estudo e desenvolvimento de projetos, com salas de vídeos e estudo. Além do prédio onde se situam todas as cedes de coordenação"
		},
		atelies : {
			nome: "Ateliês",
			foto: "atelie.jpg",
			info: "Ambiente onde se encontra a maioria dos ateliês de moda, é o ambiente com maior nível de informalidade do campus"
		},
		cinzeirao : {
			nome: "Cinzeirão",
			foto: "cinzeirao.jpg",
			info: "Porta de entrada do campus, é onde encontram-se o maior numero de informações adversas, devido a grande diversidade de ambientes e pessoas."
		},
		estudios : {
			nome: "Estúdios",
			foto: "estudios.jpg",
			info: "Local onde se situam os estúdios de áudio e vídeo, além todo e qualquer material multimídia e as cantinas."
		},
		galpao : {
			nome: "Galpão",
			foto: "galpao.jpg",
			info: "Local onde se encontram os cursos de Design Digital e Gráfico, é neste ambiente que se possui o maior acervo de laboratórios de informática e salas extra aula."
		}
	}	
	
	this.hide_torre = function(){ $(dialog).fadeOut('slow'); }
	this.show_torre = function(){ 
		_this.posiciona();
		$(dialog).fadeIn('slow');
	}
	
	this.get_relative_heights = function(torre){
		var total_posts = _this.total_posts;
		var torre_posts = eval('_this.torres_height.'+torre+';');
		
		var max_height = 150;
		var min_height = 5;
		
		var torre_percentual_height = (torre_posts/total_posts);
		var torre_height = torre_percentual_height * max_height;
		if(torre_height < min_height){ torre_height = min_height; }
		return torre_height;
	}
}