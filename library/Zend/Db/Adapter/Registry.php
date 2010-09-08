<?php

namespace Zend\Db\Adapter;

class Registry extends \Zend\Registry
{
    
    protected $defaultAdapterName = null;
    
    public function registerAdapter(Adapter $adapter, $isDefault = false)
    {
        $name = $adapter->getName();
        
        if ($name == 'defaultAdapter') {
            throw new \InvalidArgumentException('The name "defaultAdapter" is a reserved key and cannot be used in this registry.');
        }
        
        $this->offsetSet($name, $adapter);
        
        if ($isDefault || $this->defaultAdapterName == null) {
            $this->setDefaultAdapter($name);
        }
    }
    
    public function registerDefaultAdapter(Adapter $adapter)
    {
        $this->registerAdapter($adapter, true);
    }
    
    public function setDefaultAdapter($adapter)
    {
        if ($adapter instanceof Adapter) {
            $adapter = $adapter->getName();
        }
        
        if (!$this->offsetExists($adapter)) {
            throw new \InvalidArgumentException('Adapter or adapter name provided is not in this registry, cannot be marked as default');
        }
        
        $this->offsetSet('defaultAdapter', $this->offsetGet($adapter));
        $this->defaultAdapterName = $adapter;
    }
    
    public function getDefaultAdapter()
    {
        return $this->offsetGet($this->_defaultAdapter);
    }
    
}
