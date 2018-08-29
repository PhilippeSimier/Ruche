<!----------------------------------------------------------------------------------
    @fichier  infoSystem.php							    		
    @auteur   Philippe SIMIER (Touchard Washington le Mans)
    @date     Aout 2018
    @version  v1.0 - First release						
    @details  page pour afficher les information systèmes
			  Cette page fonctionne si l'utilisateur www-data
			  appartient aux groupes video et i2c 
	
			$ sudo usermod -G video www-data
			$ sudo usermod -a -G i2c www-data
			$ sudo service apache2 restart
	
------------------------------------------------------------------------------------>


<?php
include "authentification/authcheck.php" ;

require_once('../ini/ini.php');
require_once('../definition.inc.php');


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Info Système</title>
    <!-- Bootstrap CSS version 4.1.1 -->
	
    <link rel="stylesheet" href="/css/ruche.css" />
    <link rel="stylesheet" href="/css/bootstrap.min.css">
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="/scripts/bootstrap.min.js"></script>
    
		
</head>
<body>

<?php require_once '../menu.php'; ?>

<div class="container" style="padding-top: 65px;">
    

		
		<div class="row">

			
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="popin">
				
					<?php
						echo "<h2> OS " . shell_exec('uname -s') ."</h2><p>";
						$output = shell_exec('uname -r');
						echo "Version : $output<p/>";
						
						echo '<p>version du firmware du GPU<br />';
						$output = shell_exec('vcgencmd vcos version');
						echo "<pre>$output</pre><p/>";

	
					?>
				</div>
			</div>	
				
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="popin">
				<h2>Température CPU</h2>
					<?php
						
						$output = shell_exec('vcgencmd measure_temp');
						echo "<pre>$output</pre><p/>";
	
					?>
						
				</div>
				<div class="popin">
				<h2>Camera</h2>
					<?php
						
						$output = shell_exec('vcgencmd get_camera');
						echo "<pre>$output</pre><p/>";
	
					?>
						
				</div>
			</div>
			
		
		</div>
		
		<div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="popin">
				<h2>Bus I2C</h2>
					<?php
						
						$output = shell_exec('i2cdetect -y 1');
						echo "<pre>$output</pre><p/>";
	
					?>
						
				</div>
			</div>
		</div>
		<?php require_once '../piedDePage.php'; ?>
</div>
	
</body>

	
		