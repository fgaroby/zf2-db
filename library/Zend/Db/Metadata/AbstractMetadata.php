<?php

namespace Zend\Db\Metadata;

abstract class AbstractMetadata
{
    protected $name = null;
    
    public function setOptions(Array $options)
    {
        foreach ($options as $optionName => $optionValue) {
            $this->{'set' . $optionName}($optionValue);
        }
    }
    
    public function setMetadata(Metadata $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }
    
    public function getMetadata()
    {
        return $this->metadata;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
}
