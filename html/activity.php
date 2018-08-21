<!DOCTYPE html>

<?php 
    session_start();
	require_once('definition.inc.php');
    $ini  = parse_ini_file(CONFIGURATION, true);
?>

<html>
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
	<!-- Bootstrap CSS version 4.1.1 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="/scripts/bootstrap.min.js"></script> 
    <link rel="stylesheet" href="css/ruche.css" />
	<title>Activity Thing Speak</title>
</head>
<body>
	<?php require_once 'menu.php'; ?>
	<div class="container" style="padding-top: 56px;">
		<div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12">
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
	</div>	
	<?php require_once 'piedDePage.php'; ?>
</body>
</html>
	