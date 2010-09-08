<?php

namespace ZendTest\Db\TestAsset;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    const ADAPTER_GENERAL = 'general';
    const ADAPTER_MYSQL_VIA_PREFERRED = 'mysqlViaPreferred';
    const ADAPTER_MYSQL_VIA_PDO = 'mysqlViaPdo';
    const ADAPTER_MYSQL_VIA_MYSQLI = 'mysqliViaMysqli';
    
    /**
     * @var Zend\Db\Db
     */
    protected $zendDb = null;
    
    public function setZendDb(\Zend\Db\Db $zendDb)
    {
        $this->zendDb = $zendDb;
    }
    
    public function requireAdapter($adapterName = self::ADAPTER_GENERAL)
    {
        $adapterRegistry = $this->zendDb->getAdapterRegistry();
        if (!$adapterRegistry->offsetExists($adapterName)) {
            $this->markTestSkipped('Skipping this test since the adapter ' . $adapterName . ' is not available');
        }
    }
    
}
