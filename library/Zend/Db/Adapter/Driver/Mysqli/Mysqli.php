<?php

namespace Zend\Db\Adapter\Driver\Mysqli;
use Zend\Db\Adapter\Driver;

class Mysqli extends Driver\AbstractDriver
{
    protected $_connectionClass = '\Zend\Db\Adapter\Driver\Mysqli\Connection';
    protected $_statementClass = '\Zend\Db\Adapter\Driver\Mysqli\Statement';
    protected $_resultClass = '\Zend\Db\Adapter\Driver\Mysqli\Result';
    
    public function checkEnvironment()
    {
        if (!extension_loaded('mysqli')) {
            throw new \Exception('The Mysqli extension is required for this adapter but the extension is not loaded');
        }
    }
}
