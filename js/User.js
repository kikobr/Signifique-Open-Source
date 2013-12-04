function User(id){
	var _this = this;
	this.nome = undefined;
	this.id = id;
	this.ultimo_acesso = undefined;
	//this.exibe_lista Essa função vai ser definida depois que a classe Posts_Handle ser instanciada.
	//-----------------------------
	var nome_field = $('#input-nome'),
		user_config = $('#user-config'),
		user_config_fechar = $('#user-config-fechar');
		user_config_form = $('#user-config-form'),
		user_config_nome = $('#user-config-nome'),
		user_config_form_fundo = $('#user-config-form-fundo');
	
	user_config.click(function(){
		_this.show_config_form();
	});
	user_config_fechar.click(function(){
		_this.show_config_form();
	});
	
	user_config_form.submit(function(e){
		_this.atualiza_config(e);
	});
	
	this.get_info = function(){
		$.ajax({
			url: "includes/user-get-info.php",
			type: "POST",
			data: {cookie: id},
			dataType: "json",
			async: false,
			success: function(data){
				_this.nome = data.nome;
				_this.id = data.cookie;
				_this.primeiro_acesso = data.primeiro_acesso;
			}
		});
	};
	
	this.auto_nome = function(){
		_this.get_info();
		if(_this.nome !== undefined && !_this.nome.match(/anonimo/i)){
			nome_field.attr("type", "hidden");
			nome_field.val(_this.nome);			
		}
	}; this.auto_nome();
	
	this.show_config_form = function() {
		//Posiciona o user_config
		var left = ($(window).width() - user_config_form.outerWidth()) /2;
		var top = ($(window).outerHeight() - user_config_form.outerHeight()) /2;
		user_config_form.css('left', left);
		user_config_form.css('top', top);
		
		//Abre-fecha
		user_config_form.toggle("fast");
		user_config_nome.focus();
		if(user_config_form_fundo.css('display')=='none'){
			user_config_form_fundo.css('display', 'block');
		} else { 			
			user_config_form_fundo.css('display', 'none');
		}
	}
	
	this.atualiza_config = function(e){
		e.preventDefault(e);
		$.ajax({
			url: "includes/atualiza-config.php",
			type: "POST",
			data: { 
				cookie: _this.id,
				nome: user_config_nome.val() },
			success: function(data){
				_this.show_config_form();
				_this.exibe_lista(); // É definida depois de instanciar a Posts_Handle, para copiar a função.
				_this.get_info();
			}
		});
	}
}