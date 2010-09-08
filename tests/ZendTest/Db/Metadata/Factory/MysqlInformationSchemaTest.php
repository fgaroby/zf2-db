<?php

namespace ZendTest\Db\Metadata\Factory;

class MysqlInformationSchemaTest extends \ZendTest\Db\TestAsset\TestCase
{
    /**
     * @var Zend\Db\Adapter\Adapter
     */
    protected $adapter = null;
    
    public function setup()
    {
        $this->requireAdapter(self::ADAPTER_MYSQL_VIA_PREFERRED);
        $this->adapter = $this->zendDb->getAdapterRegistry()->offsetGet(self::ADAPTER_MYSQL_VIA_PREFERRED);
    }
    
    public function testReturnsEmptyArrayForCatalogs()
    {
        $informationSchema = new \Zend\Db\Metadata\Factory\Interrogator\InformationSchema($this->adapter);
        $catalogs = $informationSchema->getCatalogs();
        $this->assertType('array', $catalogs);
        $this->assertEquals(0, count($catalogs));
    }
    
    public function testReturnsCurrentDatabaseInSchemas()
    {
        $informationSchema = new \Zend\Db\Metadata\Factory\Interrogator\InformationSchema($this->adapter);
        $schemas = $informationSchema->getSchemas();
        $this->assertContains(TESTS_ZEND_DB_ADAPTER_MYSQL_DATABASE, $schemas);
    }
    
    
}
