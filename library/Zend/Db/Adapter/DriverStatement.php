<?php

namespace Zend\Db\Adapter;

interface DriverStatement
{
    public function __construct(Driver $driver, array $defaultStatementOptions);
    public function setAdapter(\Zend\Db\Adapter $adapter);
    public function getResource();
    public function setSQL($sql);
    public function getSQL();
    public function execute($parameters = null);
}
