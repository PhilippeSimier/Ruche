<?php
// https://www.mt.com/mt_ext_files/Editorial/Generic/4/Operator_Manual_IND425_Editorial-Generic_1102076714093_files/22011482A.pdf

include "authentification/authcheck.php" ;

require_once('../ini/ini.php');
require_once('../definition.inc.php');

//------------si des données  sont reçues on les enregistrent dans le fichier configuration.ini ---------
if( !empty($_POST['envoyer'])){

    //  lecture du fichier de configuration
    $array  = parse_ini_file(CONFIGURATION, true);
    //  Modification des valeurs pour la section [balance]
    $array['balance'] = array ('scale'  => $_POST['scale'],
                               'offset' => $_POST['offset'],
                               'gain'   => $_POST['gain'],
							   'unite'  => $_POST['unite'],
                               'precision' => $_POST['precision'],
							   'slope'  => $_POST['slope'],
							   'tempRef' => $_POST['tempRef']);

    //  Ecriture du fichier de configuration modifié
    $ini = new ini (CONFIGURATION);
    $ini->ajouter_array($array);
    $ini->ecrire(true);

}

// -------------- sinon lecture du fichier de configuration section balance -----------------------------
else
{
   $ini  = parse_ini_file(CONFIGURATION, true);
   $_POST['unite'] = $ini['balance']['unite'];
   $_POST['gain']  = $ini['balance']['gain'];
   $_POST['offset'] = $ini['balance']['offset'];
   $_POST['precision'] = $ini['balance']['precision'];
   $_POST['scale'] = $ini['balance']['scale'];
   $_POST['slope'] = $ini['balance']['slope'];
   $_POST['tempRef'] = $ini['balance']['tempRef'];
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Conf. Balance</title>
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
		var  enable = true;
		function affiche( data ) {               // fonction pour afficher les données reçues
				//console.log(data);                   // affichage de data dans la console
			if (enable && data.success){
				$('#Weight').text(data.Weight + ' ' + data.unite);
			}
		}

		function requete_ajax(){
			// requete Ajax méthode getJSON
			if (enable){
				
				$.getJSON(
					"/cgi-bin/balanceJson", // Le fichier cible côté serveur. data au format Json
					affiche
				);
			}
		}

		$(document).ready(function(){
		   	$.getJSON("/cgi-bin/balanceJson", affiche); // affichage des données quand la page est dispo
			setInterval(requete_ajax, 1200);  // appel de la fonction requete_ajax toutes les 10 secondes

			$("#zero").click(function(){
					
				if (confirm("Confirmez-vous la correction de zéro ?")) { 
					enable = false;
					$('#Weight').text("RAZ");
					$.getJSON("/cgi-bin/tarageCGI", function(data){
						console.log(data);
						if(data.success == true){
							enable = true;
							$('input[name=offset]').val(data.offset);
							$('input[name=offset]').css("backgroundColor", "#00ff00");
						}
						else{
							window.alert(data.error);
						}	
							
					});
				}
			});
			   
			   $("#calibrage").click(function(){
					var poids = prompt('Donnez la valeur du poids étalon','poids');
					enable = false;
					$('#Weight').text("Calibrage");
					console.log(poids);
					$.post("/cgi-bin/scaleCGI",
					{
					valeur: poids,
					},
					function(data, status){
						if(data.success == true){
							enable = true;
							$('input[name=scale]').val(data.scale);
							$('input[name=scale]').css("backgroundColor", "#00ff00");
							}
							else{
								window.alert(data.error);
							}
					});
					
				});	
			   
			});
	</script>

</head>
<body>
	<?php require_once '../menu.php'; ?>
	<div class="container" style="padding-top: 65px;" >
	
	
	
	<div class="row" >
        
	    <div class="col-md-6">
            <div class="popin">
                <h1 class="h1"><span id="Weight"></span></h1>
            </div>
			<div class="popin">
			<button class="btn btn-primary" value="zero" name="zero" id="zero">  Remise à zéro </button>
			<button class="btn btn-primary" value="calibrage" name="calibrage" id="calibrage"> Calibrage </button>
			</div>
	    </div>
		
		<div class="col-md-6">
            <div class="popin">
            <h2>Configuration de la balance</h2>
		        <form class="form-horizontal" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="configuration" >

					<div class="form-group">
						<label for="scale"  class="font-weight-bold">Scale : </label>
						<input type="int"  name="scale" class="form-control" <?php echo 'value="' . $_POST['scale'] . '"'; ?> />
					</div>

					<div class="form-group">
						<label for="offset"  class="font-weight-bold">Offset : </label>
						<input id="offset" type="int"  name="offset" class="form-control" <?php echo 'value="' . $_POST['offset'] . '"'; ?> />
					</div>

					<div class="form-group">
						<label for="gain"  class="font-weight-bold">Gain : </label>
						<div class="form-check-inline">
							<input class="form-check-input" type="radio" <?php if (isset($_POST['gain']) && $_POST['gain']=='128') echo 'checked="checked"' ?> name="gain"  value="128" id="128"/> 
							<label class="form-check-label" for="128"> 128 </label>
						</div>
						<div class="form-check-inline">
							<input class="form-check-input" type="radio" <?php if (isset($_POST['gain']) && $_POST['gain']=='64')  echo 'checked="checked"' ?> name="gain"  value="64" id="64"/>
							<label class="form-check-label" for="64"> 64 </label>
						</div>
					</div>

					<div class="form-group">
						<label for="unite"  class="font-weight-bold">Unite : </label>
						<input type="int"  name="unite" class="form-control" <?php echo 'value="' . $_POST['unite'] . '"'; ?> />
					</div>
					<div class="form-group">
						<label for="Precision"  class="font-weight-bold">Division : </label>
						<div class="form-check-inline">
							<input class="form-check-input" type="radio" id="0" <?php if (isset($_POST['precision']) && $_POST['precision']=='0') echo 'checked="checked"' ?> name="precision"  value="0" />
							<label class="form-check-label" for="0"> 1 </label>
						</div>
						<div class="form-check-inline">
							<input class="form-check-input" type="radio" id="1" <?php if (isset($_POST['precision']) && $_POST['precision']=='1') echo 'checked="checked"' ?> name="precision"  value="1" />
							<label class="form-check-label" for="1"> 1/10 </label>
						</div>
						<div class="form-check-inline">	
							<input class="form-check-input" type="radio" id="2" <?php if (isset($_POST['precision']) && $_POST['precision']=='2') echo 'checked="checked"' ?> name="precision"  value="2" />
							<label class="form-check-label" for="2"> 1/100 </label>
							<!-- <label for="unite">Précision : </label> <input type="int"  name="precision" class="form-control" <?php echo 'value="' . $_POST['precision'] . '"'; ?> /> -->
						</div>
					</div>
					<div class="form-group">
						<label for="slope"  class="font-weight-bold">Slope : </label>
						<input type="text"  name="slope" class="form-control" <?php echo 'value="' . $_POST['slope'] . '"'; ?> />
					</div>
					<div class="form-group">
						<label for="tempRef"  class="font-weight-bold">Temperature Reference : </label>
						<input type="text"  name="tempRef" class="form-control" <?php echo 'value="' . $_POST['tempRef'] . '"'; ?> />
					</div>

					<button type="submit" class="btn btn-primary" value="Valider" name="envoyer" > Appliquer</button>
				</form>	
		
			</div>
        </div>

    </div>
	<?php require_once '../piedDePage.php'; ?>
</div>	
</body>
