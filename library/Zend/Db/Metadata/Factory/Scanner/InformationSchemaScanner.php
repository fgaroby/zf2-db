<?php

namespace Zend\Db\Metadata\Factory\Scanner;

use Zend\Db\Adapter;

class InformationSchemaScanner implements ScannerInterface
{
    /**
     * @var Zend\Db\Adapter\Adapter
     */
    protected $_adapter = null;
    
    protected $_includeInformationSchemaInResult = false;
    
    public function __construct(\Zend\Db\Adapter\Adapter $adapter, $includeInformationSchemaInResult = false)
    {
        $this->_adapter = $adapter;
        $this->_includeInformationSchemaInResult = $includeInformationSchemaInResult;
    }
    
    public function getCatalogs()
    {
        $sql = 'SELECT DISTINCT(TABLE_CATALOG) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_CATALOG IS NOT NULL';
        if ($this->_includeInformationSchemaInResult == false) {
            $sql .= ' AND UPPER(TABLE_SCHEMA) != "INFROMATION_SCHEMA"';
        }
        $resultset = $this->_adapter->query($sql, Adapter\Adapter::QUERY_EXECUTE);
        $results = array();
        foreach ($resultset as $resultRow) {
            $results[] = $resultRow['TABLE_CATALOG'];
        }
        return $results;
    }
    
    public function getSchemas($catalog = null)
    {
        $sql = 'SELECT DISTINCT(TABLE_SCHEMA) FROM INFORMATION_SCHEMA.TABLES';
        if ($this->_includeInformationSchemaInResult == false) {
            $sql .= ' WHERE UPPER(TABLE_SCHEMA) != "INFORMATION_SCHEMA"';
        }
        $resultset = $this->_adapter->query($sql, Adapter\Adapter::QUERY_EXECUTE);
        $results = array();
        foreach ($resultset as $resultRow) {
            $results[] = $resultRow['TABLE_SCHEMA'];
        }
        return $results;
    }
    
    public function getTables($schema = null, $catalog = null)
    {
        $sql = 'SELECT DISTINCT TABLE_SCHEMA, TABLE_NAME FROM INFORMATION_SCHEMA.TABLES'
            . ' WHERE TABLE_SCHEMA = "' . $schema . '"';
        if ($this->_includeInformationSchemaInResult == false) {
            $sql .= ' AND TABLE_SCHEMA != "INFORMATION_SCHEMA"';
        }

        $results = $this->_adapter->query($sql, Adapter\Adapter::QUERY_EXECUTE);
        return $results;
        // @todo
    }
    
    public function getColumns($table, $schema = null, $catalog = null)
    {
        $sql = 'SELECT * FROM COLUMNS WHERE TABLE_SCHEMA = "' . $table 
            . ' AND TABLE_NAME LIKE "' . $table . '"';

        $results = $this->_adapter->query($sql, Adapter\Adapter::QUERY_EXECUTE);
    }
    
    public function getTriggers($schema = null, $catalog = null) {}
    public function getConstraints($table, $schema = null, $catalog = null) {}
    public function getViews($schema = null, $catalog = null) {}
    
}
