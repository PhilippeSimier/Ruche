<!DOCTYPE html>

<?php 
    session_start();
	require_once('definition.inc.php');
    $ini  = parse_ini_file(CONFIGURATION, true);
?>

<html>
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
	<!-- Bootstrap CSS version 4.1.1 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="/scripts/bootstrap.min.js"></script> 
    <link rel="stylesheet" href="css/ruche.css" />
	<title>Nuage de points</title>
</head>
<body>
	<?php require_once 'menu.php'; ?>
	<div class="container" style="padding-top: 56px;">
		<div class="row">
			<div class="col-md-4 col-sm-12 col-xs-12">
			    <div class="popin">
			        <h3>Graphique de dispersion</h3>
					<p>Les graphiques de dispersion sont utiles pour vérifier l'existance de corrélation, d'une relation entre deux grandeurs. </p>
					<p>Plus le nuage de points est plat et se groupe autour d'une ligne, plus la corrélation est forte. </p>
				</div>
			</div>
			<div class="col-md-8 col-sm-12 col-xs-12">
			    <div class="popin"  style="min-height: 300px;">
				<h3>Poids Température</h3>
			    <iframe  height="420" width="100%" style="border: 1px solid #cccccc;" src="https://thingspeak.com/apps/matlab_visualizations/243176?height=400"></iframe>
				</div>
			</div>
		</div>
	<?php require_once 'piedDePage.php'; ?>
</body>
</html>