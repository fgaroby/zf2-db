<?php

/* @var $db Zend\Db\Db */
$db = include_once 'bootstrap.php';

$adapter = $db->adapter();
$connection = $adapter->getConnection();
$connection->connect();
$x = $connection->execute('SELECT * FROM foo');
foreach ($x as $y) {
    var_dump($y);
}