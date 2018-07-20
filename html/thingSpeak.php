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
	                             );
						   
    //  Ecriture du fichier de configuration modifié
    $ini = new ini (CONFIGURATION);
    $ini->ajouter_array($array);
    $ini->ecrire(true);

}

// -------------- sinon lecture du fichier de configuration  -----------------------------
else
{
   $ini  = parse_ini_file(CONFIGURATION, true);
     
   $_POST['thingSpeak_channel'] = $ini['thingSpeak']['channel'];
   $_POST['thingSpeak_key'] = $ini['thingSpeak']['key'];
 
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Configuration</title>
    <!-- Bootstrap CSS version 4.1.1 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="scripts/bootstrap.min.js"></script> -->
    <link rel="stylesheet" href="/css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/ruche.css" />

    <!-- Style pour la boite (div id popin) coins arrondis bordure blanche ombre -->
        <style type="text/css">

		.h1 {
			font-size: 80px;
		}

		</style>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
							<label for="scale">Channel : </label>
							<input type="int"  name="thingSpeak_channel" class="form-control" <?php echo 'value="' . $_POST['thingSpeak_channel'] . '"'; ?> />
						</div>

						<div class="form-group">
							<label for="offset">Key : </label>
							<input id="offset" type="int"  name="thingSpeak_key" class="form-control" <?php echo 'value="' . $_POST['thingSpeak_key'] . '"'; ?> />
						</div>
	
				</div>
			</div>	
		</div>

		<div class="row">
			<button type="submit" class="btn btn-primary" value="Valider" name="envoyer" > Appliquer</button>
		</div>
		</form>
		<?php require_once 'piedDePage.php'; ?>
</div>
	
</body>

	
		