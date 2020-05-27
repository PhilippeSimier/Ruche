<?php
    // Script pour renvoyer le niveau du network signal
	// Attention vous devez modifier les droits du fichier gammu-smsd-monitor
    // cd /usr/bin
    // chmod +s gammu-smsd-monitor


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

    $ligne  = "gammu-smsd-monitor -n 1 -d 1 ";
    exec($ligne, $output, $return);
	
	
    
    if($return===0){
		$data = array('status' => '200 OK');
		for ($i = 3; $i < 10; $i++){
			$result = explode(":", $output[$i]);
			$data[$result[0]] = trim($result[1]);
        }        
        

        header('HTTP/1.1 200 OK');
        header('content-type:application/json');
        echo json_encode($data);
    }
    else{
        erreur(500, "Internal Server Error", "Internal Server Error");
    }
    