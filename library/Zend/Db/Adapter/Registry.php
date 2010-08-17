<?php

namespace Zend\Db\Adapter;

class Registry extends \ArrayObject // this should probably extend Zend\Registry\Registry
{
    
    protected $_defaultAdapter = null;
    
    public function registerAdapter($name, Adapter $adapter, $isDefault = false)
    {
        
    }
    
    public function registerDefaultAdapter(Adapter $adapter)
    {
        $this->_defaultAdapter = $adapter;
    }
    
    public function getDefaultAdapter()
    {
        return $this->_defaultAdapter;
    }
    
}
