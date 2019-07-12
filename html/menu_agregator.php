<!----------------------------------------------------------------------------------
    @fichier  menu.php							    		
    @auteur   Philippe SIMIER (Touchard Washington le Mans)
    @date     Juillet 2018
    @version  v1.1 - First release						
    @details  menu /Menu pour toutes les pages du site ruche 
------------------------------------------------------------------------------------>
<?php 
    require_once('definition.inc.php');
    $ini  = parse_ini_file(CONFIGURATION, true);
?>

	<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" href="/Ruche/">
			<img alt="Beehive logo" height="30" id="nav-Beehive-logo" src="/Ruche/images/beehive_logo.png" style="padding: 0 8px; ">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		
		
		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
        
		<ul class="navbar-nav mr-auto">
			
			<li class="nav-item">
				<a class="nav-link" href="/Ruche/accueil" id="nav-sign-in">Browse Sites</a>
			</li>					
			<li class="nav-item">
				<a class="nav-link" href="/Ruche/webcam" id="nav-sign-in">Webcam</a>
			</li>	
        </ul>
		
		<!-- Menu à droite -->
		<ul class="navbar-nav navbar-right" style="margin-right: 78px;">
			<li class="nav-item">
				
				<?php 
				if (!isset($_SESSION['login']))
					echo '<a class="nav-link" href="/Ruche/administration/" id="nav-sign-in">Sign In</a>';
				else{
					echo '<li class="nav-item dropdown">';
					
					echo '<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">';
						echo '<img alt="Avatar" height="30" id="nav-avatar-logo" src="/Ruche/images/icon-avatar.svg" style="padding: 0 10px; ">';
						echo $_SESSION['login']; 
					echo '</a>';
					echo '<div class="dropdown-menu">';
					echo '<a class="dropdown-item" href="/Ruche/administration/ruche">Beehive</a>';
					echo '<a class="dropdown-item" href="/Ruche/administration/balance">Scale</a>';
					echo '<a class="dropdown-item" href="/Ruche/administration/baseDeDonnees">Database</a>';
					echo '<a class="dropdown-item" href="/Ruche/administration/thingSpeakConf">Thing Speak</a>';
					echo '<a class="dropdown-item" href="/Ruche/administration/formulaireSMS">GSM</a>';
					echo '<a class="dropdown-item" href="/Ruche/administration/battery">Battery</a>';
					echo '<a class="dropdown-item" href="/Ruche/administration/infoSystem">System info</a>';
					echo '<a class="dropdown-item" href="/Ruche/administration/signout" id="nav-sign-in">Sign Out</a>';
					echo '</div>';
					echo '</li>';
				}	
				?>
			</li>
		</ul>
        
		</div>
    </nav>
	
	<!--Fenêtre Modal -->
		<div class="modal" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenter" aria-hidden="true">
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
			    <button type="button" class="btn btn-primary btn-afficher">Afficher</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
		
	<script>
	    function afficheModal(event){
			
			var url = $(this).attr("href");
			console.log(url);
			
			$.getJSON( url , function( data, status, error ) {
				console.log(data.channel);
				var contenu = "<div>";
				$.each( data.channel, function( key, val ) {
					if (key.indexOf("field") != -1){
						contenu += '<div id = "choix" class="form-check">'
						contenu += '<input class="form-check-input" type="checkbox" value="' + key.substring(5,6) + '" id="'+ key +'">';
						contenu += '<label class="form-check-label" for="'+ key +'">';
						contenu += val;
						contenu += '</label>';
						contenu += '</div>';
					}	
				});
				contenu += "</div>";
				
				$("#modal-contenu").html( contenu );
				var title = data.channel.id + " : " + data.channel.name; 
				console.log(title);
				$("#ModalLongTitle").html( title );
				$(".btn-afficher").attr("id", data.channel.id );  // On fixe l'attribut id du button avec l'id du canal
				$(".btn-afficher").attr("name", data.channel.name );  // On fixe l'attribut name du button avec le nom du canal
				$("#ModalCenter").modal('show');
			});
			
			event.preventDefault();   // bloque l'action par défaut sur le lien cliqué
		}
		
		function afficherVue(event){
			var channel_id = $(this).attr("id");
			var channel_name = $(this).attr("name");
			
			var choix = [];
			var anyBoxesChecked = false;
			$('#choix  input[type="checkbox"]').each(function() {
				if ($(this).is(":checked")) {
					choix.push($(this).val());
					anyBoxesChecked = true;
				}
			});
			if (anyBoxesChecked == false) {
				console.log("pas de choix");
			} 

			console.log("choix : " + choix); 
			var url = "/Ruche/thingSpeakView?channel=" + channel_id + '&name=' + channel_name;
			for (i = 0; i < choix.length; i++){
				url += '&field' + i + '=' + choix[i];	
			}
			console.log(url);
			//window.location.href=url;
			window.open(url,'_blank');	
			$("#ModalCenter").modal('hide');
			
		}	
	
	    $(document).ready(function(){

			$(".channels").click(afficheModal);
			$(".btn-afficher").click(afficherVue);
		});
    </script>	