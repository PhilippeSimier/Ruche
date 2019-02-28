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
    <link rel="stylesheet" href="/Ruche/css/bootstrap.min.css">
	<link rel="stylesheet" href="/Ruche/css/ruche.css" />
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="/Ruche/scripts/bootstrap.min.js"></script> 
    
 </head>

 <body>
	<?php require_once 'menu.php'; ?>
	<div class="container" style="padding-top: 65px;">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="popin table-responsive">
				<table class="table table-striped">
					<thead>
					  <tr>
						<th>N°</th>
						<th>Date Time</th>
						<th>Process</th>
					  </tr>
					</thead>
					<tbody>
						<?php
							$file = '/var/log/Ruche/activity.log';
						 
							$file_contents = array_reverse(file($file));
							$nb = 1;
							
							foreach($file_contents as $line_num => $line){
								if (preg_match("/\b50[0-5]\b/", $line)) echo '<tr class="table-danger">'; else echo '<tr>';						
								echo "<td>" .$line_num . "</td><td> " . substr($line, 0, 20) . "</td><td>" . substr($line, 20) . "</td>";
								$nb++;
								if ($nb > 48) {
									break; 
								}
								echo "</tr>\n";
							}
							
						?>
					</tbody>
				</table>	
				</div>
			</div>	

			
	
		</div>
		<?php require_once 'piedDePage.php'; ?>
	</div>	
	
</body>
</html>
	