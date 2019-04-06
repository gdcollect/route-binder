<?php

namespace Leonc\RouteBinder\Assertion;

class AssertionBuilder
{
    private $model;

    public function __construct($model){
        $this->customFailMesssage = null;
        $this->model = $model;
        $this->model_name = $this->getShortName($this->model);
    }

    public function belongsTo($class, $val, $key = null){
        $name = $this->getShortName($class);
        $key = $this->getPrimaryKey($name, $key);
        return $this->makeResult(
            $this->model->{$key} == $val,
            " has to belong to ${name} with key {$key} equal to {$val}"
        );
    }

    public function belongsToBy($targetClass, $agentClass, $val, $agentKey = null, $targetKey = null){
        $agentName = $this->getShortName($agentClass); 
        $targetName = $this->getShortName($targetClass);
        $agentKey = $this->getPrimaryKey($agentName, $agentKey);
        $targetKey = $this->getPrimaryKey($targetName, $targetKey);
        
        $agent = (new $agentClass)->find($this->model->{$agentKey});
        if(is_null($agent)){
            return $this->makeResult(
                false,
                " has to belongs to {$agentName} which belongs to ${targetName} with key {$targetKey} equal to {$val}"
            );
        }
        else{
            return $this->makeResult(
                $agent->{$targetKey} == $val,
                " has to belongs to {$agentName} which belongs to ${targetName} with key {$targetKey} equal to {$val}"
            );
        }
    }

    public function hasAttr($attr){
        return $this->makeResult(
            array_key_exists($attr, $this->model->toArray()),
            " has to have {$attr} attribute"
        );
    }

    public function attrEquals($attr, $val){
        return $this->makeResult(
            $this->model->{$attr} == $val,
            "'s {$attr} attribute has to equal {$val}"
        );
    }

    public function attrEqualsStrong($attr, $val){
        return $this->makeResult(
            $this->model->{$attr} === $val,
            "'s {$attr} attribute has to equal {$val}"
        );
    }

    public function attrHasLength($attr, $length){
        if(is_countable($this->model->{$attr})){
            return $this->makeResult(
                count($this->model->{$attr} ) == $length,
                "'s {$attr} attribute has to have length {$length}"
            );
        } 
        else{
            return $this->makeResult(false, "'s {$attr} has to be countable!" );
        }
    }

    public function attrGreaterThan($attr, $val){
        return $this->makeResult(
            $this->getAttrToComparison($attr) > $val,
            "'s {$attr} attribute has to be greater than {$val}"
        );
    }

    public function attrGreaterEqual($attr, $val){
        return $this->makeResult(
            $this->getAttrToComparison($attr) >= $val,
            "'s {$attr} attribute has to be greater or equal {$val}"
        );
    }

    public function attrLessThan($attr, $val){
        return $this->makeResult(
            $this->getAttrToComparison($attr) < $val,
            "'s {$attr} attribute has to be less than {$val}"
        );
    }

    public function attrLessEqual($attr, $val){
        return $this->makeResult(
            $this->getAttrToComparison($attr) <= $val,
            "'s {$attr} attribute has to be less or equal {$val}"
        );
    }

    public function attrBetween($attr, $val1, $val2){
        $attribiute = $this->getAttrToComparison($attr);
        return $this->makeResult(
            $attribiute < max($val1, $val2)  && $attribiute > min($val1, $val2),
            "'s {$attr} attribute has to be between {$val1},{$val2} (excluding values)"
        );
    }

    public function attrBetweenEqual($attr, $val1, $val2){
        $attribiute = $this->getAttrToComparison($attr);
        return $this->makeResult(
            $attribiute <= max($val1, $val2)  && $attribiute >= min($val1, $val2),
            "'s {$attr} attribute has to be between {$val1},{$val2} (including values)"
        );
    }

    private function getAttrToComparison($attr){
        $field = $this->model->{$attr};
        if(is_countable($field)) return count($field);    
        return $field;
    }

    private function getShortName($class){
        return (new \ReflectionClass(new $class ))->getShortName();
    }

    private function getPrimaryKey($className, $key){
        if(is_null($key)) return strtolower($className.'_id');
        else return $key;
    }
    
    private function makeResult($passess, $message){
        return new AssertionResult($passess, $this->getFailMessage($message) , $this->model_name);
    }

    public function getModel(){
        return $this->model;
    }

    public function getFailMessage($message){
        if(is_null($this->customFailMessage)) return "{$this->model_name}".$message;
        else return $this->customFailMessage;
    }

    public function setFailMessage($msg){
        $this->customFailMessage = $msg;
    }
    
}