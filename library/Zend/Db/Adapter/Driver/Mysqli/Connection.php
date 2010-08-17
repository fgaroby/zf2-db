<?php

namespace Zend\Db\Adapter\Driver\Mysqli;
use Zend\Db\Adapter\Driver;

class Connection implements Driver\ConnectionInterface
{
	/**
	 * @var \Zend\Db\Adapter\Driver\DriverAbstract
	 */
	protected $_driver = null;
	
	protected $_connectionParams = array();
	
	/**
	 * @var \mysqli
	 */
    protected $_resource = null;

    protected $_inTransaction = false;
    
    protected $_openMysqliResultSets = array();
    
    public function __construct(Driver\AbstractDriver $driver, array $connectionParameters)
    {
        $this->_driver = $driver;
        $this->_connectionParams = $connectionParameters;
    }
    
    /**
     * @return \Mysqli
     */
    public function getResource()
    {
    	return $this->_resource;
    }
    
    public function connect()
    {
        if ($this->_resource) {
            return;
        }

        $host = $username = $password = $dbname = $port = $socket = null;
        foreach (array('host', 'username', 'password', 'dbname', 'port', 'socket') as $c) {
        	if (isset($this->_connectionParams[$c])) {
                switch ($c) {
                    case 'port': 
                        $this->_connectionParams[$c] = (int) $this->_connectionParams[$c];
                    default:
                        $$c = $this->_connectionParams[$c];
                }
        	}
        }
        
        $this->_resource = new \mysqli($host, $username, $password, $dbname, $port, $socket);

        if ($this->_resource->connect_error) {
            throw new \Exception('Connect Error (' . $this->_resource->connect_errno . ') ' . $this->_resource->connect_error);
        }

        if (!empty($this->_connectionParams['charset'])) {
            $this->_resource->set_charset($this->_resource, $this->_connectionParams['charset']);
        }

    }
    
    public function isConnected()
    {
    	return ($this->_resource instanceof Mysqli);
    }
    
    public function disconnect()
    {
        $this->_resource->close();
    	unset($this->_resource);
    }
    
    public function beginTransaction()
    {
        $this->_resource->autocommit(false);
        $this->_inTransaction = true;
    }
    
    public function commit()
    {
        if (!$this->_resource) {
            $this->connect();
        }
        
        $this->_resource->commit();
        
        $this->_inTransaction = false;
    }
    
    public function rollback()
    {
        if (!$this->_resource) {
            throw new \Exception('Must be connected before you can rollback.');
        }
        
        if (!$this->_inCommit) {
            throw new \Exception('Must call commit() before you can rollback.');
        }
        
        $this->_resource->rollback();
        return $this;
    }
    
    
    public function execute($sql)
    {
    	if (!$this->_resource) {
    		$this->connect();
    	}
    	
    	$resultClass = $this->_driver->getResultClass();
    	
    	$returnValue = $this->_resource->query($sql);
    	
    	if ($returnValue instanceof \mysqli_result) {
            $this->_openMysqliResultSets[] = $result = new \Zend\Db\ResultSet\ResultSet(
               new $resultClass($this->_driver, array(), $returnValue)
               );
            return $result;
    	}
    	
        return $returnValue;
    }
    
    public function prepare($sql)
    {
        if (!$this->_resource) {
            $this->connect();
        }
        
        $statementClass = $this->_driver->getStatementClass();
        
        $statement = new $statementClass($this->_driver, array(), $this->_resource->prepare($sql));

        return $statement;
    }

}
    