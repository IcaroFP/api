<?php

	require_once("config.php");
	require_once(PATH . "libary/functions.php");

	$response = array();

	isActivated();
	accessControlAllowOrigin();

    header("Content-Type: application/json");
    
    $get_headers = (object) apache_request_headers();
    
    $contents 	  = file_get_contents("php://input");
	$json_request = json_decode($contents, true);
    $json_object  = (object)$json_request;
           
    