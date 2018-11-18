<!----------------------------------------------------------------------------------
    @fichier  menu.php							    		
    @auteur   Philippe SIMIER (Touchard Washington le Mans)
    @date     Juillet 2018
    @version  v1.0 - First release						
    @details  menu /Menu pour toutes les pages du site ruche 
------------------------------------------------------------------------------------>
<?php 
    require_once('definition.inc.php');
    $ini  = parse_ini_file(CONFIGURATION, true);
?>

	<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" href="/">
			<img alt="Beehive logo" height="30" id="nav-Beehive-logo" src="/images/beehive_logo.png" style="padding: 0 8px; ">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		
		
		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
        
		<ul class="navbar-nav mr-auto">
			  
						
			<!-- Dropdown Mesures-->
			<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
					Data visualization
				  </a>
				  <div class="dropdown-menu">
					<?php
								$url = "https://api.thingspeak.com/channels.json?api_key=" . $ini['thingSpeak']['userkey'] . "&tag=" . $ini['thingSpeak']['tag'];
								$curl = curl_init();

								curl_setopt_array($curl, array(
									  CURLOPT_URL => $url,
									  CURLOPT_RETURNTRANSFER => true,
									  CURLOPT_ENCODING => "",
									  CURLOPT_MAXREDIRS => 10,
									  CURLOPT_TIMEOUT => 30,
									  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									  CURLOPT_CUSTOMREQUEST => "GET",
									  CURLOPT_HTTPHEADER => array(
										"cache-control: no-cache"
									  ),
								));

								$response = curl_exec($curl);
								$err = curl_error($curl);

								curl_close($curl);

								if ($err) {
									echo "cURL Error #:" . $err;
								} else {
									$channels = json_decode($response);
									
									$count = count($channels);
									for ($i = 0; $i < $count; $i++) {
										echo '<a class="dropdown-item channels" href="https://api.thingspeak.com/channels/' . $channels[$i]->{'id'} . '/feed.json?results=0" target="_blank" >' . $channels[$i]->{'name'} . "</a>\n";
									}
								}
					?>
			
				  </div>
			</li>
			
			<!-- Dropdown Analyses-->
			<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
					 Data analysis
				  </a>
				  <div class="dropdown-menu">
				    <?php 
					if (isset($ini['matlab']['id1'])) 
					    echo '<a class="dropdown-item" href="/MatlabVisualization.php?id=' . $ini['matlab']['id1'] . '">' . $ini['matlab']['name1'] . '</a>';
				    if (isset($ini['matlab']['id2']))
					    echo '<a class="dropdown-item" href="/MatlabVisualization.php?id=' . $ini['matlab']['id2'] . '">' . $ini['matlab']['name2'] . '</a>';
					if (isset($ini['matlab']['id3']))
					    echo '<a class="dropdown-item" href="/MatlabVisualization.php?id=' . $ini['matlab']['id3'] . '">' . $ini['matlab']['name3'] . '</a>';
					if (isset($ini['matlab']['id4']))
					    echo '<a class="dropdown-item" href="/MatlabVisualization.php?id=' . $ini['matlab']['id4'] . '">' . $ini['matlab']['name4'] . '</a>';
					?>
				  </div>
			</li>
			
			<li class="nav-item">
				<a class="nav-link" href="/activity.php" id="nav-sign-in">Activity</a>
			</li>		
        </ul>
		
		<!-- Menu à droite -->
		<ul class="navbar-nav navbar-right" style="margin-right: 78px;">
			<li class="nav-item">
				
				<?php 
				if (!isset($_SESSION['login']))
					echo '<a class="nav-link" href="/administration/index.php" id="nav-sign-in">Sign In</a>';
				else{
					echo '<li class="nav-item dropdown">';
					
					echo '<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">';
						echo '<img alt="Avatar" height="30" id="nav-avatar-logo" src="/images/icon-avatar.svg" style="padding: 0 10px; ">';
						echo $_SESSION['login']; 
					echo '</a>';
					echo '<div class="dropdown-menu">';
					echo '<a class="dropdown-item" href="/administration/ruche.php">Beehive</a>';
					echo '<a class="dropdown-item" href="/administration/balance.php">Scale</a>';
					echo '<a class="dropdown-item" href="/administration/baseDeDonnees.php">Database</a>';
					echo '<a class="dropdown-item" href="/administration/thingSpeakConf.php">Thing Speak</a>';
					echo '<a class="dropdown-item" href="/administration/formulaireSMS.php">GSM</a>';
					echo '<a class="dropdown-item" href="https://ifttt.com/my_applets">IFTTT</a>';
					echo '<a class="dropdown-item" href="/administration/infoSystem.php">System info</a>';
					echo '<a class="dropdown-item" href="/administration/signout.php" id="nav-sign-in">Sign Out</a>';
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
				var contenu = "<ul>";
				$.each( data.channel, function( key, val ) {
					if (key.indexOf("field") != -1){
						contenu += '<li>' + key +  ' : <a href="/thingSpeakView.php?channel=' + data.channel.id + '&fieldP=' + key.substring(5,6) + '">'  + val + "</a></li>";
					}	
				});
				contenu += "</ul>";
				
				$("#modal-contenu").html( contenu );
				var title = data.channel.id + " : " + data.channel.name; 
				console.log(title);
				$("#ModalLongTitle").html( title );
				$("#ModalCenter").modal('show');
			});
			
			event.preventDefault();   // bloque l'action par défaut sur le lien cliqué
		}
	
	    $(document).ready(function(){

			$(".channels").click(afficheModal);
		});
    </script>	