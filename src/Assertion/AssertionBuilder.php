<?php

namespace Leonc\RouteBinder\Assertion;

class AssertionBuilder
{
    private $model;

    public function __construct($model){
        $this->model = $model;
        $this->model_name = (new \ReflectionClass($this->model ))->getShortName();
    }

    private function makeResult($passess, $message){
        return new AssertionResult($passess, "{$this->model_name}".$message, $this->model_name);
    }

    public function getModel(){
        return $this->model;
    }

    public function belongsTo($class, $val, $key = null){
        $name = (new \ReflectionClass(new $class ))->getShortName();
        if(is_null($key)) $key = strtolower($name.'_id');
        return $this->makeResult(
            $this->model->{$key} == $val,
            " has to belong to ${name} with key {$key} equal to {$val}"
        );
    }

    public function hasAttr($attr){
        return $this->makeResult(
            array_key_exists($attr, $this->model->toArray()),
            " has to have {$attr} attribute"
        );
    }

    public function equals($attr, $val){
        return $this->makeResult(
            $this->model->{$attr} == $val,
            "'s {$attr} attribute has to equal {$val}"
        );
    }

    public function equalsStrong($attr, $val){
        return $this->makeResult(
            $this->model->{$attr} === $val,
            "'s {$attr} attribute has to equal {$val}"
        );
    }

    public function hasLength($attr, $length){
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

    public function greaterThan($attr, $val){
        return $this->makeResult(
            $this->getAttrToComparison($attr) > $val,
            "'s {$attr} attribute has to be greater than {$val}"
        );
    }

    public function greaterEqual($attr, $val){
        return $this->makeResult(
            $this->getAttrToComparison($attr) >= $val,
            "'s {$attr} attribute has to be greater or equal {$val}"
        );
    }

    public function lessThan($attr, $val){
        return $this->makeResult(
            $this->getAttrToComparison($attr) < $val,
            "'s {$attr} attribute has to be less than {$val}"
        );
    }

    public function lessEqual($attr, $val){
        return $this->makeResult(
            $this->getAttrToComparison($attr) <= $val,
            "'s {$attr} attribute has to be less or equal {$val}"
        );
    }

    public function between($attr, $val1, $val2){
        $attribiute = $this->getAttrToComparison($attr);
        return $this->makeResult(
            $attribiute < max($val1, $val2)  && $attribiute > min($val1, $val2),
            "'s {$attr} attribute has to be between {$val1},{$val2} (excluding values)"
        );
    }

    public function betweenEqual($attr, $val1, $val2){
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

    
}