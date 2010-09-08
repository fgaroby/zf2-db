<?php

namespace Zend\Db;

class Db // implements Zend\Application\ResourceContainer?
{
    const DEFAULT_ADAPTER = 'defaultAdapter';
    const DEFAULT_ADAPTER_REGISTRY_CLASS = '\Zend\Db\Adapter\Registry';
    
    protected $adapterRegistry = null;
    
    public function __construct($options = array())
    {
    	if ($options) {
    		$this->setOptions($options);
    	}
    }
    
    public function setOptions(array $options)
    {
    	foreach ($options as $optionName => $optionValue) {
    		if (method_exists($this, 'set' . $optionName)) {
    			$this->{'set' . $optionName}($optionValue);
    		}
    	}
    }
    
    /**
     * setAdapterRegistry()
     * 
     * @param string|\Zend\Db\Adapter\Registry $registry Class name or instance of \Zend\Db\Adapter\Registry
     * @param unknown_type $registerWithZendRegistry
     */
    public function setAdapterRegistry($registry = self::DEFAULT_ADAPTER_REGISTRY_CLASS, $registerWithZendRegistry = true)
    {
        if (is_string($registry)) {
            $registry = new $registry;
        }
        if (!$registry instanceof \Zend\Db\Adapter\Registry) {
            throw new \InvalidArgumentException('Needs to implement adapter registry');
        }
        $this->adapterRegistry = $registry;
        
        if ($registerWithZendRegistry) {
            if (\Zend\Registry::hasRegistry(get_class($registry))) {
                throw new \Exception('Only one adapter registry can be registered with Zend\Registry');
            }
            \Zend\Registry::registerRegistry($registry);
        }
        
        return $this;
    }
    
    /**
     * @return \Zend\Db\Adapter\Registry
     */
    public function getAdapterRegistry()
    {
        if ($this->adapterRegistry == null) {
            $this->setAdapterRegistry(self::DEFAULT_ADAPTER_REGISTRY_CLASS);
        }
        return $this->adapterRegistry;
    }
    
    public function setAdapter($adapter)
    {
        if (is_array($adapter)) {
            $adapter = new \Zend\Db\Adapter\Adapter($adapter);
        }
        
        if (!($adapter instanceof \Zend\Db\Adapter\Adapter)) {
            throw new \Exception();
        }
        
        $registry = $this->getAdapterRegistry();
        $registry->registerAdapter($adapter);
    }
    
    public function setAdapters(array $adapters)
    {
        foreach ($adapters as $adapter) {
            $this->setAdapter($adapter);
        }
        return $this;
    }
    
    /**
     * @return \Zend\Db\Adapter\Adapter
     */
    public function getAdapter($adapterName = self::DEFAULT_ADAPTER)
    {
        return $this->getAdapterRegistry()->{$adapterName};
    }
    
    public function getQuery($adapterName = self::DEFAULT_ADAPTER)
    {
        $query = new \Zend\Db\Query\Query;
        $query->setAdapter($this->getAdapter($adapterName));
        return $query;
    }
    
}
