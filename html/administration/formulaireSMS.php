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
            
            $(document).ready(function(){
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
                
				
				$("#envoyer").click(function(){
					console.log("Bouton envoyer cliqué");
					var form_data = $("#formSMS").serialize();
					var post_url = $("#formSMS").attr("action");
					console.log(post_url);
					
					$.getJSON( post_url , form_data,function( response,status, error ) {
						console.log("status : " + status);
						console.log(response);
						console.log(error);
						if (response.status == "202 Accepted")
							window.alert("message envoyé");
						else
							window.alert(response.message + "\n" + response.detail);
						
						
					});
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
								<input type="text" id="key" name="key" size="26" required /><br />
							</div>
							<div class="form-group">
								<label for="number" class="font-weight-bold">Number : </label>
								<input type="text" id="number" name="number" size="10" required /><br />
							</div>
							<div class="form-group">    
								<label for="message" class="font-weight-bold">Message : </label>
								<textarea class="form-control" rows="5" id="message" name="message"></textarea>
							</div>
						</form>
						<br />
						<button  class="btn btn-primary" value="Valider" id="envoyer" > Envoyer</button>
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
    </body>
</html>
