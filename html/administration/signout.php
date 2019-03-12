
<?php
	session_start();
	
	unset($_SESSION['login']);
	unset($_SESSION['last_access']);
	unset($_SESSION['ipaddr']);
	unset($_SESSION['droits']);
	
	header("Location: ../index.php");
?>