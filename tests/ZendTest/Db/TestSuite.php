<?php

namespace ZendTest\Db;

class TestSuite extends \PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $testSuite = new TestSuite();
        $testSuite->addTestSuite('\ZendTest\Db\Metadata\Factory\MysqlInformationSchemaTest');
        return $testSuite;
    }
 
    protected function setUp()
    {
    }
 
    protected function tearDown()
    {
    }
}
