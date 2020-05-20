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
   
    Utility::isActivated();    
    $utilit->accessControlAllowOrigin();

    header("Content-Type: application/json");
    
    $get_headers = (object) apache_request_headers();
    
    $contents 	  = file_get_contents("php://input");
    $json_request = json_decode($contents, true);
    $json_object  = (object)$json_request;
    
    $customer = new ControllerCustomer();
    $customer->setName('Icaro');
    $customer->setSobrenome('França');
    $customer->setCpf('1646464646');
    $customer->setDataNascimento('08/03/1997');
    $response = $customer->addCustomer();
    
    //Utility::dd();
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);