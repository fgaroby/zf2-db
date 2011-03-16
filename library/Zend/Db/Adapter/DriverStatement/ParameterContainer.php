<?php

namespace Zend\Db\Adapter\DriverStatement;

class ParameterContainer extends \ArrayObject
{
    protected $source = array();
    
    public function __construct(Array $array = array(), $flags = \ArrayObject::ARRAY_AS_PROPS)
    {
        $this->source = array_merge($this->source, $array);
        parent::__construct(&$this->source, $flags);
    }
}