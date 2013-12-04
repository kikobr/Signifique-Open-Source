    <script src="js/Tween.js" type="text/javascript"></script>
    <!--
        <script type="text/javascript" src="js/addCube.js"></script>
        -->
    <script>
    	document.addEventListener('DOMContentLoaded', function(e) {
            go();
        });
        function go(e){
			var three_stage = document.getElementById('three-stage');
			console.log(three_stage);
		    //target.alpha = 0;
			
			   	init();
			    animate();
			
			    function init() {
					//setupTween();
			        //var tween = new TWEEN.Tween(three_stage.style,'width',Tween.bounceEaseOut,25,100,0.5,'px');
					var current = { width: three_stage.clientWidth };
					var tweenHead	= new TWEEN.Tween(current)
					.to({width: 1}, 2000)
					.onUpdate(function(){
						three_stage.style.width = current.width+'px';
						console.log(three_stage.style.width);
					}).onComplete(function(){console.log('aeeeee');}).start();
				
			    }
			
			    function animate() {			
			        requestAnimationFrame( animate ); // js/RequestAnimationFrame.js needs to be included too.
			        TWEEN.update();			
			    }		    


        }
        

    </script>