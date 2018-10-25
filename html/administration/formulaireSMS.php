<?php
include "authentification/authcheck.php" ;

require_once('../ini/ini.php');
require_once('../definition.inc.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Envoyer un SMS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

	
		<link rel="stylesheet" href="/css/ruche.css" />
		<link rel="stylesheet" href="/css/bootstrap.min.css">
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="/scripts/bootstrap.min.js"></script>
		
        
        <script type="text/javascript">
            
            function affiche( data ) {               // fonction pour afficher les données reçues
                console.log(data.level);                   // affichage de data dans la console
                $('#level').text(data.level);
            }
			
			// Surcharge de la méthode alert 
			window.alert = function(alertMessage)
			{
				console.log(alertMessage); 
				// ici on insère dans notre page html notre div gris
				$("#customPopup").before('<div id="grayBack"></div>');
 
				// maintenant, on récupère la largeur et la hauteur de notre popup
				var popupH = $("#customPopup").height();
				var popupW = $("#customPopup").width();
 
				// ensuite, on crée des marges négatives pour notre popup, chacune faisant
				// la moitié de la largeur/hauteur du popup
				$("#customPopup").css("margin-top", "-"  + (popupH / 2  + 40) +  "px");
				$("#customPopup").css("margin-left", "-" +  popupW / 2 +  "px");
 
				// enfin, on fait apparaître en 300 ms notre div gris de fond, et une fois
				// son apparition terminée, on fait apparaître en fondu notre popup
				$("#grayBack").css('opacity', 0).fadeTo(300, 0.5, function () { $("#customPopup").fadeIn(500); });
			
				$("#alertPanel").text(alertMessage);
			}

			function hidePopup() {
				// on fait disparaître le gris de fond rapidement
				$("#grayBack").fadeOut('fast', function () { $(this).remove() });
				// on fait disparaître le popup à la même vitesse
				$("#customPopup").fadeOut('fast', function () { $(this).hide() });
			}
            
            $(document).ready(function(){
                // Requete AJAX pour afficher le niveau du signal
				$.getJSON("/administration/getLevelSignal.php", affiche);
				
				// A function to run if the request fails.
				$.ajaxSetup({
					error: function (x, status, error) {
						if (x.status == 500) {
							window.alert("Sorry, error 500");
							
						}
						else {
							window.alert("message : " + error);
						}
					}
				});
                
				
								
				$( "#formSMS" ).submit(function( event ) {
					//alert( "Handler for .submit() called." );
					var form_data = $(this).serialize();
					console.log(form_data);
					var post_url = $(this).attr("action");
					console.log(post_url);
					
					$.getJSON( post_url , form_data, function( response,status, error ) {
						console.log("status : " + status);
						console.log(response);
						console.log(error);
						if (response.status == "202 Accepted")
							alert("message envoyé");
						else
							alert(response.message + "\n" + response.detail);
						
						
					});
					event.preventDefault();
				});
				
						
				
			});
			
			
			
        
        </script>
    
    </head>
    
    <body>
	
		<?php require_once '../menu.php'; ?>
	
        <div class="container" style="padding-top: 65px;">
			<div class="row">
				
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="popin">
						<h2>Send a SMS</h2>
						<hr>
						<form class="form-horizontal" method="post"  id="formSMS" action="sendSMS.php">
							<div class="form-group">
								<label for="key" class="font-weight-bold">Key : </label>
								<input type="text" id="key" name="key" size="26" placeholder="Enter Key here" required /><br />
							</div>
							<div class="form-group">
								<label for="number" class="font-weight-bold">Number : </label>
								<input type="text" id="number" name="number" size="10" placeholder="Number" required pattern="\d+" /><br />
							</div>
							<div class="form-group">    
								<label for="message" class="font-weight-bold">Message : </label>
								<textarea class="form-control" rows="5" id="message" name="message" maxlength="160" required></textarea>
							</div>
							<br />
							<button  type="submit" class="btn btn-primary" value="soumettre" id="b2" > Envoyer</button>
						</form>
						<br />
						
					</div>
				    
				</div>
				
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="popin">
						<h2>Level Network Signal</h2>
						<hr>
						<span id="level"></span>
					</div>	
				</div>
			</div> 
			<?php require_once '../piedDePage.php'; ?>
        </div>
		<!-- Div  pour afficher les messages en retour-->
			<div id="customPopup">
				<h3></h3>
					<p id="alertPanel">Message !</p>
					<p> </p>
					<button type="button" class="btn btn-info" onclick="hidePopup();">OK</button>
						
		</div>
    </body>
</html>
