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
					<a class="dropdown-item" href="/thingSpeakView.php?fieldP=1&fieldS=2">Weight/Temperature</a>
					<a class="dropdown-item" href="/thingSpeakView.php?fieldP=3&fieldS=4">Pressure/humidity</a>
					<a class="dropdown-item" href="/thingSpeakView.php?fieldP=5">Illuminance</a>
					<a class="dropdown-item" href="/thingSpeakView.php?fieldP=6">Dew point</a>
					
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
					if (isset($ini['matlabAnalysis']['id1']))
						echo '<a class="dropdown-item" href="/thingSpeakView.php?channel=' . $ini['matlabAnalysis']['id1'] . '&fieldP=1">'. $ini['matlabAnalysis']['name1'] . '</a>';
					if (isset($ini['matlabAnalysis']['id2']))
						echo '<a class="dropdown-item" href="/thingSpeakView.php?channel=' . $ini['matlabAnalysis']['id2'] . '&fieldP=1">'. $ini['matlabAnalysis']['name2'] . '</a>';
					if (isset($ini['matlabAnalysis']['id3']))
						echo '<a class="dropdown-item" href="/thingSpeakView.php?channel=' . $ini['matlabAnalysis']['id3'] . '&fieldP=1">'. $ini['matlabAnalysis']['name3'] . '</a>';
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