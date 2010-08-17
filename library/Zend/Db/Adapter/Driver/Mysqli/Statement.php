<?php

namespace Zend\Db\Adapter\Driver\MySQLi;
use Zend\Db\Adapter\Driver;

class Statement implements Driver\StatementInterface
{
    protected $_driver = null;
    protected $_resource = null;
    
    public function __construct(Driver\AbstractDriver $driver, $defaultOptions, \mysqli_stmt $mysqliStmt)
    {
        $this->_driver = $driver;
        $this->_resource = $mysqliStmt;
    }
    
    public function getResource() {}
    public function setSQL($sql) {}
    public function getSQL() {}
    public function execute() {}
}
