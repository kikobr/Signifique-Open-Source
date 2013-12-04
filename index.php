<?php 
	$pagina = index;
	if(isset($_GET['biblioteca'])){$pagina = biblioteca;}
	else if(isset($_GET['cinzeirao'])){$pagina = cinzeirao;}
	else if(isset($_GET['atelies'])){$pagina = atelies;}
	else if(isset($_GET['galpao'])){$pagina = galpao;}
	else if(isset($_GET['estudios'])){$pagina = estudios;}
	else if(isset($_GET['inter-digital'])){$pagina = banca_design_digital;}
	else if(isset($_GET['torre'])){$pagina = torre;}
	
	//$style = 'style.css';
	$style = '7c9d6de79ac70c3b7707f2355739835e.css'; // Output do scss.
	//$style_mobile = 'style_mobile.css';
	$style_mobile = '43b8582f825dfceb455741cde546e15a.css'; // Output do scss.
?>

<!DOCTYPE html>
<html xmlns:svg="http://www.w3.org/2000/svg">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.02"/>
		<title>Interdisciplinar 3</title>
		<link type="text/css" rel="stylesheet" href="css/<?php echo $style; ?>">
		<script type="text/javascript" src="js/jquery-1.10.js"></script>
		<script type="text/javascript" src="js/yepnope.js"></script>
		<script type="text/javascript" src="js/touchscroll.js"></script>
		
		<!--
		<link rel="stylesheet" href="css/lungo.css">	
		<script type="text/javascript" src="js/quo.js"></script>
		<script type="text/javascript" src="js/lungo.js"></script>	
		-->
	</head>
	<body>
		<!-- Check Mobile Phone -->
		<!-- --- -->
		<script type="text/javascript">
			$(document).ready(function(){
				var isMobileDevice = navigator.userAgent.match(/iPad|iPhone|iPod|Android|BlackBerry|webOS/i) != null 
    || screen.width <= 480 || screen.width >=480;
    			//Se for mobile, checa a posição.
	    		if(isMobileDevice){
		    		yepnope({
		    			load: ['css/<?php echo $style_mobile; ?>', 'js/iscroll.js'],
		    			complete: function(){ continua(); }
		    		});
	    			<?php 
		    			/*
		    			include("js/geoPosition.js");
						include("js/getLocation.js");	    			
		    			*/
		    		?>	    	
		    		// A continua() é chamada da getLocation, caso funcione certo
		    		// e a propriedade Posicao.ok for true
		    		function continua(){
		    			$("#all").html("");
		    			$.ajax({
		    				url: "paginas/torre.php",
		    				type: "POST",
		    				data: {
		    					'pagina': "<?php echo $pagina; ?>",
		    					'latitude':/*Posicao.latitude*/0.5,
		    					'longitude':/*Posicao.longitude*/0.5
		    				},
		    				dataType: "html",
		    				async: false,
		    				success: function(data){
		    					//Carrega a página dentro da div #all, que agora está vazia.
		    					$("#all").html(data);   					
		    				}
		    			});
		    		}
		    		
	    		}	    			
	    		//---------------------
	    		//Se não for mobile.
	    		else {
	    			alert("Encontre o QR Code para acessar a página!");
	    		}
			});		
		</script>
		<div id="all">
			<!-- O que aparece em caso de erro -->
			<div id="conteudo">
				<p>Aguarde um momento enquanto a página é carregada.</p>
			</div>
		</div>
	</body>
</html>