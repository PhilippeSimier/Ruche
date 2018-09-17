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
	<title>Matlab Visualization</title>
</head>
<body>
	<?php require_once 'menu.php'; ?>
	<div class="container" style="padding-top: 56px;">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
			    <div class="popin">
			    <iframe  height="620" width="100%" style="border: 1px solid #cccccc;" src="
				<?php echo "https://thingspeak.com/apps/matlab_visualizations/" . $_GET['id'] . "?height=600" ?>
				">
				</iframe>
				</div>
			</div>
		</div>
                <div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="popin">
                                <h3>Graphique de dispersion</h3>
                                        <p>Les graphiques de dispersion sont utiles pour vérifier l'existance de corrélation entre deux grandeurs physiques. </p>
                                        <p>Plus le nuage de points est plat et se groupe autour d'une ligne, plus la corrélation est forte. Plus le nuage de points est circulaire ou éparpillé moins la corrélation est probable.</p>
                                </div>
                        </div>

		</div>
	<?php require_once 'piedDePage.php'; ?>
</body>
</html>
