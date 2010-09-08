<?php


$adapter = $db->getAdapter();
$connection = $adapter->getConnection();
$connection->connect();
$x = $connection->execute('SELECT * FROM foo');
foreach ($x as $y) {
    var_dump($y);
}