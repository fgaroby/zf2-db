<?php

namespace ZendTest\Db\Adapter;

abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    
    final public function setUp()
    {
        $suite = $this->result->topTestSuite();
//        if ($suite->getName() !== 'Zend\Db Test Suite') {
//            $this->markTestSkipped(__CLASS__ . ' must be run as part of the Adapter Test Suite.');
//        }
        
    }
    
}