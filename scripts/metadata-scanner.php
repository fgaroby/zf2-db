<?php

/* @var $db Zend\Db\Db */
$db = include_once 'bootstrap.php';

$a = $db->getAdapter();

$metadataFactory = new Zend\Db\Metadata\Factory\Factory;
$metadata = $metadataFactory->createFromScanner(new Zend\Db\Metadata\Factory\Scanner\InformationSchemaScanner($a));

var_dump($metadata);

//$adapter = $db->getAdapter();

