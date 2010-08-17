<?php

namespace Zend\Db;

class Db // implements Zend\Application\ResourceContainer?
{
    protected static $_adapterRegistry = null;
    
    /**
     * @var \Zend\Db\Adapter\Adapter
     */
    protected $_defaultAdapter = null;
    
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
    
    public static function getAdapterRegistry()
    {
        if (self::$_adapterRegistry == null) {
            self::$_adapterRegistry = new Adapter\Registry();
        }
        return self::$_adapterRegistry;
    }
    
    public function setAdapter($adapter)
    {
    	return $this->setDefaultAdapter($adapter);
    }
    
    public function setDefaultAdapter($defaultAdapter)
    {
    	if (is_array($defaultAdapter)) {
    		$defaultAdapter = new \Zend\Db\Adapter\Adapter($defaultAdapter);
    	}
    	
    	if (!($defaultAdapter instanceof \Zend\Db\Adapter\Adapter)) {
    		throw new \Exception();
    	}
    	
    	$this->_defaultAdapter = $defaultAdapter;
    	return $this;
    }
    
    public function getDefaultAdapter()
    {
    	return $this->_defaultAdapter;
    }
    
    /**
     * @return \Zend\Db\Adapter\Adapter
     */
    public function getAdapter()
    {
        return $this->getDefaultAdapter();
    }
    
    public function getQuery()
    {
        return new \Zend\Db\Query\Query;
    }
    
}
