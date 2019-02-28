<?php


	if(!isset($_POST['md5']))
	{
		header("Location: ../index.php");
		exit();
	}
	
	if(!isset($_POST['login']))
	{
		  header("Location: ../index.php");
		  exit();
	}

	if($_POST['login']==NULL)
	{
		  header("Location: ../index.php?&erreur=Requiert un identifiant et un mot de passe.");
		  exit();
	}


	require_once('../../ini/ini.php');
	require_once('../../definition.inc.php');
	
	$ini  = parse_ini_file(CONFIGURATION, true);
	
	// vérification des identifiants login et md5 par rapport à ceux enregistrés dans le fichier configuration.ini
	if (!($_POST['login'] == $ini['user']['login'] && $_POST['md5'] == $ini['user']['md5'])){
		header("Location: ../index.php?&erreur=Incorrectes! Vérifiez vos identifiant et mot de passe.");
  		exit();
	}

	// A partir de cette ligne l'utilisateur est authentifié
	// donc nouvelle session
	session_start();

	// écriture des variables de session pour cet utilisateur

        $_SESSION['last_access'] = time();
        $_SESSION['ipaddr']		 = $_SERVER['REMOTE_ADDR'];
        $_SESSION['login'] 		 = $ini['user']['login'];
        $_SESSION['droits'] 	 = 1;
       
	// sélection de la page de retour
	if ($_POST['retour']!== ""){
		header("Location: " . $_POST['retour'] );
		exit;
	}
	else{
		header("Location: ../../index.php");
		exit;
	}	
	

?>
