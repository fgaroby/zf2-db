<?php

namespace Zend\Db;
use \Zend\Db\Adapter\Adapter;

class Registry extends \Zend\Registry
{
    const DEFAULT_ADAPTER_NAME = 'defaultAdapter';
    
    protected $reservedKeys = array(
        self::DEFAULT_ADAPTER_NAME,
        'eventManager',
        );
    
    protected $defaultAdapterName = null;
    
    public function registerAdapter(Adapter $adapter, $isDefault = false)
    {
        $name = $adapter->getName();
        
        if ($name == self::DEFAULT_ADAPTER_NAME) {
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
        
        $this->offsetSet(self::DEFAULT_ADAPTER_NAME, $this->offsetGet($adapter));
        $this->defaultAdapterName = $adapter;
    }
    
    public function getDefaultAdapter()
    {
        return $this->offsetGet($this->{self::DEFAULT_ADAPTER_NAME});
    }
    
    public function setPluginManager(\Zend\Db\Plugin\PluginManager $pluginManager)
    {
        $this->offsetSet('pluginManager', $pluginManager);
    }
    
    public function getPluginManager()
    {
        if (!$this->offsetExists('pluginManager')) {
            $this->setPluginManager(new \Zend\Db\Plugin\PluginManager);
        }
        return $this->offsetGet('pluginManager');
    }
    
}
