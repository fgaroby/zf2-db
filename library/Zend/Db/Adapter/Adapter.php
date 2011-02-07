<?php

namespace Zend\Db\Adapter;

use Zend\Db\Adapter\Driver;

class Adapter
{
    const QUERY_EXECUTE = 'queryExecute';
    const QUERY_PREPARE = 'queryPrepare';
    
    const DEFAULT_DRIVER_NAMESPACE = '\Zend\Db\Adapter\Driver';
    
	/**
	 * @var string
	 */
	protected $name = null;
	
	/**
	 * @var \Zend\Db\Adapter\Driver\DriverInterface
	 */
    protected $driver = null;
    
    protected $queryMode = self::QUERY_PREPARE;
    
    protected $queryReturnClass = '\Zend\Db\ResultSet\ResultSet';
    
    protected $platform = null;
    
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
    	$this->name = $name;
    	return $this;
    }
    
    /**
     * getName()
     * 
     * @return string
     */
    public function getName()
    {
    	return $this->name;
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
        
        $this->driver = $driver;
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
    	if ($this->driver == null) {
    		throw new \Exception('Driver has not been set.');
    	}
    	return $this->driver;
    }
    
    public function setQueryMode($queryMode)
    {
        if (!in_array($queryMode, array(self::QUERY_EXECUTE, self::QUERY_PREPARE))) {
            throw new \InvalidArgumentException('mode must be one of query_execute or query_prepare');
        }
        
        $this->queryMode = $queryMode;
        return $this;
    }

    public function getPlatform()
    {
        if (!isset($this->platform)) {
            $this->platform = new Platform\Mysql\Mysql;
        }
    }
    
    /**
     * query() is a convienince function
     * 
     * @return Zend\Db\ResultSet\ResultSetInterface
     */
    public function query($sql, $prepareOrExecute = self::QUERY_PREPARE)
    {
        $c = $this->getDriver()->getConnection();
        return ($prepareOrExecute == self::QUERY_EXECUTE) ? $c->execute($sql) : $c->prepare($sql);
    }

}
