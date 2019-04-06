<?php

namespace Leonc\RouteBinder\Assertion;

use Leonc\RouteBinder\Builders\StrategyBuilder;

class AssertionInvoker
{
    public function __construct($model, $strategy){
        $this->assertionBuilder = new AssertionBuilder($model);
        $this->strategy = StrategyBuilder::get(null);
        $this->customFailMessage = null;
        $this->isStrategyPresistent = false;
        $this->isFailMessagePresistent = false;
    }
    
    public function __call($method, $args){
        $result = $this->invoke($method, ...$args);
        if(!$result->passess()){
            $this->strategy->fail(
                $result->getFailMessage(), $result->getModelName()
            );
        }
        else{
            $this->failMessage()->strategy();
            return $this;
        }
    }

    public function bind(){
        return $this->strategy->bind($this->assertionBuilder->getModel());
    }

    private function invoke($name, ...$params){
        $this->assertionBuilder->setFailMessage($this->customFailMessage);
        $result = $this->assertionBuilder->{$name}(...$params);
        return $result;
    }

    public function failMessage($message = null){
        if(!$this->isFailMessagePresistent){
            $this->customFailMessage = $message;
        }
        return $this;
    }

    public function presistFailMessage($message){
        $this->customFailMessage = $message;
        $this->isFailMessagePresistent = true;
        return $this;
    }

    public function strategy($class = null){
        if(!$this->isStrategyPresistent){
            $this->strategy = StrategyBuilder::get($class);
        }
        return $this;
    }

    public function presistStrategy($class){
        $this->strategy = StrategyBuilder::get($class);
        $this->isStrategyPresistent = true;
        return $this;
    }

}