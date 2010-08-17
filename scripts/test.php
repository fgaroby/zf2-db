<?php

set_include_path(realpath(__DIR__ . '/../library'));

spl_autoload_register(function ($class) { require_once ltrim(str_replace('\\', '/', $class), '/') . '.php'; });

$config = array(
    'adapter' => array(
        'name'   => 'MysqlConnection',
        'driver' => array(
            'type' => 'Mysqli',
	        'connectionParams' => array(
	            'username' => 'developer',
	            'password' => 'developer',
	            'dbname'   => 'zend_dbal'
	            )
            )
        )
    );


$db = new \Zend\Db\Db($config);
$adapter = $db->getAdapter();
$connection = $adapter->getConnection();
$connection->connect();
$x = $connection->execute('SELECT * FROM foo');
foreach ($x as $y) {
    var_dump($y);
}