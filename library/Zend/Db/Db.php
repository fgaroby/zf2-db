<?php

namespace Zend\Db;

class Db
{
    const DEFAULT_REGISTRY_CLASS = '\Zend\Db\Registry';
    
    protected $useStaticRegistry = null;
    protected $registryName = self::DEFAULT_REGISTRY_CLASS;
    protected $registry = null;

    protected $currentAdapterName = Registry::DEFAULT_ADAPTER_NAME;
    
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
    
    public function setUseStaticRegistry($useStaticRegistry)
    {
        $this->useStaticRegistry = $useStaticRegistry;
    }
    
    /**
     * @var $registry
     * @var $zendRegistryOption 
     */
    public function setRegistry(\Zend\Db\Registry $registry)
    {
        if ($this->useStaticRegistry === true) {
            if (\Zend\Registry::hasRegistry($this->registryName)) {
                throw new \RuntimeException('A registry is already registered statically by the name '
                    . $this->registryName . ', change the name, or set useStaticRegistry to false'
                    );
            }
            \Zend\Registry::registerRegistry($registry, $this->registryName);
        }
        $this->registry = $registry;
    }
    
    public function getRegistry()
    {
        $this->initializeRegistry();
        return $this->registry;
    }
    
    public function registry()
    {
        return $this->getRegistry();
    }
    
    public function adapter($name = null)
    {
        if ($name == null) {
            $name = $this->currentAdapterName;
        }
        
        $adapter = $this->registry()->getAdapter($name);
        $this->prepareObject($adapter);
        return $adapter;
    }
    
    public function eventManager()
    {
        return $this->registry()->getEventManager();
    }
    
    public function query()
    {
        $query = new \Zend\Db\Query\Query();
        $this->prepareObject($query);
        return $query;
    }
    
    public function tableGateway($tableName)
    {
        $tableGateway = new \Zend\Db\TableGateway\TableGateway($tableName);
        $this->prepareObject($tableGateway);
        return $tableGateway;
    }
    
    public function prepareObject($object, $clone = false)
    {
        if ($object instanceof DbPreparable) {
            $db = ($clone) ? clone $this : $this;
            $object->setDb($db);
        }
    }
    
    public function pluginManager()
    {
        $this->registry()->getPluginManager();
    }
    
    protected function initializeRegistry()
    {
        if ($this->registry) {
            return true;
        }
        
        // not present, perhaps we should consult static
        if (($this->useStaticRegistry === null || $this->useStaticRegistry === true)
            && (\Zend\Registry::hasRegistry($this->registryName))
            ) {
            $this->registry = \Zend\Registry::getRegistry($this->registryName);
            return;
        } else {
            throw new \RuntimeException('The Db class was unable to find a suitable registry');
        }
    }

    

    
}
