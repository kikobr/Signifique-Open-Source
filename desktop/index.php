<?php 
	$style = '7c9d6de79ac70c3b7707f2355739835e';
?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">

<head>
    <title>
        Signifique
    </title>
    <link rel="stylesheet" type="text/css" href="css/<?php echo $style; ?>.css">
    <script type="text/javascript" src="js/three.min.js"></script>
    <script src="js/jquery-1.10.js" type="text/javascript"></script>
    <script src="js/tween.min.js" type="text/javascript"></script>
    <script src="js/Vague.js" type="text/javascript"></script><!-- Blur --> 
    <script src="js/DialogHandler.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(e) {
            document.getElementById('three-stage').style.height = window.innerHeight+"px";
            go_js();
        });

        function go_js(e) {
            var dialogHandler = new DialogHandler({
            	container: 'three-stage'
            });
            
            // Bem-vindo
            var bem_vindo_blur = $('#three-stage').Vague({
		        intensity:5 //blur intensity
		    });
		    bem_vindo_blur.blur();
		    var centraliza_bem_vindo = ($(window).outerHeight()-$('#bem-vindo > div').outerHeight())/2;
		    $('#bem-vindo > div').css("margin-top", centraliza_bem_vindo+'px');
            $('#bem-vindo a[name=entrar]').click(function(){
            	bem_vindo_blur.destroy();
            	$('#bem-vindo').fadeOut();
            	inicia_camera.start();
            });
            //
            
            //Move Background
            $('#three-stage').mousemove(function(e){
            	var x = -e.clientX/40, y = -e.clientY/40;
            	var x2 = -e.clientX/25, y2 = -e.clientY/25;
            	$('#three-stage-fundo').css('background-position', x+'px '+y+'px');
            	$('#three-stage-fundo2').css('background-position', x2+'px '+y2+'px');
            });
			
			
			var mouseX = 0, mouseY = 0, objetos = [], torre_clicada = false;
			
            //Elemento do stage
            stage_dom = document.getElementById('three-stage');
			var stageHalfX = window.innerWidth / 2;
			var stageHalfY = window.innerHeight / 2;
            
            //Criar um render
            var renderer = new THREE.WebGLRenderer({
                antialias: true
            });
            renderer.setSize(stage_dom.clientWidth, stage_dom.clientHeight);
            renderer.clear();
			//adicioná-lo ao DOM
            stage_dom.appendChild(renderer.domElement);
			
            //Criar uma câmera
            // new THREE.PerspectiveCamera(FOV, viewAspectRatio, zNear, zFar);
            var camera = new THREE.PerspectiveCamera(45, stage_dom.clientWidth / stage_dom.clientHeight, 1, 10000);
            camera.position.set( 0, -50, 0 );
            //camera.position.set( 0, 400, 0 );
            var backup_cam = {position: []};
            backup_cam.position.x = camera.position.x;
            backup_cam.position.y = camera.position.y;
            backup_cam.position.z = camera.position.z;
            camera.backup = backup_cam;
            camera.useQuaternion = true;
            

            //Criar uma cena
            var scene = new THREE.Scene();
			
			// Vetores transformados em Shapes.
			<?php include('torres.js'); ?>			
						
			//Configurações iniciais do Extrude.
			var extrusionSettings = {
				amount: 5,
				bevelEnabled: false,
				material: 0,
				extrudeMaterial: 1
			};
			
			//Extrude => gera as coordenadas em 3D
			var galpao_geometry = new THREE.ExtrudeGeometry(galpao_shape, extrusionSettings);
			var estudios_geometry = new THREE.ExtrudeGeometry(estudios_shape, extrusionSettings);
			var atelies_geometry = new THREE.ExtrudeGeometry(atelies_shape, extrusionSettings);
			var cinzeirao_geometry = new THREE.ExtrudeGeometry([cinzeirao_shape, cinzeirao_shape2], extrusionSettings);
			var biblioteca_geometry = new THREE.ExtrudeGeometry(biblioteca_shape, extrusionSettings);
			var contato_geometry = new THREE.ExtrudeGeometry(contato_shape, extrusionSettings);
			
			//Material das torres
			var material = new THREE.MeshLambertMaterial();
			
			//Cria os Meshs	utilizando os extrudes		
			var galpao = new THREE.Mesh(galpao_geometry, new THREE.MeshPhongMaterial({ color: '#78c47d', specular:0x006D05 , shininess: 45 }));
			var estudios = new THREE.Mesh(estudios_geometry, new THREE.MeshPhongMaterial({ color: '#00aeef', specular:0x005B7C, shininess: 45 }));
			var atelies = new THREE.Mesh(atelies_geometry, new THREE.MeshPhongMaterial({ color: '#5c5c5c', specular:0x5C5C5C, shininess: 45 }));
			var cinzeirao = new THREE.Mesh(cinzeirao_geometry, new THREE.MeshPhongMaterial({ color: '#f8d75a', specular: 0x6B5300, shininess: 50}));
			var biblioteca = new THREE.Mesh(biblioteca_geometry, new THREE.MeshPhongMaterial({ color: '#cf3837', specular: 0x820000, shininess: 45 }));
			var contato = new THREE.Mesh(contato_geometry, new THREE.MeshPhongMaterial({ color: '#383838', specular: 0x191919, shininess: 45 }));
			
			
			//Galpão Settings
			//Setar centro
			set_centroid(galpao);
			//Propriedades
			galpao.hover_material = new THREE.MeshPhongMaterial({ color: '#78c47d', specular:0x006D05 , shininess: 45, emissive: 0x002802 });
			galpao.backup_material = galpao.material;
			galpao.rotation.set(180 * Math.PI/180, 0 ,0);
			galpao.altura = dialogHandler.get_relative_heights('galpao');
			galpao.position.set(0,0,0);
			galpao.scale.z = 1;
			galpao.obj_type = 'torre';
			galpao.torre = 'galpao';
			galpao.clicado = false;
			//------------------------------------------------------
			//Estudios Settings
			//Setar centro
			set_centroid(estudios);
			//Propriedades
			estudios.hover_material = new THREE.MeshPhongMaterial({ color: '#00aeef', specular:0x005B7C, shininess: 45, emissive: 0x00161E });
			estudios.backup_material = estudios.material;
			estudios.rotation.set(180 * Math.PI/180, 0 ,0);
			estudios.altura = dialogHandler.get_relative_heights('estudios');
			estudios.position.set(140,-20,0);
			estudios.scale.z = 1;
			estudios.obj_type = 'torre';
			estudios.torre = 'estudios';
			estudios.clicado = false;
			//------------------------------------------------------
			//atelies Settings
			//Setar centro
			set_centroid(atelies);
			//Propriedades
			atelies.hover_material = new THREE.MeshPhongMaterial({ color: '#5c5c5c', specular:0x5C5C5C, shininess: 45, emissive: 0x141414 });
			atelies.backup_material = atelies.material;
			atelies.rotation.set(180 * Math.PI/180, 0 ,0);
			atelies.altura = dialogHandler.get_relative_heights('atelies');
			atelies.position.set(-100,-510,0);
			atelies.scale.z = 1;
			atelies.obj_type = 'torre';
			atelies.torre = 'atelies';
			atelies.clicado = false;
			//------------------------------------------------------
			//Cinzeirao Settings
			//Setar centro
			set_centroid(cinzeirao);
			//Propriedades
			cinzeirao.hover_material =  new THREE.MeshPhongMaterial({ color: '#f8d75a', specular: 0x6B5300, shininess: 45, emissive: 0x211900 });
			cinzeirao.backup_material = cinzeirao.material;
			cinzeirao.rotation.set(180 * Math.PI/180, 0 ,0);
			cinzeirao.altura = dialogHandler.get_relative_heights('cinzeirao');
			cinzeirao.position.set(170,-500,0);
			cinzeirao.scale.z = 1;
			cinzeirao.obj_type = 'torre';
			cinzeirao.torre = 'cinzeirao';
			cinzeirao.clicado = false;
			//------------------------------------------------------
			//Biblioteca Settings
			//Setar centro
			set_centroid(biblioteca);
			//Propriedades
			biblioteca.hover_material = new THREE.MeshPhongMaterial({ color: '#cf3837', specular: 0x820000, shininess: 45, emissive: 0x280000 });
			biblioteca.backup_material = biblioteca.material;
			biblioteca.rotation.set(180 * Math.PI/180, 0 ,0);
			biblioteca.altura = dialogHandler.get_relative_heights('biblioteca');
			biblioteca.position.set(-60,460,0);
			biblioteca.scale.z = 1;
			biblioteca.obj_type = 'torre';
			biblioteca.torre = 'biblioteca';
			biblioteca.clicado = false;
			//------------------------------------------------------
			//Contato Settings
			//Setar centro
			set_centroid(contato);
			//Propriedades
			contato.hover_material = new THREE.MeshPhongMaterial({ color: '#383838', specular: 0x191919, shininess: 45, emissive: 0x1E1E1E });
			contato.backup_material = contato.material;
			contato.rotation.set(180 * Math.PI/180, 0 ,0);
			contato.altura = 1;
			contato.position.set(-230,-100,0);
			contato.scale.x = 0.5;
			contato.scale.y = 0.5;
			contato.scale.z = 1;
			contato.obj_type = 'torre';
			contato.torre = 'contato';
			contato.clicado = false;


			
			//O Mapa contém todas as torres
			var mapa = new THREE.Object3D();
			mapa.add(galpao);
			mapa.add(estudios);
			mapa.add(atelies);
			mapa.add(cinzeirao);
			mapa.add(biblioteca);
			mapa.add(contato); console.log(contato);
			//Settings
			mapa.position.set(0,-100,100);
			mapa.rotation.set(-60 * Math.PI/180,0,0);
			var mapa_last_x = mapa.rotation.x;
			var mapa_last_y = mapa.rotation.y;
			//mapa.rotation.set(0 * Math.PI/180,0,180 * Math.PI/180);
			mapa.backup = {rotation: []};
			mapa.backup.rotation.x = mapa.rotation.x;
			mapa.backup.rotation.y = mapa.rotation.y;
			/*mapa.backup.rotation.x = 0;
			mapa.backup.rotation.y = 0;
			mapa.rotation.set(0,0,0);
			*/
			//Itens disponíveis para chamada de clique
			objetos.push(galpao);
			objetos.push(estudios);
			objetos.push(atelies);
			objetos.push(cinzeirao);
			objetos.push(biblioteca);
			objetos.push(contato);				
			
			//Adiciona ao stage
			mapa.scale.set(0.4,0.4,0.4);
			scene.add(mapa);			
			
            //Criar luz
            var light = new THREE.DirectionalLight({color: 0xff0000});
            light.position.set(-50, 200, 2000);
            light.intensity = 0.7;
            mapa.add(light);
            
            //Tela intro camera
            camera.position.set(-stage_dom.clientWidth, stage_dom.clientHeight, 800);
			camera.lookAt(new THREE.Vector3(mapa.position.x,mapa.position.y,mapa.position.z));
			camera.backup.position.z = camera.position.z;
            
			renderer.shadowMapEnabled = true;
			light.castShadow = true;
			//light.shadowCameraVisible = true;
                       	
           	inicia_camera = new TWEEN.Tween( { x: -stage_dom.clientWidth, y: stage_dom.clientHeight } )
	            .to( { x: 0, y:camera.backup.position.y }, 1000 )
	            .easing( TWEEN.Easing.Sinusoidal.InOut )
	            .onUpdate( function () {
	                	camera.position.x = this.x;
						camera.position.y = this.y;
						camera.lookAt(new THREE.Vector3(mapa.position.x,mapa.position.y-40,mapa.position.z));
	            });
	            //.start();
           	
            
			animate(); //Dá só a primeira rodagem na função.			
			
			var mapa_last_x;
			//ANIMAÇÃO
			function animate(t) {
				TWEEN.update();
				
				if(!torre_clicada){
					targetX = -mouseX * .0001;
					targetY = -mouseY * .0001;
					
					mapa.rotation.y += 0.05 * ( targetX );
					mapa.rotation.x += 0.05 * ( targetY );
					
					if(mapa.rotation.y >= 25 * Math.PI/180){
						mapa.rotation.y = 25 * Math.PI/180;
					} else if(mapa.rotation.y <= -25 * Math.PI/180){
						mapa.rotation.y = -25 * Math.PI/180;
					}
					
					if(mapa.rotation.x >= 10 * Math.PI/180){
						mapa.rotation.x = 10 * Math.PI/180;
					} else if(mapa.rotation.x <= -25 * Math.PI/180){
						mapa.rotation.x = -25 * Math.PI/180;
					}
					mapa_last_x = mapa.rotation.x;
				}
				
				for(var i=0; i < objetos.length; i++){
					if(objetos[i].estado == "hover"){
						if(objetos[i].scale.z < (objetos[i].altura)){
							objetos[i].scale.z += 3;
						}
					}
					else if(objetos[i].scale.z > 3 && !objetos[i].clicado) {
						objetos[i].scale.z -= 3;
					}
				}
				//createjs.Tween.update();
				renderer.render(scene, camera);
				window.requestAnimationFrame(animate, renderer.domElement);
			};
			
			//Projetor para localização de cliques
			var projector = new THREE.Projector();
			
			//Listener Mouse Move
			stage_dom.addEventListener('mousemove', mouseMove, false);
			stage_dom.addEventListener('click', mouseClick, false);
			
			function mouseMove(e){
				mouseX = e.clientX - stageHalfX;
				mouseY = e.clientY - stageHalfY;
				
				//Cria um vetor do clique				
				var vector = new THREE.Vector3( ( e.clientX / window.innerWidth ) * 2 - 1, - ( e.clientY / stage_dom.clientHeight ) * 2 + 1, 0.5 ); 
				projector.unprojectVector( vector, camera );
				var ray = new THREE.Raycaster(camera.position, vector.sub(camera.position).normalize());
				var intersects = ray.intersectObjects(objetos);
				if(intersects.length == 0){
					for(var i=0; i < objetos.length; i++){
						if(objetos[i].estado == "hover" && !objetos[i].clicado){
							objetos[i].estado = "";
							objetos[i].material = objetos[i].backup_material;
						}
					}
				}
				else {
					for(var i=0; i < objetos.length; i++){
						if(objetos[i].estado == "hover" && !objetos[i].clicado){
							objetos[i].estado = "";
							objetos[i].material = objetos[i].backup_material;
						}
					}
					var objeto = intersects[0].object;
					objeto.estado = "hover";
					objeto.material = objeto.hover_material;
				}
			}
			
			function mouseClick(e){
				e.preventDefault();
				
				mouseX = e.clientX - stageHalfX;
				mouseY = e.clientY - stageHalfY;
				//Cria um vetor do clique				
				var vector = new THREE.Vector3( ( e.clientX / window.innerWidth ) * 2 - 1, - ( e.clientY / stage_dom.clientHeight ) * 2 + 1, 0.5 ); 
				projector.unprojectVector( vector, camera );
				var ray = new THREE.Raycaster(camera.position, vector.sub(camera.position).normalize());
				var intersects = ray.intersectObjects(objetos);
				//Nenhum
				if(intersects.length == 0){
					//Se tiver alguma torre ativa, volta para o estado natural do mapa
					for(var i = 0; i < objetos.length; i++){
						if(objetos[i].clicado){
							torre_animation(objetos[i]);
						}
					}
				}
				else if (intersects.length >= 1){
					if(intersects[0].object.obj_type && intersects[0].object.obj_type == 'torre'){
						torre_animation(intersects[0].object);
					}
				}
			}
			
			function torre_animation(objeto){
				if(!objeto.clicado){
					//Reseta todos os itens para clicado = false.
					//Isso é necessário quando se clica num item com outro já selecionado
					for(var i = 0; i < objetos.length; i++){
						if(objetos[i] == objeto){
							objetos[i].clicado = true;
						}
						else { objetos[i].clicado = false; }
					}
					
					mapa.updateMatrixWorld();
					var objeto_global_pos = new THREE.Vector3();
					objeto_global_pos.getPositionFromMatrix( objeto.matrixWorld );
					
					var levanta_torre = new TWEEN.Tween({
						extrude: objeto.scale.z,
						cam_x : camera.position.x,
						//cam_y : camera.position.y,
						cam_z: camera.position.z,
						mapa_rotation_x : mapa.rotation.x,
						mapa_rotation_y : mapa.rotation.y
					}).to({
						extrude: objeto.altura,
						cam_x : (stageHalfX/4.5),
						//cam_y : objeto_global_pos.y +90,
						cam_z: camera.backup.position.z-50,
						mapa_rotation_x : mapa.backup.rotation.x,
						mapa_rotation_y : mapa.backup.rotation.y
					}, 1000).easing( TWEEN.Easing.Sinusoidal.InOut )
					.onStart(function(){ 
						for(var i =0; i < objetos.length; i++){
							objetos[i].clicado = false;
							objetos[i].estado = '';
						}
						objeto.clicado = true; 
						torre_clicada = true;
						//mapa_last_x = mapa.rotation.x; mapa_last_y = mapa.rotation.y;
					})
					.onUpdate(function(){
						objeto.scale.z = this.extrude;
						camera.position.x = this.cam_x;
						//camera.position.y = this.cam_y;
						camera.position.z = this.cam_z;
						mapa.rotation.x = this.mapa_rotation_x;
						mapa.rotation.y = this.mapa_rotation_y;
						console.log(this.mapa_rotation_x+' '+mapa.rotation.x);	
					})
					.onComplete(function(){
						dialogHandler.load_torre(objeto.torre);
					})
					.start();
		        }
		        else {
		        	var abaixa_torre = new TWEEN.Tween({
						extrude: objeto.scale.z,
						cam_x : camera.position.x,
						//cam_y : camera.position.y,
						cam_z: camera.position.z,
						mapa_rotation_x : mapa.rotation.x,
						mapa_rotation_y : mapa.rotation.y
					}).to({
						extrude: 1,
						cam_x : camera.backup.position.x,
						//cam_y : camera.backup.position.y,
						cam_z: camera.backup.position.z,
						mapa_rotation_x : mapa_last_x,
						mapa_rotation_y : mapa.backup.rotation.y
					}, 1000).easing( TWEEN.Easing.Sinusoidal.InOut )
					.onStart(function(){ 
						objeto.clicado = false;
						dialogHandler.hide_torre();
					})
					.onUpdate(function(){				
						objeto.scale.z = this.extrude;
						camera.position.x = this.cam_x;
						//camera.position.y = this.cam_y;
						camera.position.z = this.cam_z;
						mapa.rotation.x = this.mapa_rotation_x;
						mapa.rotation.y = this.mapa_rotation_y;
						console.log(this.mapa_rotation_x+' '+mapa.rotation.x);	
						//camera.lookAt(new THREE.Vector3(mapa.position.x,mapa.position.y-40,mapa.position.z));
					})
					.onComplete(function(){
						torre_clicada = false;
					})
					.start();
		        }
			}
		}
		
		function set_centroid(mesh){
			//Setando o centroid do objeto
			mesh.centroid = new THREE.Vector3();
			for (var i = 0, l = mesh.geometry.vertices.length; i < l; i++) {
				mesh.centroid.add(mesh.geometry.vertices[i]);
			}
			mesh.centroid.divideScalar(mesh.geometry.vertices.length);
			//Aplica o eixo
			var offset = mesh.centroid;
			mesh.geometry.applyMatrix(new THREE.Matrix4().makeTranslation( -offset.x, -offset.y, -5 ) );
		}
		
    </script>
</head>

<body>
	<div id="bem-vindo">
		<div>
			<h1>Signifique<br/>Projeto Interdisciplinar 3o Sem.</h1>
			<p>Bem-vindo!</p>
			<p>Fique à vontade para explorar nosso site.</p>
			<p>Navegue pelos espaços e descubra os comentários<br/> postados em cada local da faculdade.</p>
			<a name="entrar">Entrar</a>
		</div>
	</div>
	<div id="three-stage">
        <!-- three-scene -->
        <div id="three-stage-fundo"></div>
        <div id="three-stage-fundo2"></div>
    </div>
</body>

</html>