<?php

namespace Zend\Db\Adapter;

use Zend\Db\Adapter\Driver;

class Adapter
{

    
    const DEFAULT_DRIVER_NAMESPACE = '\Zend\Db\Adapter\Driver';
    
	/**
	 * @var string
	 */
	protected $_name = null;
	
	/**
	 * @var \Zend\Db\Adapter\Driver\DriverInterface
	 */
    protected $_driver = null;
    
    /**
     * @var \Zend\Db\Adapter\Driver\ConnectionInterface
     */
    protected $_connection = null;
    
    public function __construct($options = array())
    {
        if ($options) {
        	$this->setOptions($options);
        }
    }
    
    /**
     * setOptions()
     * 
     * @param array $options
     */
    public function setOptions(array $options)
    {
        foreach ($options as $optionName => $optionValue) {
            if (method_exists($this, 'set' . $optionName)) {
                $this->{'set' . $optionName}($optionValue);
            }
        }
    }
    
    /**
     * setName()
     * 
     * @param $name
     */
    public function setName($name)
    {
    	$this->_name = $name;
    	return $this;
    }
    
    /**
     * getName()
     * 
     * @return string
     */
    public function getName()
    {
    	return $this->_name;
    }
    
    /**
     * setDriver()
     * 
     * @param array|\Zend\Db\Adapter\Driver\AbstractDriver $driver
     */
    public function setDriver($driver)
    {
        if (is_array($driver)) {
        	$driverOptions = $driver;
        	if (isset($driverOptions['type']) && is_string($driverOptions['type'])) {
        		$className = $driverOptions['type'];
        		if ($driver['type']{0} != '\\') {
        			$className = self::DEFAULT_DRIVER_NAMESPACE . '\\' . $driverOptions['type'] . '\\' . $className;
        		}
        		unset($driverOptions['type']);
        	}
        	$driver = $className;
        }
            
        if (class_exists($driver, true)) {
        	$driver = new $driver;
        } else {
            throw new \InvalidArgumentException('Class by name ' . $driver . ' not found', null, null);
        }
        
        if (!$driver instanceof Driver\AbstractDriver) {
        	throw new \InvalidArgumentException('$driver provided is neither a driver class name or object of type DriverInterface', null, null);
        }
        
        if (isset($driverOptions)) {
        	$driver->setOptions($driverOptions);
        }
        
        $this->_driver = $driver;
        return $this;
    }
    
    /**
     * getDriver()
     * 
     * @throws Exception
     * @return \Zend\Db\Adapter\Driver\AbstractDriver
     */
    public function getDriver()
    {
    	if ($this->_driver == null) {
    		throw new \Exception('Driver has not been set.');
    	}
    	return $this->_driver;
    }
    
    /**
     * setConnection()
     * 
     * @param $connection
     */
    public function setConnection(Driver\ConnectionInterface $connection)
    {
    	$this->_connection = $connection;
    	return $this;
    }
    
    /**
     * getConnection()
     * 
     * This method will attempt to lazy-load the connection object if
     * if does not already exist in the adatper.
     * 
     * @return \Zend\Db\Adapter\Driver\ConnectionInterface
     */
    public function getConnection()
    {
    	if ($this->_connection == null) {
    		$driver = $this->getDriver();
	    	$connectionClass = $driver->getConnectionClass();
	        $this->setConnection(new $connectionClass($driver, $this->_driver->getConnectionParams()));
    	}
    	return $this->_connection;
    }

    
}
