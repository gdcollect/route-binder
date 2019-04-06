<?php

namespace Leonc\RouteBinder\Assertion;

class AssertionResult
{
    public function __construct($passess, $message, $modelName){
        $this->passess = $passess;
        $this->message = $message;
        $this->modelName = $modelName;
    }
    
    public function passess(){
        return $this->passess;
    }
    
    public function getFailMessage(){
        return $this->message;
    }

    public function getModelName(){
        return $this->modelName;
    }

}