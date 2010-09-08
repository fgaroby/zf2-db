<?php

namespace ZendTest\Db\TestAsset;

use Zend\Db;

class TestListener implements \PHPUnit_Framework_TestListener
{
    /**
     * @var Zend\Db\Db
     */
    protected $zendDb = null;
    
    /**
     * @var array used for tracking depth of suites
     */
    protected $trackedSuites = array();
    
    public function addError(\PHPUnit_Framework_Test $test, \Exception $e, $time) { /** unused method in PHPUnit_Framework_TestListener interface **/ }
    public function addFailure(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_AssertionFailedError $e, $time) { /** unused method in PHPUnit_Framework_TestListener interface **/ }
    public function addIncompleteTest(\PHPUnit_Framework_Test $test, \Exception $e, $time) { /** unused method in PHPUnit_Framework_TestListener interface **/ }
    public function addSkippedTest(\PHPUnit_Framework_Test $test, \Exception $e, $time) { /** unused method in PHPUnit_Framework_TestListener interface **/ }

    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        $this->trackedSuites[spl_object_hash($suite)] = true;
        if ($this->zendDb == null) {
            $this->setupZendDb();
        }
    }

    public function endTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        unset($this->trackedSuites[spl_object_hash($suite)]);
        if (count($this->trackedSuites) == 0) {
            $this->cleanup();
        }
    }

    public function startTest(\PHPUnit_Framework_Test $test)
    {
        if ($test instanceof \ZendTest\Db\TestAsset\TestCase) {
            $test->setZendDb($this->zendDb);
        }
    }

    public function endTest(\PHPUnit_Framework_Test $test, $time)
    {
        if ($test instanceof \ZendTest\Db\TestAsset\TestCase) {
            
        }
    }

    protected function setupZendDb()
    {
        $connectionParamsMysql = array(
            'hostname' => TESTS_ZEND_DB_ADAPTER_MYSQL_HOSTNAME,
            'username' => TESTS_ZEND_DB_ADAPTER_MYSQL_USERNAME,
            'password' => TESTS_ZEND_DB_ADAPTER_MYSQL_PASSWORD,
            'dbname'   => TESTS_ZEND_DB_ADAPTER_MYSQL_DATABASE,
            'port'     => TESTS_ZEND_DB_ADAPTER_MYSQL_PORT
            );

        $adapterOptions = array();
        
        if (TESTS_ZEND_DB_ADAPTER_MYSQLI_ENABLED) {
            $adapterOptions[] = array(
                'name' => 'mysqlViaMysqli',
                'driver' => array(
                    'type' => 'Mysqli',
                    'connectionParams' => $connectionParamsMysql
                    )
                );
        }
        
        if (TESTS_ZEND_DB_ADAPTER_PDOMYSQL_ENABLED) {
            $adapterOptions[] = array(
                'name' => 'mysqlViaPdo',
                'driver' => array(
                    'type' => 'Pdo',
                    'connectionParams' => $connectionParamsMysql
                    )
                );
        }
            
        $options = array('adapters' => $adapterOptions);

        $this->zendDb = new \Zend\Db\Db($options);

        $adapterRegistry = $this->zendDb->getAdapterRegistry();

        // setup preferred mysql adapter
        $mysqlViaPreferred = (in_array(TESTS_ZEND_DB_ADAPTER_MYSQL_PREFERRED, array('Mysqli', 'Pdo'))) ? 'mysqliVia' . TESTS_ZEND_DB_ADAPTER_MYSQL_PREFERRED : null;
        if ($mysqlViaPreferred && $adapterRegistry->offsetExists('mysqlViaPdo') && $adapterRegistry->offsetExists('mysqlViaMysqli')) {
            $adapterRegistry->offsetSet('mysqlViaPreferred', $adapterRegistry->offsetGet($mysqlViaPreferred));
        } else {
            if ($adapterRegistry->offsetExists('mysqlViaMysqli')) {
                $adapterRegistry->offsetSet('mysqlViaPreferred', $adapterRegistry->offsetGet('mysqlViaMysqli'));
            } elseif ($adapterRegistry->offsetExists('mysqlViaMysqli')) {
                $adapterRegistry->offsetSet('mysqlViaPreferred', $adapterRegistry->offsetGet('mysqlViaPdo'));
            }
        }
        
    }
    
    protected function cleanup()
    {
        echo "\n" . __CLASS__ . ': cleaning up after myself' . "\n";
    }
    
}
