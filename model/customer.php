<?php

class ModelCustomer extends DatabaseModel {
    
    /**
     * 
     * @param ControllerCustomer $customer 
     */
    public static function addCustomer($customer = null) {
        $response = array();
        if ($customer) {
            $response = [
                "customer" => [
                    "nome" => $customer->getName() . ' ' . $customer->getSobrenome(),
                    "cpf" => $customer->getCpf(),
                    "data_nascimento" => $customer->getDataNascimento()
                ]
            ];
        }
        
        return $response;
    }
    


}
