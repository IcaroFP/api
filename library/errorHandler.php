<?php

class ErrorHandler {
    
    public static function getError($code = null) {
        $error = [
            'error' => [
                'code'	  => $code,
                'message' => self::errorMessages($code)
            ]
	];
        
        return json_encode($error, JSON_UNESCAPED_UNICODE);
    }
    
    private static function errorMessages($code) {
	switch ($code) {
            case 1: $message = "API desabilitada."; break;
            case 2: $message = "Origem não autorizada."; break;
            default: $message = "Erro não identificado."; break;
	}

	return $message;
    }
    
}

