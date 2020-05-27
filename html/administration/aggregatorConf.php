<?php
include "authentification/authcheck.php" ;

require_once('../ini/ini.php');
require_once('../definition.inc.php');

//------------si des données  sont reçues on les enregistrent dans le fichier configuration.ini ---------
if( !empty($_POST['envoyer'])){

    //  lecture du fichier de configuration
    $array  = parse_ini_file(CONFIGURATION, true);

	//  Modification des valeurs pour la section [thingSpeak]
	$array['Aggregator'] = array (
								  'mesuresKey' => $_POST['mesuresKey'],
								  'batteryKey' => $_POST['batteryKey'],
								  'server1'    => $_POST['server1'],
								  'server2'    => $_POST['server2']
	                             );

    //  Ecriture du fichier de configuration modifié
    $ini = new ini (CONFIGURATION);
    $ini->ajouter_array($array);
    $ini->ecrire(true);

}

// -------------- sinon lecture du fichier de configuration  -----------------------------


   $ini  = parse_ini_file(CONFIGURATION, true);

   $_POST['mesuresKey'] = $ini['Aggregator']['mesuresKey'];
   $_POST['batteryKey'] = $ini['Aggregator']['batteryKey'];
   $_POST['server1']    = $ini['Aggregator']['server1'];
   $_POST['server2']    = $ini['Aggregator']['server2'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Settings Aggregators</title>
    <!-- Bootstrap CSS version 4.1.1 -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/ruche.css" />

    <script src="../scripts/jquery.min.js"></script>
    <script src="../scripts/bootstrap.min.js"></script> 


    <script>
	    function affiche(event){
			
			var url = $(this).attr("href");
			console.log(url);
			
			$.getJSON( url , function( data, status, error ) {
				console.log(data.channel);
				var contenu = "<ul>";
				$.each( data.channel, function( key, val ) {
					if (key.indexOf("field") != -1){
						contenu += '<li>' + key +  ' : <a href="/thingSpeakView.php?channel=' + data.channel.id + '&fieldP=' + key.substring(5,6) + '">'  + val + "</a></li>";
					}	
				});
				contenu += "</ul>";
				
				$("#modal-contenu").html( contenu );
				var title = data.channel.id + " : " + data.channel.name; 
				console.log(title);
				$("#ModalLongTitle").html( title );
				$("#ModalCenter").modal('show');
			});
			
			event.preventDefault();   // bloque l'action par défaut sur le lien cliqué
		}
	
	    $(document).ready(function(){

			$(".channels").click(affiche);
		});
    </script>

</head>
<body>

<?php require_once '../menu.php'; ?>

<div class="container" style="padding-top: 65px;">

			
					
					
					<div class="row">
					    
						<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="popin">
						    <h2>Settings Aggregator</h2>
							<form class="form-horizontal" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="configuration" >
								<div class="form-group">
									<label for="offset" class="font-weight-bold">Aggregator 1 : </label>
									<input id="offset" type="text"  name="server1" class="form-control" <?php echo 'value="' . $_POST['server1'] . '"'; ?> />
								</div>
								
								<div class="form-group">
									<label for="offset" class="font-weight-bold">Aggregator 2 : </label>
									<input id="offset" type="text"  name="server2" class="form-control" <?php echo 'value="' . $_POST['server2'] . '"'; ?> />
								</div>
							
								<div class="form-group">
									<label for="offset" class="font-weight-bold">Mesures Key : </label>
									<input id="offset" type="text"  name="mesuresKey" class="form-control" <?php echo 'value="' . $_POST['mesuresKey'] . '"'; ?> />
								</div>
								<div class="form-group">
									<label for="offset" class="font-weight-bold">Battery Key : </label>
									<input id="offset" type="text"  name="batteryKey" class="form-control" <?php echo 'value="' . $_POST['batteryKey'] . '"'; ?> />
										
								</div>
								<div class="form-group">
									</br>
									<button type="submit" class="btn btn-primary" value="Valider" name="envoyer" > Apply</button>
								</div>
							</form>
					    </div>
						</div>
						
						<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="popin">
							<h2>Settings Aggregator  </h2>
							<p> Enter your user key API </p>
						</div>
						</div>
					</div>
					
			

		<?php require_once '../piedDePage.php'; ?>
</div>
		
</body>
