<?php

class ControllerCustomer {
    //Attributes
    private $name;
    private $sobrenome;
    private $cpf;
    private $data_nascimento;
    
    function getName() {
        return $this->name;
    }

    function getSobrenome() {
        return $this->sobrenome;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getDataNascimento() {
        return $this->data_nascimento;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setSobrenome($sobrenome) {
        $this->sobrenome = $sobrenome;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setDataNascimento($data_nascimento) {
        $this->data_nascimento = $data_nascimento;
    }
    
    public function addCustomer() {
        return ModelCustomer::addCustomer($this);
    }
}