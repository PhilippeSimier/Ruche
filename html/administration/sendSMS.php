<?php
    $ini  = parse_ini_file("sendSMS.ini", true);
 
    // Fonction pour renvoyer une réponse suite à une erreur 
    function erreur($httpStatus, $message, $detail){
        $data = array(
                'status' => $httpStatus,
                'message' => $message,
                'detail' => $detail
        );
        header('HTTP/1.1 ' . $httpStatus . ' ' . $message);
        header('content-type:application/json');
	echo json_encode($data);
    
    }

    // Contrôle de la présence du paramètre key en GET ou POST
    $key = filter_input(INPUT_GET, 'key');
    if($key === NULL){
        $key = filter_input(INPUT_POST, 'key');
    }
    if($key === NULL){
        erreur(403, "Bad Request", "The request cannot be fulfilled due to bad syntax." );
        return;  
    }

    // Contrôle de la présence du paramètre number
    $number = filter_input(INPUT_GET, 'number');

    if($number === NULL){
        $number = filter_input(INPUT_POST, 'number');
    }
    if($number === NULL){
        erreur(403, "Bad Request", "The request cannot be fulfilled due to bad syntax." );
        return;
    }

    // Contrôle de la présence du paramètre message
    $message = filter_input(INPUT_GET, 'message');

    if($message === NULL){
        $message = filter_input(INPUT_POST, 'message');

    }
    if($message === NULL){
        erreur(403, "Bad Request", "The request cannot be fulfilled due to bad syntax." );
        return;
    }


    // Contrôle de la clé
    if ( $key != $ini['api']['key']) {
        erreur(405, "Authorization Required", "Please provide proper authentication details." );
        return;
    }

    // Contrôle du numéro de téléphone
    if (strlen($number)<8 || !is_numeric($number)){
        erreur(403, "Bad Request", "The request cannot be fulfilled due to bad number.");
        return;
    }

    // Contrôle du message
    if (strlen($message)<1 || strlen($message)> 160){
        erreur(403, "Request Entity Too Large", "Your request is too large. Please reduce the size and try again.");
        return;
    }



    $ligne  = "gammu-smsd-inject TEXT " . $number . " -text \"" . $message .  "\"";
    
  
    exec($ligne, $output, $return);

    if ($return == 0){
        $data = array(
                'status' => "202 Accepted",
                'numero' => $number,
                'message' => $message,

            );

        header('HTTP/1.1 202 Accepted');
        header('content-type:application/json');
        echo json_encode($data);
    }
    else{
        erreur(500, "Internal Server Error", "Internal Server Error");

    }
