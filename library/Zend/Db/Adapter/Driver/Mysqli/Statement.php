<?php

namespace Zend\Db\Adapter\Driver\Mysqli;
use Zend\Db\Adapter\Driver;

class Statement implements Driver\StatementInterface
{
    protected $adapter = null;
    protected $driver = null;
    protected $resource = null;
    
    public function __construct(Driver\AbstractDriver $driver, array $defaultOptions, \mysqli_stmt $resource = null)
    {
        $this->driver = $driver;
        $this->resource = $resource;
    }
    
    public function setAdapter(\Zend\Db\Adapter\Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
    
    public function getResource() {}
    public function setSQL($sql) {}
    public function getSQL() {}
    public function execute() {}
}
