<?php
include "authentification/authcheck.php" ;


require_once('../ini/ini.php');
require_once('../definition.inc.php');

$ini  = parse_ini_file(CONFIGURATION, true);

if (isset($_GET['serveurBD']) && $_GET['serveurBD']=="distante"){
	$host   = $ini['BDdistante']['host'];
	$user   = $ini['BDdistante']['user'];
	$passwd = $ini['BDdistante']['passwd'];
	$bdd    = $ini['BDdistante']['bdd'];
}
else{
	$host   = $ini['BDlocale']['host'];
	$user   = $ini['BDlocale']['user'];
	$passwd = $ini['BDlocale']['passwd'];
	$bdd    = $ini['BDlocale']['bdd'];

}

// connexion au serveur de la base de données


	try
	{
		$bdd = new PDO('mysql:host=' . $host . ';dbname=' . $bdd, $user, $passwd);
	}
	catch (Exception $ex)
	{
		die('<br />Pb connexion serveur BD : ' . $ex->getMessage());
	}


	$sql = "SELECT * FROM `feeds` WHERE `id_channel`=" . $ini['ruche']['id'];
    $nom_fichier = "channel_". $ini['ruche']['id'] . ".csv";

    header('Content-Type: application/csv-tab-delimited-table');
    header('Content-Disposition:attachment;filename='.$nom_fichier);

	$stmt = $bdd->query($sql);
	while ($data = $stmt->fetchObject()){
			echo $data->date.",";
			echo $data->field1.",";
			echo $data->field2.",";
			echo $data->field3.",";
			echo $data->field4.",";
			echo $data->field5.",";
			echo $data->field6.",";
			echo $data->field7.",";
			echo $data->field8."\n";
	}



