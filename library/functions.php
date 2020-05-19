<?php

$allow_origins = array();

function dd($param, $other_params = array()) {
    echo "<pre>";
    	print_r($param);
    
        if($other_params){
        	foreach ($other_params as $param) {
            	print_r($param);
        	}
        }

    echo "</pre>";
    exit();
}

function myErrorHandler($code = 0) {
	switch ((int)$code) {
		case 1: $message = "API desabilitada."; break;
		case 2: $message = "Origem não autorizada."; break;
		default: $message = "Erro não identificado."; break;
	}

	$error = [
		'error' => [
			'code'	  => $code,
			'message' => $message
		]
	];

	return $error;
}

function isActivated() {
	if (!API_ACTIVATED) {
		http_response_code(200);
		$response = json_encode(myErrorHandler(1));
		exit($response);
	}
}

function addAllowOrigin($origin = null) {
	$allow_origins[] = $origin;
}

function accessControlAllowOrigin() {
	if (RESTRICT_ORIGIN) {
		//Captura o http origin
		$http_origin = filter_input(INPUT_SERVER, "HTTP_ORIGIN");

		if (in_array($http_origin, $allow_origins)) {  
		    header("Access-Control-Allow-Origin: {$http_origin}");
		} else {
			http_response_code(401);
			$response = json_encode(myErrorHandler(2));
			exit($response);
		}
	} else {
		header("Access-Control-Allow-Origin: *");
	}
}