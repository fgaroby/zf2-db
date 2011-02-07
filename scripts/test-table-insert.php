<?php

$db = include 'bootstrap.php';

$db->tableGateway('foo')->insert(array('bar' => rand(1, 10)));

