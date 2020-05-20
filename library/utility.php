<?php

class Utility {
    private $allow_origins = [];
    
    public function __construct() {
        $this->addAllowOrigin();
    }
    
    //Debug Function
     public static function dd($param, $other_params = array()) {
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

    //Verifica se a API esta habilitada
     public static function isActivated() {
	if (!API_ACTIVATED) {
            http_response_code(200);
            exit(ErrorHandler::getError(1));
	}
    }

    //Adiciona um novo origin a lista de origins permitidos
    public function addAllowOrigin($origin = null) {
	$this->allow_origins[] = $origin;
    }

    //Define o(s) origin(s) permitido(s)
    public function accessControlAllowOrigin() {
	if (RESTRICT_ORIGIN) {
            //Captura o http origin
            $http_origin = filter_input(INPUT_SERVER, "REMOTE_ADDR");

            if (in_array($http_origin, $this->allow_origins)) {  
                header("Access-Control-Allow-Origin: {$http_origin}");
            } else {
                http_response_code(401);
                exit(ErrorHandler::getError(2));
            }
        } else {
            header("Access-Control-Allow-Origin: *");
	}
    }
}