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
	<title>Dew point</title>
</head>
<body>
	<?php require_once 'menu.php'; ?>
	<div class="container" style="padding-top: 56px;">
		<div class="row">
			<div class="col-md-4 col-sm-12 col-xs-12">
			    <div class="popin">
			        <h3>Point de rosée</h3>
					<p> L'expression « point de rosée » est une abréviation pour « température du point de rosée », 
					qui est la température à laquelle on doit refroidir l'air, à pression constante, pour qu'il devienne saturé.</p>
					<p>si l'air se refroidit davantage, on aura un excès d'humidité qui se condensera sous forme de rosée.</p>
					
				</div>
			</div>
			<div class="col-md-8 col-sm-12 col-xs-12">
			    <div class="popin"  style="min-height: 300px;">
				<h3>Points de rosée</h3>
				<iframe  height="420" width="100%" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/556419/charts/3?bgcolor=%23ffffff&color=%23d62020&dynamic=false&results=60&type=line&update=15&height=400&width=600"></iframe>
				</div>
			</div>
		</div>
	<?php require_once 'piedDePage.php'; ?>
</body>
</html>