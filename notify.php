
        <?php
        // Enabling error reporting
		
		header("Content-Type:application/json");
        require_once __DIR__ . '/firebase.php';
        require_once __DIR__ . '/push.php';
        $firebase = new Firebase();
		$json=file_get_contents('php://input');
	//getting data from caller
	$obj=json_decode($json);
	$title=$obj->{'title'};
	$message=$obj->{'message'};
	$for=$obj->{'for'};
	$type=$obj->{'type'};
	
        
        $json = '';
        $response = '';
			//sending notification
			   $json = getPush($title,$message,$for,$type);
            $response = $firebase->sendToTopic('global', $json);
			echo $response;
			
		  function getPush($title,$msg,$for,$type) {
			  // optional payload
			  $payload = array();
        $payload['for'] = $for;
        $payload['type'] = $type;
        $res = array();
		
        $res['data']['title'] =$title;
        $res['data']['message'] = $msg;
        $res['data']['payload'] = $payload;
        $res['data']['timestamp'] = date('Y-m-d G:i:s');
        return $res;
    }
        ?>
		