<?php

namespace Zend\Db\Adapter;

interface DriverStatement
{
    const BIND_TYPE_NULL = 'null';
    const BIND_TYPE_DOUBLE = 'double';
    const BIND_TYPE_INTEGER = 'integer';
    const BIND_TYPE_STRING = 'string';
    const BIND_TYPE_BLOB = 'blob';
    
    public function __construct(Driver $driver, array $defaultStatementOptions);
    public function setAdapter(\Zend\Db\Adapter $adapter);
    public function getResource();
    public function setSQL($sql);
    public function getSQL();
    public function execute();
}
