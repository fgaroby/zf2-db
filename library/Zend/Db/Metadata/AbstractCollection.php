<?php

namespace Zend\Db\Metadata;

abstract class AbstractCollection extends \ArrayObject
{
    const TYPE_ACTUAL = 'actual';
    const TYPE_REFERENCE = 'reference';
    
    protected $itemClassType = null;
    protected $collectionType = self::TYPE_ACTUAL;
    
    public function __construct(array $array = array(), $collectionType = self::TYPE_ACTUAL)
    {
        if ($this->itemClassType == null || !class_exists($this->itemClassType)) {
            trigger_error('Subclasses of ' . __CLASS__ . ' must set the $itemClassType property to an existing class type.', E_USER_ERROR);
        }
        
        if (!is_subclass_of($this->itemClassType, '\Zend\Db\Metadata\AbstractMetadata')) {
            trigger_error('$itemClassType in ' . get_class($this) . ' must derive from Zend\Db\Metadata\AbstractMetadata.', E_USER_ERROR);
        }
        
        parent::__construct($array, \ArrayObject::ARRAY_AS_PROPS);
        $this->collectionType = $collectionType;
    }
    
    public function offsetSet($offset, $value)
    {
        if (!$value instanceof $this->itemClassType) {
            throw new \InvalidArgumentException('Collection values must be an instance of ' 
                . $this->itemClassType . ', ' . get_class($value) . ' was provided');
        }
        
        if ($offset == null) {
            $offset = $value->getName();
        }
        
        if ($offset !== $value->getName()) {
            throw new \InvalidArgumentException('Offset name and name within object must be the same');
        }
        
        parent::offsetSet($offset, $value);
        return $this;
    }

}
