<?php
// page d'authentification pour la partie sécurisée du site
// cette page affiche un formulaire avec deux champs (login et passe)
// et un bouton pour soumettre au script auth.php

require_once('../definition.inc.php');

session_start();
unset($_SESSION['identite']);
unset($_SESSION['login']);
unset($_SESSION['ID_user']);
unset($_SESSION['email']);
unset($_SESSION['droits']);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Authentification</title>
    <!-- Bootstrap CSS version 4.1.1 -->
    <link rel="stylesheet" href="/Ruche/css/bootstrap.min.css">
	<link rel="stylesheet" href="/Ruche/css/ruche.css" />
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="/Ruche/scripts/bootstrap.min.js"></script> 
    

    <script  src="./authentification/login.js"></script>
</head>
<body>

	<?php require_once '../menu.php'; ?>

	<div class="container" style="padding-top: 65px;">
    

		<div class="row">
			
			<div  class="col-md-6 col-sm-6 col-xs-12">
				<div class="popin">
				<h2>Sign in to connected Beehive</h2>
				
				  <?php if (isset($_GET["erreur"])) echo '<p style="color: #ff0000;">'.$_GET["erreur"].'</p>';
						  
				   ?>
				
				<form method="POST" action="./authentification/auth.php" onSubmit="javascript:submit_pass();" name="form2" id="form2">
					<input type='hidden' name='md5' />
					<input type='hidden' name='retour' value="<?php if (isset($_GET["retour"])) echo $_GET["retour"]; ?>" />	
						<div class="form-group">
							<label for="login" class="font-weight-bold">User login :</label>
							<input type="text"  name="login" class="form-control"  required="">
						</div>
						
						<div class="form-group">
							<label for="password" class="font-weight-bold">Password :</label>
							<input type="password" name="passe" class="form-control" required="">
						</div>
						<br />
						<button type="submit" class="btn btn-primary" value="Valider" name="B1" > Valider</button>
								
				</form>
				</div>
			</div>
			
		</div>
		<?php require_once '../piedDePage.php'; ?>
	</div>
</body>	


