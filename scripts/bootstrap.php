<?php

set_include_path(realpath(__DIR__ . '/../library'));

spl_autoload_register(function ($class) { require_once ltrim(str_replace('\\', '/', $class), '/') . '.php'; });

$ini = parse_ini_file('./config.ini');

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