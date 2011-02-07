<?php

namespace Zend\Db\Adapter\Driver;

abstract class AbstractDriver
{
    const NAME_FORMAT_CAMELCASE = 'camelCase';
    const NAME_FORMAT_NATURAL = 'natural';
    protected $adapter = null;
	protected $connectionClass = null;
	protected $statementClass = null;
	protected $resultClass = null;
    protected $connectionParams = array();
    protected $statementParams = array();
    protected $resultParams = array();
    
    protected $connection = null;

    public function __construct($options = array())
    {
    	if ($options) {
    		$this->setOptions($options);
    	}
    	
    	if ($this->getConnectionClass() == null 
    	    || $this->getStatementClass() == null
    	    || $this->getResultClass() == null
    	    ) {
    		throw new \Exception('This extension wrapper does not have a connection, statement, or result class set.');
    	}
    	
    	$this->checkEnvironment();
    }
    
    abstract public function getDatabasePlatformName($nameFormat = self::NAME_FORMAT_CAMELCASE);
    
    abstract public function checkEnvironment();
    
    public function setOptions(array $options)
    {
        foreach ($options as $optionName => $optionValue) {
            if (method_exists($this, 'set' . $optionName)) {
                $this->{'set' . $optionName}($optionValue);
            }
        }
    }
    
    public function setAdapter(\Zend\Db\Adapter\Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
    
    public function setConnectionClass($connectionClass)
    {
    	$this->connectionClass = $connectionClass;
    	return $this;
    }
    
    public function getConnectionClass()
    {
        return $this->connectionClass;
    }
    
    public function setConnectionParams($connectionParams)
    {
    	$this->_connectionParams = $connectionParams;
    	return $this;
    }
    
    public function getConnectionParams()
    {
    	return $this->_connectionParams;
    }
    
    
    public function setStatementClass($statementClass)
    {
    	$this->statementClass = $statementClass;
    	return $this;
    }

    public function getStatementClass()
    {
        return $this->statementClass;
    }
    
    public function setStatementParams($statementParams)
    {
        $this->_statementParams = $statementParams;
        return $this;
    }
    
    public function getStatementParams()
    {
        return $this->_statementParams;
    }
    
    
    public function setResultClass($resultClass)
    {
        $this->resultClass = $resultClass;
        return $this;
    }

    public function getResultClass()
    {
        return $this->resultClass;
    }
    
    public function setResultParams($resultClass)
    {
        $this->resultClass = $resultClass;
        return $this;
    }
    
    public function getResultParams()
    {
        return $this->resultClass;
    }
    

    /**
     * setConnection()
     * 
     * @param $connection
     */
    public function setConnection(ConnectionInterface $connection)
    {
    	$this->connection = $connection;
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
    	if ($this->connection == null) {
	    	$connectionClass = $this->getConnectionClass();
	        $this->setConnection(new $connectionClass($this, $this->getConnectionParams()));
    	}
    	return $this->connection;
    }

    
    
}
