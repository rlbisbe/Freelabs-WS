<?php

class Lab
{
    private $_params;

    public function __construct($params)
    {
        $this->_params = $params;
    }

    public function getLabAction(){
        $lab = Laboratorio::get($this->_params['id']);
        return $lab;
    }

    public function getAllAction(){
        $labs = Laboratorio::getAll();
        return $labs;
    }
}
