<?php
include "authentification/authcheck.php" ;

require_once('../ini/ini.php');
require_once('../definition.inc.php');

//------------si des données  sont reçues on les enregistrent dans le fichier configuration.ini ---------
if( !empty($_POST['envoyer'])){

    //  lecture du fichier de configuration
    $array  = parse_ini_file(CONFIGURATION, true);
    //  Modification des valeurs pour la section [ruche]
 
	//  Modification des valeurs pour la section [BDlocale]
	$array['BDlocale'] = array ('host'  => $_POST['BDlocale_host'],
                                'user' => $_POST['BDlocale_user'],
							    'passwd' => $_POST['BDlocale_passwd'],
								'bdd' => $_POST['BDlocale_bdd'],
                               );
	//  Modification des valeurs pour la section [BDdistante]
	$array['BDdistante'] = array ('host'  => $_POST['BDdistante_host'],
                                'user' => $_POST['BDdistante_user'],
								'passwd' => $_POST['BDdistante_passwd'],
							    'bdd' => $_POST['BDdistante_bdd'],
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
     
   $_POST['BDlocale_host'] = $ini['BDlocale']['host'];
   $_POST['BDlocale_user'] = $ini['BDlocale']['user'];
   $_POST['BDlocale_passwd'] = $ini['BDlocale']['passwd'];
   $_POST['BDlocale_bdd'] = $ini['BDlocale']['bdd'];
   
   $_POST['BDdistante_host'] = $ini['BDdistante']['host'];
   $_POST['BDdistante_user'] = $ini['BDdistante']['user'];
   $_POST['BDdistante_passwd'] = $ini['BDdistante']['passwd'];
   $_POST['BDdistante_bdd'] = $ini['BDdistante']['bdd'];
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Configuration</title>
    <!-- Bootstrap CSS version 4.1.1 -->
	
    <link rel="stylesheet" href="../css/ruche.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="../scripts/bootstrap.min.js"></script>
    
		
</head>
<body>

<?php require_once '../menu.php'; ?>

<div class="container" style="padding-top: 65px;">
    

		<form class="form-horizontal" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="configuration" >
		<div class="row">

			
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="popin">
				<h2>Bdd locale</h2>
					
						<div class="form-group">
							<label for="BDlocale_host" class="font-weight-bold">Host : </label>
							<input id="BDlocale_host" type="int"  name="BDlocale_host" class="form-control" <?php echo 'value="' . $_POST['BDlocale_host'] . '"'; ?> />
						</div>

						<div class="form-group">
							<label for="BDlocale_user" class="font-weight-bold">Utilisateur : </label>
							<input id="BDlocale_user" type="int"  name="BDlocale_user" class="form-control" <?php echo 'value="' . $_POST['BDlocale_user'] . '"'; ?> />
						</div>
						
						<div class="form-group">
							<label for="BDlocale_passwd" class="font-weight-bold">Mot de passe : </label>
							<input id="BDlocale_passwd" type="int"  name="BDlocale_passwd" class="form-control" <?php echo 'value="' . $_POST['BDlocale_passwd'] . '"'; ?> />
						</div>
						
						<div class="form-group">
							<label for="BDlocale_bdd" class="font-weight-bold">Bdd : </label>
							<input id="BDlocale_bdd" type="int"  name="BDlocale_bdd" class="form-control" <?php echo 'value="' . $_POST['BDlocale_bdd'] . '"'; ?> />
						</div>
						<br />
						<a  class="btn btn-info" role="button" href="/phpmyadmin/">phpMyAdmin local</a>
						<a  class="btn btn-info" role="button" href = "export_csv.php?serveurBD=locale">Download CSV</a>
						<button type="submit" class="btn btn-primary" value="Valider" name="envoyer" > Appliquer</button>
								
				</div>
			</div>	
				
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="popin">
				<h2>Bdd distante</h2>
					
						<div class="form-group">
							<label for="scale" class="font-weight-bold">Host : </label>
							<input type="int"  name="BDdistante_host" class="form-control" <?php echo 'value="' . $_POST['BDdistante_host'] . '"'; ?> />
						</div>

						<div class="form-group">
							<label for="BDdistante_user" class="font-weight-bold">Utilisateur : </label>
							<input id="BDdistante_user" type="int"  name="BDdistante_user" class="form-control" <?php echo 'value="' . $_POST['BDdistante_user'] . '"'; ?> />
						</div>
						
						<div class="form-group">
							<label for="BDdistante_passwd" class="font-weight-bold">Mot de passe : </label>
							<input id="BDdistante_passwd" type="int"  name="BDdistante_passwd" class="form-control" <?php echo 'value="' . $_POST['BDdistante_passwd'] . '"'; ?> />
						</div>
						
						<div class="form-group">
							<label for="BDdistante_bdd" class="font-weight-bold">Bdd : </label>
							<input id="BDdistante_bdd" type="int"  name="BDdistante_bdd" class="form-control" <?php echo 'value="' . $_POST['BDdistante_bdd'] . '"'; ?> />
						</div>
						<br />
						<a class="btn btn-info" role="button" <?php echo 'href="http://' . $_POST['BDdistante_host'] . '/phpmyadmin/"'; ?>>phpMyAdmin distant</a>
						<a class="btn btn-info" role="button" href = "export_csv.php?serveurBD=distante">Download CSV</a>
						<button type="submit" class="btn btn-primary" value="Valider" name="envoyer" > Appliquer</button>
				</div>
			</div>
		
		</div>
		<div class="row">
			
		</div>
		</form>
		<?php require_once '../piedDePage.php'; ?>
</div>
	
</body>

	
		