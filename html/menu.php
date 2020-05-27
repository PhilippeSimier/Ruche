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
	
	require_once('api/Str.php');
	use Aggregator\Support\Str;
	
	$racine = './';
	$repertoire = array('administration' , 'support' );  // les répertoires de premier niveau du site
	if  (Str::contains($_SERVER['PHP_SELF'], $repertoire)){
		$racine = '../';
	}
	$repertoire = array('administration/support' );      // les répertoires de second niveau du site
    if  (Str::contains($_SERVER['PHP_SELF'], $repertoire)){
		$racine = '../../';
	}
?>

	<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" href="<?php echo $racine ?>">
			<img alt="Beehive logo" height="30" id="nav-Beehive-logo" src="<?php echo $racine ?>images/beehive_logo.png" style="padding: 0 8px; ">
		</a>
		<span class="navbar-text">
		<?php 
			$date = date("d-m-Y");
			$heure = date("H:i");
			echo "$date - $heure";
		?>
		</span>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		
		
		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
        
		<ul class="navbar-nav mr-auto">		
			<!--<li class="nav-item">
				<a class="nav-link" href="<?php echo $racine ?>activity.php" id="nav-sign-in">Activity</a>
			</li>-->		
        </ul>
		
		<!-- Menu à droite -->
		<ul class="navbar-nav navbar-right" style="margin-right: 78px;">
			<li class="nav-item">
				
				<?php 
				if (!isset($_SESSION['login']))
					echo "<a class='nav-link' href='{$racine}administration/' id='nav-sign-in'>Sign In</a>\n";
				else{
					echo "<li class='nav-item dropdown'>";
					
					echo "<a class='nav-link dropdown-toggle' href='#' id='navbardrop' data-toggle='dropdown'>\n";
						echo "<img alt='Avatar' height='30' id='nav-avatar-logo' src='{$racine}images/icon-avatar.svg' style='padding: 0 10px; '>\n";
						echo $_SESSION['login']; 
					echo "</a>\n";
					echo "<div class='dropdown-menu'>\n";
					echo "<a class='dropdown-item' href='{$racine}administration/ruche.php'>Beehive</a>\n";
					echo "<a class='dropdown-item' href='{$racine}administration/balance.php'>Scale</a>\n";
					echo "<a class='dropdown-item' href='{$racine}administration/baseDeDonnees.php'>Database</a>\n";
					echo "<a class='dropdown-item' href='{$racine}administration/aggregatorConf.php'>Aggregator</a>\n";
					echo "<a class='dropdown-item' href='{$racine}administration/formulaireSMS.php'>GSM</a>\n";
					echo "<a class='dropdown-item' href='{$racine}administration/battery.php'>Battery</a>\n";
					echo "<a class='dropdown-item' href='{$racine}administration/infoSystem.php'>System info</a>\n";
					echo "<a class='dropdown-item' href='{$racine}administration/signout.php' id='nav-sign-in'>Sign Out</a>\n";
					echo "</div>\n";
					echo "</li>\n";
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
		
	