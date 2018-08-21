<!DOCTYPE html>

<?php 
    session_start();
	require_once('definition.inc.php');
    $ini  = parse_ini_file(CONFIGURATION, true);
?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Activity</title>
    <!-- Bootstrap CSS version 4.1.1 -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/ruche.css" />
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="/scripts/bootstrap.min.js"></script> 
    
 </head>

 <body>
	<?php require_once 'menu.php'; ?>
	<div class="container" style="padding-top: 65px;">
		<div class="row">
			<div class="col-md-9 col-sm-12 col-xs-12">
				<div class="popin">
				<?php
					$file = '/home/pi/Ruche/activity.log';
				 
					$file_contents = array_reverse(file($file));
					$nb = 1;
					echo "<p>";
					foreach($file_contents as $line){
				 
					  echo $line . "<br />";
					  $nb++;
					  if ($nb > 48) {
						 break; 
					  }
					}
					echo "</p>";
				?>
				</div>
			</div>	

			
	
		</div>
		<?php require_once 'piedDePage.php'; ?>
	</div>	
	
</body>
</html>
	