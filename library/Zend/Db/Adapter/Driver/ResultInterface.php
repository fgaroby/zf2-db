<?php

namespace Zend\Db\Adapter\Driver;

use Zend\Db\ResultSet\DataSource as ResultSetDataSource;

interface ResultInterface extends ResultSetDataSource\DataSourceInterface
{
    public function __construct(AbstractDriver $driver, array $defaultResultOptions);
	public function getResource();
}
