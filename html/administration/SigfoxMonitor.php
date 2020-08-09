<?php
include "authentification/authcheck.php" ;

require_once('../ini/ini.php');
require_once('../definition.inc.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sigfox - BRKWS01</title>
        <meta charset="UTF-8">
        
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
		<link rel="stylesheet" href="../css/ruche.css" />
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		
		<script src="../scripts/jquery.min.js"></script>
		<script src="../scripts/bootstrap.min.js"></script>
		
        
        <script type="text/javascript">
 		
		function affiche( data ) {               // fonction pour afficher les données reçues
			console.log(data);                   // affichage de data dans la console
			if (data.test){
				$('#test').text(data.test);
				$('#Sigfox_ID').text(data.Sigfox_ID);
				$('#PAC').text(data.PAC);
				$('#Freq_emi').text(data.Freq_emi + " MHz") ;
				$('#Freq_rec').text(data.Freq_rec + " MHz") ;
				$('#Tension0').text(data.Tension0 + " V") ;
				$('#Tension1').text(data.Tension1 + " V") ;
				$('#Temp').text(data.Temp + " °C") ;
				
			}
		}

		function requete_ajax(){
			// requete Ajax méthode getJSON
			$.getJSON(
				"/cgi-bin/deviceSigfox", // Le fichier cible côté serveur. data au format Json
				affiche
			);
		}
		
		$(document).ready(function(){
		   	requete_ajax();   // execution de la fonction requete_ajax		
		});
		
        </script>
    
    </head>
    
    <body>
	
		<?php require_once '../menu.php'; ?>
	
        <div class="container" style="padding-top: 65px;">
			<div class="row">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="popin">
						<h2>Monitor Transmitter Sigfox </h2>
						<ul>
						<li> Test :      <span id="test" style="font-size: x-large; font-weight: bold;"></span></li>
						<li> Sigfox ID : <span id="Sigfox_ID" style="font-size: x-large; font-weight: bold;"></span></li>
						<li> PAC :       <span id="PAC" style="font-size: x-large; font-weight: bold;"></span></li>
						<li> Fréquence Emission :       <span id="Freq_emi" style="font-size: x-large; font-weight: bold;"></span></li>
						<li> Fréquence Reception :      <span id="Freq_rec" style="font-size: x-large; font-weight: bold;"></span></li>
						<li> Tension d'alimentation :   <span id="Tension0" style="font-size: x-large; font-weight: bold;"></span></li>
						<li> Tension émission :         <span id="Tension1" style="font-size: x-large; font-weight: bold;"></span></li>
						<li> Température interne :      <span id="Temp"     style="font-size: x-large; font-weight: bold;"></span></li>
						</ul>
					</div>	
				</div>
			</div> 
			<?php require_once '../piedDePage.php'; ?>
        </div>
		
		<!-- Modal -->
		<div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenter" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="ModalLongTitle">Message !</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body" id="modal-contenu">
				...
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
		
    </body>
</html>
