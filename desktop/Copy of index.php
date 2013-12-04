<!DOCTYPE html>
<html>
<meta charset="UTF-8">

<head>
    <title>
        Three.js
    </title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/three.min.js"></script>
    <!--<script src="js/Tween.js" type="text/javascript"></script>-->
    <script src="js/tween.min.js" type="text/javascript"></script>
    <!--
        <script type="text/javascript" src="js/addCube.js"></script>
        -->
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function(e) {
            document.getElementById('three-stage').style.height = window.innerHeight+"px";
            go_js();
        });

        function go_js(e) {
			var mouseX = 0, mouseY = 0, objetos = [];
			
            //Elemento do stage
            stage_dom = document.getElementById('three-stage');
			var stageHalfX = window.innerWidth / 2;
			var stageHalfY = window.innerHeight / 2;
            
            //Criar um render
            var renderer = new THREE.WebGLRenderer({
                antialias: true
            });
            renderer.setSize(stage_dom.clientWidth, stage_dom.clientHeight);            
            // Seta a cor de fundo do renderer.
            //renderer.setClearColorHex(0xEEEEEE, 1.0);
            renderer.clear();
			//adicioná-lo ao DOM
            stage_dom.appendChild(renderer.domElement);			
			
            //Criar uma câmera
            // new THREE.PerspectiveCamera(FOV, viewAspectRatio, zNear, zFar);
            var camera = new THREE.PerspectiveCamera(45, stage_dom.clientWidth / stage_dom.clientHeight, 1, 10000);
            camera.position.set( 0, -50, 800 );
            camera.useQuaternion = true;
            

            //Criar uma cena
            var scene = new THREE.Scene();						
			
			<?php include('torres.js'); ?>
			
			//Criar vetores
			var secao1_shape = new THREE.Shape();
			secao1_shape.moveTo(66.0, 5.0);
			secao1_shape.lineTo(135.0, 5.0);
			secao1_shape.lineTo(135.0, 56.0);
			secao1_shape.lineTo(191.0, 0.0);
			secao1_shape.lineTo(254.0, 0.0);
			secao1_shape.lineTo(254.0, 56.0);
			secao1_shape.lineTo(310.0, 56.0);
			secao1_shape.lineTo(254.5, 111.5);
			secao1_shape.lineTo(188.0, 111.5);
			secao1_shape.lineTo(146.8, 152.8);
			secao1_shape.lineTo(48.0, 152.8);
			secao1_shape.lineTo(48.0, 98.0);
			secao1_shape.lineTo(85.0, 66.0);
			secao1_shape.lineTo(0.0, 67.0);
			secao1_shape.lineTo(66.0, 5.0);
			
			var secao2_shape = new THREE.Shape();
			secao2_shape.moveTo(334.4, 188.6);
			secao2_shape.lineTo(334.4, 86.0);
			secao2_shape.lineTo(280.0, 86.0);
			secao2_shape.lineTo(254.5, 111.5);
			secao2_shape.lineTo(188.0, 111.5);
			secao2_shape.lineTo(146.8, 152.8);
			secao2_shape.lineTo(189.0, 195.0);
			secao2_shape.lineTo(189.0, 243.0);
			secao2_shape.lineTo(240.1, 191.9);
			secao2_shape.lineTo(240.1, 243.0);
			secao2_shape.lineTo(334.0, 243.0);
			secao2_shape.lineTo(298.5, 207.5);
			secao2_shape.lineTo(298.5, 152.8);
			secao2_shape.lineTo(334.4, 188.6);
			
			//Configurações iniciais do Extrude.
			var extrusionSettings = {
				amount: 5,
				bevelEnabled: false,
				material: 0,
				extrudeMaterial: 1
			};
			
			//Extrude => gera as coordenadas em 3D
			var secao1_geometry = new THREE.ExtrudeGeometry(secao1_shape, extrusionSettings);
			var secao2_geometry = new THREE.ExtrudeGeometry(secao2_shape, extrusionSettings);
			
			//Cria os Meshs	utilizando os extrudes		
			var secao1 = new THREE.Mesh(secao1_geometry, new THREE.MeshLambertMaterial());
			//Setar centro
			set_centroid(secao1);
			//Props
			secao1.backup_material = secao1.material;
			secao1.rotation.set(180 * Math.PI/180, 0 ,0);
			secao1.altura = 3;
			secao1.position.set(0,0,0);
			secao1.scale.z = 1;
			secao1.obj_type = 'torre';
			
			var secao2 = new THREE.Mesh(secao2_geometry, new THREE.MeshLambertMaterial());
			//Setar centro
			set_centroid(secao2);
			//Props
			secao2.backup_material = secao2.material;
			secao2.rotation.set(180 * Math.PI/180,0,0);
			secao2.altura = 15;
			secao2.position.set(106,-105,0);
			secao2.scale.z = 1;
			secao2.obj_type = 'torre';
			
			//Grupo de objetos
			var mapa = new THREE.Object3D();
			mapa.add(secao1);
			mapa.add(secao2);
			mapa.position.set(0,0,0);
			mapa.rotation.set(-45 * Math.PI/180,0,0);
			objetos.push(secao1); // Guarda item para chamada de clique
			objetos.push(secao2);
			//Adiciona ao stage
			scene.add(mapa);						
			
            //Criar luz
            var light = new THREE.SpotLight({color: 0xff0000});
            light.position.set(-50, 200, 400);
            scene.add(light);
            
			/*
			//Fundo - plano curvo
			var p_width = stage_dom.clientWidth, p_height = stage_dom.clientHeight, p_width_segments =1, p_height_segments = 100;
			var plane = new THREE.PlaneGeometry(p_width, p_height, p_width_segments, p_height_segments);
			
			for(var i=0; i<plane.vertices.length/2; i++) {
				console.log(plane.vertices[0].z);
			    plane.vertices[(2*i)].z = Math.pow(2, i/15);
			    plane.vertices[(2*i)+1].z = Math.pow(2, i/15);
			}
			
			var crateTexture = new THREE.ImageUtils.loadTexture( 'img/fundo.jpg' );
			crateTexture.wrapS = crateTexture.wrapT = THREE.RepeatWrapping;

			var fundo = new THREE.Mesh(plane, new THREE.MeshPhongMaterial( { 
			    color: 0xffffff, 
			    ambient: 0xffffff, // should generally match color
			    shininess: 0,
			    map: crateTexture
			}));
			fundo.position.set(0,-50,-1000);
			fundo.scale.set(5,5,1);
			//fundo.rotation.set(0,0,0);
			console.log(fundo);
			//fundo.doubleSided = true; fundo.rotation.y = Math.PI/2-0.5;
			scene.add(fundo);
            
            //Luz fundo
            var light2 = new THREE.SpotLight();
            light2.intensity = 1;
            light2.angle = 3*Math.PI/3;
            light2.exponent = 1;
            light2.target = fundo;
            light2.position.set(stage_dom.clientWidth, 0, -250);
            scene.add(light2);       
            //Renderizar a cena utilizando a camera
            renderer.render(scene, camera);
            
            
            //View Light
			renderer.shadowMapEnabled = true;
			renderer.shadowMapSoft = true;
            light2.castShadow = true;
           	light2.shadowCameraVisible = true;
           	console.log('agora');
           	console.log(light2);
           	*/
           	
           	inicia_camera = new TWEEN.Tween( { x: -stage_dom.clientWidth, y: stage_dom.clientHeight } )
	            .to( { x: 0, y:-150 }, 1000 )
	            .easing( TWEEN.Easing.Sinusoidal.InOut )
	            .onUpdate( function () {
	                	camera.position.x = this.x;
						camera.position.y = this.y;
						camera.lookAt(new THREE.Vector3(mapa.position.x,mapa.position.y,mapa.position.z));
	            })
	            .start();
           	
            
			animate(); //Dá só a primeira rodagem na função.			
			
			
			//ANIMAÇÃO
			function animate(t) {		
				TWEEN.update();
				
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
				
				
				for(var i=0; i < objetos.length; i++){
					if(objetos[i].estado == "hover"){
						if(objetos[i].scale.z < (objetos[i].altura)){
							objetos[i].scale.z += 1;
						}
					}
					else if(objetos[i].scale.z > 1 && !objetos[i].clicado) {
						objetos[i].scale.z -= 1;
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
						if(objetos[i].estado == "hover"){
							objetos[i].estado = "";
							objetos[i].material = objetos[i].backup_material;
						}
					}
				}
				else {
					for(var i=0; i < objetos.length; i++){
						if(objetos[i].estado == "hover"){
							objetos[i].estado = "";
							objetos[i].material = objetos[i].backup_material;
						}
					}
					var objeto = intersects[0].object;
					objeto.estado = "hover";
					objeto.material = new THREE.MeshLambertMaterial( { color: 0xff6600, ambient: 0xff2200, combine: THREE.MultiplyOperation });
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
				}
				else if (intersects.length >= 1){
					if(intersects[0].object.obj_type && intersects[0].object.obj_type == 'torre'){
						torre_animation(intersects[0].object);
					}
				}
			}					
			function torre_animation(objeto){
				if(!objeto.clicado){
				//Levanta a torre
				var levanta_torre = new TWEEN.Tween( { z: objeto.position.z, extrude: objeto.scale.z, camera_x: camera.position.x, mapa_rotation_x: mapa.rotation.x, mapa_rotation_y: mapa.rotation.y} )
		            .to( { z: 50, extrude:objeto.altura, camera_x: 450, mapa_rotation_x: 0, mapa_rotation_y: 45 * Math.PI/180 }, 500 )
		            .easing( TWEEN.Easing.Sinusoidal.InOut )
		            .onStart(function(){
			           	var restore = new TWEEN.Tween({x: mapa.position.x, y: mapa.position.y, z: mapa.position.z} )
			           	.to({ x: objeto.position.x, y: objeto.position.y, z:objeto.position.z }, 800)
			           	.easing( TWEEN.Easing.Sinusoidal.Out )
			           	.onUpdate(function(){
			           		camera.lookAt(new THREE.Vector3(this.x, this.y, this.z));
			           	}).start();
			        })
		            .onUpdate( function () {
		                	objeto.position.z = this.z;
		                	objeto.scale.z = this.extrude;

		                	objeto.clicado = true;
		                	camera.position.x = this.camera_x;
							mapa.rotation.x = this.mapa_rotation_x;
							mapa.rotation.y = this.mapa_rotation_y;
							
		                	//camera.lookAt(new THREE.Vector3(objeto.position.x, objeto.position.y, objeto.position.y));
		            })
		            .start();
		        }
		        else {
		        	//Levanta a torre
					var desce_torre = new TWEEN.Tween( { z: objeto.position.z, extrude: objeto.scale.z, camera_x: camera.position.x, mapa_rotation_x: mapa.rotation.x, mapa_rotation_y: mapa.rotation.y} )
			            .to( { z: 0, extrude: 1, camera_x: 0, mapa_rotation_x: -45 * Math.PI/180, mapa_rotation_y: 0 }, 500 )
			            .easing( TWEEN.Easing.Sinusoidal.InOut )
			            .onStart(function(){
			            	var restore = new TWEEN.Tween({x: objeto.position.x, y: objeto.position.y, z: objeto.position.z} )
			            	.to({ x: mapa.position.x, y: mapa.position.y, z:mapa.position.z }, 500)
			            	.easing( TWEEN.Easing.Sinusoidal.Out )
			            	.onUpdate(function(){
			            		camera.lookAt(new THREE.Vector3(this.x, this.y, this.z));
			            	}).start();
			            })
			            .onUpdate( function () {
			                	objeto.position.z = this.z;
			                	objeto.scale.z = this.extrude;
			                	objeto.clicado = false;
			                	camera.position.x = this.camera_x;
								mapa.rotation.x = this.mapa_rotation_x;
								mapa.rotation.y = this.mapa_rotation_y;
							
			                	
		                		camera.lookAt(new THREE.Vector3(objeto.position.x, objeto.position.y, objeto.position.y));
								//camera.lookAt(new THREE.Vector3(objeto.position.x, objeto.position.y-50, objeto.position.z));
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
	<div id="three-stage">
        <!-- three-scene -->
    </div>
</body>

</html>