<?php


    $data = array();

    // Contrôle de la clé
    if ( !isset($_GET['key']) || $_GET['key'] != 'azerty') {
        $data = array(
            'error' => "Not authorised",
            'error_code' => 403,
            'error_description' => "Not authorised",
            'resource' => null
        );
        header('HTTP/1.0 403 Forbidden');
        header('content-type:application/json');
	echo json_encode($data);
        exit;
    }

    if( !isset($_GET['message']) || !isset($_GET['number'])) {
        $data = array(
            'error' => "Missing data",
            'error_code' => 403,
            'error_description' => "Missing data",
            'resource' => null
        );
        header('HTTP/1.0 403 Forbidden');
        header('content-type:application/json');
        echo json_encode($data);
        exit;
    }

    $message = urldecode((string)$_GET['message']);
    $number = (string)$_GET['number'];

    $ligne  = "gammu-smsd-inject TEXT " . $number . " -text \"" . $message .  "\"";
//    echo $ligne;

    $output = shell_exec($ligne);
//    echo "<p>output</p><pre>" . $output . "</pr>";
    $data = array(
            'status' => "200 OK",
            'numero' => $number,
            'message' => $message
        );

    header('HTTP/1.0 200 OK');
    header('content-type:application/json');
    echo json_encode($data);


?>
