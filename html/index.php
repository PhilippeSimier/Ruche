<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>the connected beehive</title>
	
    <link   rel="stylesheet" href="./css/bootstrap.min.css" >
    <link   rel="stylesheet" href="./css/ruche.css" />    
    
	<script src="./scripts/jquery.min.js"></script>
	<script src="./scripts/bootstrap.min.js"></script>
</head>

<body>
	
	<div class="row" style="background-color:white; padding-top: 63px; ">
		<div class="col-lg-12">
			
			<a href="index.php">
			<img  style="width:100%;" title="Retour accueil" src="./images/bandeau_ruche.png" />
			</a>
		</div>
		
	</div>
	
	<?php require_once 'menu.php'; ?>
	
	<div class="container" >
			
	<div class="row popin" style="padding-top: 35px; ">
		<div class="col-lg-12">
			<h2>La ruche connectée</h2>
		<ul>
	<?php 
		require_once 'piedDePage.php'; 
	?>

	</div>
</body>	