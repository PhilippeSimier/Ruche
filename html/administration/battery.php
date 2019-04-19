<?php


include "authentification/authcheck.php" ;

require_once('../ini/ini.php');
require_once('../definition.inc.php');

//------------si des données  sont reçues on les enregistrent dans le fichier battery.ini ---------
if( !empty($_POST['envoyer'])){

    //  lecture du fichier de configuration
    $array  = parse_ini_file(BATTERY, true);
    //  Modification des valeurs pour la section [balance]
    $array['battery'] = array ('capacite'  => $_POST['capacite'],
                               'charge' => $_POST['charge'],
							   'type'  => $_POST['type'],
							   'time' => $_POST['time']
                               );

    //  Ecriture du fichier de configuration modifié
    $ini = new ini (BATTERY);
    $ini->ajouter_array($array);
    $ini->ecrire(true);

}

// -------------- sinon lecture du fichier de configuration section battery -----------------------------
else
{
   $ini  = parse_ini_file(BATTERY, true);
   $_POST['capacite'] = $ini['battery']['capacite'];
   $_POST['charge']  = $ini['battery']['charge'];
   $_POST['type']     = $ini['battery']['type'];
   $_POST['time']     = $ini['battery']['time'];   
  
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Battery</title>
    <!-- Bootstrap CSS version 4.1.1 -->
    <link rel="stylesheet" href="/Ruche/css/bootstrap.min.css">
	<link rel="stylesheet" href="/Ruche/css/ruche.css" />
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="/Ruche/scripts/bootstrap.min.js"></script>     
    

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
			setInterval(requete_ajax, 10000);  // appel de la fonction requete_ajax toutes les 10 secondes
		   
		});
	</script>

</head>
<body>
	<?php require_once '../menu.php'; ?>
	<div class="container" style="padding-top: 65px;" >
	
	
	
	<div class="row" >
        
	    <div class="col-md-6">
			<div class="popin">
					<div class="row">
					    <div class="col-sm-6"><h3>Tension :</h3></div>
						<div class="col-sm-6"><h3><span id="tension"></span></h3></div>
					</div>
					<div class="row">
					    <div class="col-sm-6"><h3>Courant :</h3></div>
						<div class="col-sm-6"><h3><span id="courant"></span></h3></div>
					</div>
					<div class="row">
					    <div class="col-sm-6"><h3>Puissance :</h3></div>
						<div class="col-sm-6"><h3><span id="puissance"></span></h3></div>
					</div>
					<div class="row">
					    <div class="col-sm-6"><h3>Taux de charge :</h3></div>
						<div class="col-sm-6"><h3><span id="soc"></span></h3></div>
					</div>
			</div>
	    </div>
		
		<div class="col-md-6">
            <div class="popin">
            <h2>Battery</h2>
		        <form class="form-horizontal" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="configuration" >
					<input type='hidden' name='time' <?php echo 'value="' . $_POST['time'] . '"'; ?> />	

					<div class="form-group">
						<label for="tension"  class="font-weight-bold">Capacité (Ah) : </label>
						<input type="int"  name="tension" class="form-control" <?php echo 'value="' . $_POST['capacite'] . '"'; ?> />
					</div>

					<div class="form-group">
						<label for="type"  class="font-weight-bold">Type : </label>
						<input id="type" type="text"  name="type" class="form-control" <?php echo 'value="' . $_POST['type'] . '"'; ?> />
					</div>

					<div class="form-group">
						<label for="capacite"  class="font-weight-bold">Charge (Ah) : </label>
						<input type="int"  name="capacite" class="form-control" <?php echo 'value="' . $_POST['charge'] . '"'; ?> />
					</div>
					
					<button type="submit" class="btn btn-primary" value="Valider" name="envoyer" > Appliquer</button>
				</form>	
		
			</div>
        </div>

    </div>
	<?php require_once '../piedDePage.php'; ?>
</div>	
</body>
