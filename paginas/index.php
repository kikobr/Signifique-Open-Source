<?php
	$header_title = $pagina; 
	include('../includes/header.php'); 
?>
<section id="corpo">
	<div id="float-information">
		<span>Id de usuário: <?php echo $id;  ?></span>
		<span>Latitude: <?php if(isset($_POST['latitude']))echo $_POST['latitude']; ?></span>
		<span>Longitude: <?php if(isset($_POST['longitude']))echo $_POST['longitude']; ?></span>
	</div>
</section>