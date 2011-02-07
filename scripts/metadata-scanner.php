<?php

/* @var $db Zend\Db\Db */
$db = include_once 'bootstrap.php';

use Zend\Db\Metadata\Factory as MetadataFactory;
use Zend\Db\Metadata\Display as MetadataDisplay;

$adapter = $db->getAdapter();

$metadataFactory = new MetadataFactory\Factory;
$metadataFactory->setSchemaFilter($adapter->getConnection()->getDefaultSchema());
$metadata = $metadataFactory->createFromScanner(
    new MetadataFactory\Scanner\InformationSchemaScanner($adapter)
    );

$display = new MetadataDisplay\TextUi();
echo $display->render($metadata);


