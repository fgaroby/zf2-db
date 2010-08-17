<?php

namespace Zend\Db\Adapter\Driver;

abstract class AbstractDriver
{
	protected $_connectionClass = null;
	protected $_statementClass = null;
	protected $_resultClass = null;
    protected $_defaultConnectionParams = array();
    protected $_defaultStatementParams = array();
    protected $_defaultResultParams = array();
    
    public function __construct($options = array())
    {
    	if ($options) {
    		$this->setOptions($options);
    	}
    	
    	if ($this->getConnectionClass() == null 
    	    || $this->getStatementClass() == null
    	    || $this->getResultClass() == null
    	    ) {
    		throw new \Exception('This driver does not have a connection, statement, or result class set.');
    	}
    	
    	$this->checkEnvironment();
    }
    
    abstract public function checkEnvironment();
    
    public function setOptions(array $options)
    {
        foreach ($options as $optionName => $optionValue) {
            if (method_exists($this, 'set' . $optionName)) {
                $this->{'set' . $optionName}($optionValue);
            }
        }
    }
    
    public function setConnectionClass($connectionClass)
    {
    	$this->_connectionClass = $connectionClass;
    	return $this;
    }
    
    public function getConnectionClass()
    {
        return $this->_connectionClass;
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
    	$this->_statementClass = $statementClass;
    	return $this;
    }

    public function getStatementClass()
    {
        return $this->_statementClass;
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
        $this->_resultClass = $resultClass;
        return $this;
    }

    public function getResultClass()
    {
        return $this->_resultClass;
    }
    
    public function setResultParams($resultClass)
    {
        $this->_resultClass = $resultClass;
        return $this;
    }
    
    public function getResultParams()
    {
        return $this->_resultClass;
    }
    
}
