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
        
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
		<link rel="stylesheet" href="../css/ruche.css" />
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="../scripts/bootstrap.min.js"></script>
		
        
        <script type="text/javascript">
            
            function afficheLevel( data ) {               // fonction pour afficher le niveau du signal réseau
                console.log(data.level);             
                $('#level').text(data.level);
            }
			
            
            $(document).ready(function(){
                // Requete AJAX pour afficher le niveau du signal
				$.getJSON("getLevelSignal.php", afficheLevel);
				
				// A function to run if the request fails.
				$.ajaxSetup({
					error: function (x, status, error) {
						
						//window.alert("message : " + error);
						$( "#modal-contenu" ).html( "<p>Sorry error : <em>" + error + "</em></p>" );
						$('#ModalCenter').modal('show');
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
						if (response.status == "202 Accepted"){
							//alert("message envoyé");
							$( "#modal-contenu" ).html( "<p>Message envoyé. <em>avec succès !</em></p>" );
							$('#ModalCenter').modal('show');
						}	
						else{
							//alert(response.message + "\n" + response.detail);
							$( "#modal-contenu" ).html( "<p>" + response.message + " <em>" + response.detail + "</em></p>" );
							$('#ModalCenter').modal('show');
						}
						
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
				
				<div class="col-md-6 col-sm-12 col-xs-12">
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
				
				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="popin">
						<h2>Level Network Signal</h2>
						<hr>
						<span id="level"></span>
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
