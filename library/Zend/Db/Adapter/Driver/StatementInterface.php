<?php

namespace Zend\Db\Adapter\Driver;

interface StatementInterface
{
    public function __construct(AbstractDriver $driver, array $defaultStatementOptions);
    public function setAdapter(\Zend\Db\Adapter\Adapter $adapter);
    public function getResource();
    public function setSQL($sql);
    public function getSQL();
    public function execute();
}
