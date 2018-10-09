<?php
    $ini  = parse_ini_file("sendSMS.ini", true);
    
    // Fonction pour renvoyer un code d'erreur 
    function erreur($code, $designation){
        $data = array(
                'error' => $designation,
                'error_code' => $code,
                'error_description' => $designation
        );
        header('HTTP/1.1 ' . $code . ' ' . $designation);
        header('content-type:application/json');
	echo json_encode($data);
    
    }

    // Contrôle de la présence du paramètre key
    
    if ( isset($_GET['key'])){
        $key =  urldecode((string)$_GET['key']);
    }
    elseif (isset($_POST['key'])) {
        $key = (string)$_POST['key'];
    }
    else{
        erreur(403, "Forbidden" );
        exit();
    }
    
    // Contrôle de la présence du paramètre number
    if ( isset($_GET['number'])){
        $number = (string)$_GET['number'];
    }
    elseif (isset($_POST['number'])) {
        $number = (string)$_POST['number'];
    }
    else{
        erreur(400, "Bad Request" );
        exit();
    }
    
    // Contrôle de la présence du paramètre message
    if ( isset($_GET['message'])){
        $message = urldecode((string)$_GET['message']);
    }
    elseif (isset($_POST['message'])) {
        $message = (string)$_POST['message'];
    }
    else{
        erreur(400, "Bad Request" );
        exit();
    }
    
    
    // Contrôle de la clé
    if ( $key != $ini['api']['key']) {
        erreur(403, "Forbidden" );
        exit();
    }
    
    // Contrôle du numéro de téléphone
    if (strlen($number)<8 || !is_numeric($number)){
        erreur(400, "Bad Request");
        exit();
    }
    
    // Contrôle du message
    if (strlen($message)<1 || strlen($message)> 160){
        erreur(400, "Bad Request");
        exit();        
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
        erreur(500, "Internal Server Error");
        
    }    
    
        

?>
