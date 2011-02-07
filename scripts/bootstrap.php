<?php

set_include_path(
    realpath(__DIR__ . '/../library')
    . PATH_SEPARATOR . realpath(__DIR__ . '/../../ZFGit/library/')
    );

spl_autoload_register(function ($class) { require_once ltrim(str_replace('\\', '/', $class), '/') . '.php'; });

$ini = parse_ini_file('./config.ini');

$adapter = new Zend\Db\Adapter\Adapter();
$adapter->setDriver(array(
    'type' => 'Mysqli',
    'connectionParams' => array(
        'username' => $ini['username'],
        'password' => $ini['password'],
        'dbname'   => $ini['dbname']
        )
    ));
$adapter->query('Select * From Foo', \Zend\Db\Adapter\Adapter::QUERY_EXECUTE);
die();

$config = array(
    'adapter' => array(
        'name'   => 'MysqlConnection',
        'driver' => array(
            'type' => 'Mysqli',
            'connectionParams' => array(
                'username' => $ini['username'],
                'password' => $ini['password'],
                'dbname'   => $ini['dbname']
                )
            )
        )
    );

return new \Zend\Db\Db($config);