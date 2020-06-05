<?php

include "authentification/authcheck.php" ;

require_once('../ini/ini.php');
require_once('../definition.inc.php');
require_once('../api/Form.php');

use Aggregator\Support\Form;

//------------si des données  sont reçues on les enregistrent dans le fichier battery.ini ---------
if( !empty($_POST['envoyer'])){
	// verification des types des variables envoyés
	
	$capacite = filter_input(INPUT_POST, 'capacite', FILTER_VALIDATE_FLOAT);
	if ($capacite !== null){
		//  lecture du fichier de configuration
		$array  = parse_ini_file(BATTERY, true);
		//  Modification des valeurs pour la section [battery]
		$array['battery'] = array ('capacite'  => $capacite,
								   'charge' => $_POST['charge'],
								   'type'  => $_POST['type'],
								   'time' => $_POST['time'],
								   'current' => $_POST['current'],
								   'rendement' => $_POST['rendement']
								   );

		//  Ecriture du fichier de configuration modifié
		$ini = new ini (BATTERY);
		$ini->ajouter_array($array);
		$ini->ecrire(true);
	}
}

// -------------- sinon lecture du fichier de configuration section battery -----------------------------
else
{
   $ini  = parse_ini_file(BATTERY, true);
   $_POST['capacite']  = $ini['battery']['capacite'];
   $_POST['charge']    = $ini['battery']['charge'];
   $_POST['type']      = $ini['battery']['type'];
   $_POST['time']      = $ini['battery']['time']; 
   $_POST['current']   = $ini['battery']['current'];
   $_POST['rendement'] = $ini['battery']['rendement'];   
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Battery</title>
    
    <link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/ruche.css" />
	
	<script src="../scripts/jquery.min.js"></script>
	<script src="../scripts/bootstrap.min.js"></script>     
    

    <style type="text/css">
		
		.h1 {
			font-size: 80px;
		}
	</style>

	<script type="text/javascript">
		
		function affiche( data ) {               // fonction pour afficher les données reçues
			console.log(data);                   // affichage de data dans la console
			if(data.OK){
				$('#tension').text(  data.u   + " " + data.uniteU); 
				$('#courant').text(  data.i   + " " + data.uniteI);
				$('#puissance').text(data.p   + " " + data.uniteP);
				$('#soc').text(      data.soc + " " + data.uniteSOC);
			}
		}

		function requete_ajax(){
			// requete Ajax méthode getJSON
			$.getJSON(
				"/cgi-bin/batteryJson", // Le fichier cible côté serveur. data au format Json
				affiche
			);			
		}

		$(document).ready(function(){
		   	$.getJSON("/cgi-bin/batteryJson", affiche); // affichage des données quand la page est dispo
			setInterval(requete_ajax, 1000);  // appel de la fonction requete_ajax toutes les  secondes
		   
		});
		
	</script>

</head>
<body>
	<?php require_once '../menu.php'; ?>
	<div class="container" style="padding-top: 63px;" >
	
	
	
	<div class="row" >
        
	    <div class="col-md-6">
			<div class="popin">
					<div class="row">
					    <div class="col-sm-6"><h3>Voltage :</h3></div>
						<div class="col-sm-6"><h3><span id="tension"></span></h3></div>
					</div>
					<div class="row">
					    <div class="col-sm-6"><h3>Current :</h3></div>
						<div class="col-sm-6"><h3><span id="courant"></span></h3></div>
					</div>
					<div class="row">
					    <div class="col-sm-6"><h3>Power :</h3></div>
						<div class="col-sm-6"><h3><span id="puissance"></span></h3></div>
					</div>
					<div class="row">
					    <div class="col-sm-6"><h3>State of charge :</h3></div>
						<div class="col-sm-6"><h3><span id="soc"></span></h3></div>
					</div>
					
			</div>
	    </div>
		
		<div class="col-md-6">
            <div class="popin">
            <h2>Battery</h2>
		        <form class="form-horizontal" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="configuration" >
					
					<?php 
						echo Form::hidden('time', $_POST['time']);
						echo Form::hidden('current', $_POST['current']);
						$optionsNumber = array( 'class' => 'form-control', 'step' => "0.1");
						echo Form::input( 'number', 'capacite', $_POST['capacite'], $optionsNumber, "Capacity (Ah)");
						$optionsText = array( 'class' => 'form-control');
						echo Form::input( 'text', 'type', $_POST['type'], $optionsText);
					    $optionsNumber = array( 'class' => 'form-control', 'step' => "0.01");
						echo Form::input( 'number', 'charge', $_POST['charge'], $optionsNumber, "Charge (Ah)");
						$optionsNumber = array( 'class' => 'form-control', 'step' => "0.1");
						echo Form::input( 'number', 'rendement', $_POST['rendement'], $optionsNumber, "Efficiency (%)");					
					?>					
					<button type="submit" class="btn btn-primary" value="Valider" name="envoyer" > Apply</button>
				</form>	
		
			</div>
        </div>

    </div>
	<?php require_once '../piedDePage.php'; ?>
</div>	
</body>
