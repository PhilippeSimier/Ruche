<?php
require_once('ini/ini.php');
require_once('definition.inc.php');

//------------si des données  sont reçues on les enregistrent dans le fichier configuration.ini ---------
if( !empty($_POST['envoyer'])){

    //  lecture du fichier de configuration
    $array  = parse_ini_file(CONFIGURATION, true);
    //  Modification des valeurs pour la section [ruche]
 
	//  Modification des valeurs pour la section [thingSpeak]
	$array['thingSpeak'] = array ('channel'  => $_POST['thingSpeak_channel'],
                                  'key' => $_POST['thingSpeak_key'],
								  'userkey' => $_POST['thingSpeak_userkey']
	                             );
						   
    //  Ecriture du fichier de configuration modifié
    $ini = new ini (CONFIGURATION);
    $ini->ajouter_array($array);
    $ini->ecrire(true);
    
}

// -------------- sinon lecture du fichier de configuration  -----------------------------


   $ini  = parse_ini_file(CONFIGURATION, true);
     
   $_POST['thingSpeak_channel'] = $ini['thingSpeak']['channel'];
   $_POST['thingSpeak_key'] = $ini['thingSpeak']['key'];
   $_POST['thingSpeak_userkey'] = $ini['thingSpeak']['userkey'];
 


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Configuration thing speak</title>
    <!-- Bootstrap CSS version 4.1.1 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="scripts/bootstrap.min.js"></script> -->
    <link rel="stylesheet" href="/css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/ruche.css" />
    <script>
	    function affiche( data, status ) {               // fonction pour afficher les données reçues
			console.log(data);
			console.log(status);
			if (status == 'success'){
				$('input[name=name]').val(data.name);
				$('input[name=name]').attr('readonly', true);
				$('#channel_description').text(data.description);
				//$('#channel_description]').attr('readonly', true);
				$('input[name=latitude]').val(data.latitude);
				$('input[name=latitude]').attr('readonly', true);
				$('input[name=longitude]').val(data.longitude);
				$('input[name=longitude]').attr('readonly', true);
				$('input[name=elevation]').val(data.elevation);
				$('input[name=elevation]').attr('readonly', true);
				var date_creation = new Date(data.created_at);
				$('input[name=created_at]').val(date_creation.toLocaleString('fr-FR', { timeZone: 'UTC' }));
				$('input[name=created_at]').attr('readonly', true);
			}
		}
		
		$(document).ready(function(){
		
			$.get("https://api.thingspeak.com/channels/<?php echo $ini['thingSpeak']['channel']; ?>.json?api_key=<?php echo $ini['thingSpeak']['userkey']; ?>", affiche);
		});
    </script>
	
</head>
<body>

<?php require_once 'menu.php'; ?>

<div class="container" style="padding-top: 35px;">
    

		<form class="form-horizontal" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="configuration" >
		<div class="row">

			
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="popin">
				<h2>Thing Speak</h2>
					
						<div class="form-group">
							<label for="offset" class="font-weight-bold">User API Key : </label>
							<input id="offset" type="int"  name="thingSpeak_userkey" class="form-control" <?php echo 'value="' . $_POST['thingSpeak_userkey'] . '"'; ?> />
						</div>
												
						<div class="form-group">
						
							<label for="thingSpeak_channel" class="font-weight-bold">Channel ID : </label>
							<input id="thingSpeak_channel" type="int"  name="thingSpeak_channel" class=" form-control" <?php echo 'value="' . $_POST['thingSpeak_channel'] . '"'; ?> />
						</div>

						<div class="form-group">
							<label for="offset" class="font-weight-bold">Write API Key : </label>
							<input id="offset" type="int"  name="thingSpeak_key" class="form-control" <?php echo 'value="' . $_POST['thingSpeak_key'] . '"'; ?> />
						</div>
						
						
						
						<div class="form-group">
							</br>
							<button type="submit" class="btn btn-primary" value="Valider" name="envoyer" > Appliquer</button>
						</div>
				</div>
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="popin">
				<h2>Channel Settings</h2>
					
						<div class="form-group">
							<label for="name" class="font-weight-bold">Name: </label>
							<input name="name" class="form-control" value="" />
						</div>

						<div class="form-group">
							<label for="channel_description" class="font-weight-bold">Description : </label>
							<textarea class="form-control vertical_resize_only" id="channel_description" name="description" style="margin-top: 0px; margin-bottom: 0px; height: 63px;">
							</textarea>
						</div>
						
						<div class="form-group">
							<label for="latitude" class="font-weight-bold">Latitude : </label>
							<input name="latitude" class="form-control" value="" />
						</div>
						
						<div class="form-group">
							<label for="longitude" class="font-weight-bold">Longitude : </label>
							<input name="longitude" class="form-control" value="" />
						</div>
						
						<div class="form-group">
							<label for="elevation" class="font-weight-bold">Elevation : </label>
							<input name="elevation" class="form-control" value="" />
						</div>
						
						<div class="form-group">
							<label for="created_at" class="font-weight-bold">Date de création : </label>
							<input name="created_at" class="form-control" value="" />
						</div>
	
				</div>
			</div>	
		</div>

		
		</form>
		<?php require_once 'piedDePage.php'; ?>
</div>
	
</body>

	
		