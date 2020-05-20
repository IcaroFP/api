<?php
    
    require_once("config.php");
    
    if (DEBUG) {
        ini_set("display_errors", 1);
        ini_set("display_startup_erros", 1);
        error_reporting(E_ALL);
    } else {
        ini_set("display_errors", 0);
        ini_set("display_startup_erros", 0);
        error_reporting(0);
    }
    
    require_once("requires.php");
    
    $utilit = new Utility();
    $response = array();

    
    Utility::isActivated();    
    $utilit->accessControlAllowOrigin();

    header("Content-Type: application/json");
    
    $get_headers = (object) apache_request_headers();
    
    $contents 	  = file_get_contents("php://input");
    $json_request = json_decode($contents, true);
    $json_object  = (object)$json_request;
    
    Utility::dd($get_headers);