<?php

namespace Zend\Db\Metadata\Factory\Scanner;

interface ScannerInterface
{
    public function getCatalogs();
    public function getSchemas($catalog = null);
    public function getTables($schema = null, $catalog = null);
    public function getColumns($table, $schema = null, $catalog = null);
    public function getTriggers($schema = null, $catalog = null);
    public function getConstraints($table, $schema = null, $catalog = null);
    public function getViews($schema = null, $catalog = null);
}
