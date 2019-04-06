<?php

namespace Leonc\RouteBinder\Assertion;

use Leonc\RouteBinder\Builders\StrategyBuilder;

class AssertionInvoker
{
    public function __construct($model, $strategy){
        $this->customFailMessage = null;
        $this->assertionBuilder = new AssertionBuilder($model);
        $this->strategy = StrategyBuilder::get($strategy);
    }
    
    public function __call($method, $args){
        $this->setStrategy($args);
        $result = $this->invoke($method, ...$args);
        
        if($result->passess()){
            return $this;
        } 
        else{
            $this->strategy->fail(
                $result->getFailMessage(), $result->getModelName()
            );
        }
    }

    public function setFailMessage($message){
        $this->customFailMessage = $message;
        return $this;
    }

    public function bind(){
        return $this->strategy->bind($this->assertionBuilder->getModel());
    }

    private function invoke($name, ...$params){
        $this->assertionBuilder->setFailMessage($this->customFailMessage);
        $result = $this->assertionBuilder->{$name}(...$params);
        $this->setFailMessage(null);
        return $result;
    }

    private function setStrategy(array $args){
        if( $this->isStringStrategyClassName($args[count($args) -1] )){
            $this->strategy = StrategyBuilder::get($args[ count($args) -1 ]);
        }
        else{
            $this->strategy = StrategyBuilder::get(null);
        }
    }

    private function isStringStrategyClassName($string){
        return is_string( $string ) && strpos($string ,'Leonc\RouteBinder\Strategy');
    }

}