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
					<a class="dropdown-item" href="/thingSpeakPoidsTemperature.php">Poids/Température</a>
					<a class="dropdown-item" href="/thingSpeakPressionHumidite.php">Pression/Humidité</a>
					<a class="dropdown-item" href="/thingSpeakChannelEclairement.php">Eclairement</a>
				  </div>
			</li>
			
			<!-- Dropdown Analyses-->
			<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
					 Data analysis
				  </a>
				  <div class="dropdown-menu">
					<a class="dropdown-item" href="/dispersionPoidsTemperature.php">Nuage de points Poids/Température</a>
					<a class="dropdown-item" href="/dispersionTempHumidite.php">Nuage de points Température/Humidité</a>
					<a class="dropdown-item" href="/dewPoint.php">Dew point</a>
				  </div>
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
					echo '<a class="dropdown-item" href="/administration/ruche.php">Ruche</a>';
					echo '<a class="dropdown-item" href="/administration/balance.php">Balance</a>';
					echo '<a class="dropdown-item" href="/administration/baseDeDonnees.php">Bases de données</a>';
					echo '<a class="dropdown-item" href="/administration/thingSpeakConf.php">Thing Speak</a>';
					echo '<a class="dropdown-item" href="https://ifttt.com/my_applets">IFTTT</a>';
					echo '<a class="dropdown-item" href="/administration/signout.php" id="nav-sign-in">Sign Out</a>';
					echo '</div>';
					echo '</li>';
				}	
				?>
			</li>
		</ul>
        
		</div>
    </nav>