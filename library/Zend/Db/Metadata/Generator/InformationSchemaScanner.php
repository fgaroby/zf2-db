<?php

namespace Zend\Db\Metadata\Generator\Scanner;

use Zend\Db\Adapter\Driver;

use Zend\Db\Adapter;

class InformationSchemaScanner implements ScannerInterface
{
    /**
     * @var Zend\Db\Adapter\Adapter
     */
    protected $adapter = null;
    
    protected $includeInformationSchemaInResult = false;
    
    public function __construct(\Zend\Db\Adapter\Adapter $adapter, $includeInformationSchemaInResult = false)
    {
        $this->adapter = $adapter;
        $this->includeInformationSchemaInResult = $includeInformationSchemaInResult;
    }
    
    public function getCatalogs()
    {
        $sql = 'SELECT DISTINCT(TABLE_CATALOG) as catalogName FROM INFORMATION_SCHEMA.SCHEMATA WHERE CATALOG_NAME IS NOT NULL';
        if ($this->includeInformationSchemaInResult == false) {
            $sql .= ' AND UPPER(SCHEMA_NAME) != "INFROMATION_SCHEMA"';
        }
        
        return $this->createResultSetFromSql($sql, 'catalogName');
    }
    
    public function getSchemas($catalog = null)
    {
        $sql = 'SELECT SCHEMA_NAME as schemaName FROM INFORMATION_SCHEMA.SCHEMATA';

        $sqlWheres = array();
        if ($this->includeInformationSchemaInResult == false) {
            $sqlWheres[] = 'TABLE_SCHEMA != "INFORMATION_SCHEMA"';
        }
        
        if ($sqlWheres) {
            $sql .= ' WHERE ' . implode(' AND ', $sqlWheres);
        }
        
        return $this->createResultSetFromSql($sql, 'schemaName');
    }
    
    public function getTables($schema = null, $catalog = null)
    {
        $sql = 'SELECT TABLE_NAME as tableName FROM INFORMATION_SCHEMA.TABLES';

        $sqlWheres = array();
        
        if ($schema) {
            $sqlWheres[] = 'TABLE_SCHEMA = "' . $schema . '"';
        }
        
        if ($this->includeInformationSchemaInResult == false) {
            $sqlWheres[] = 'TABLE_SCHEMA != "INFORMATION_SCHEMA"';
        }
        
        if ($sqlWheres) {
            $sql .= ' WHERE ' . implode(' AND ', $sqlWheres);
        }
        
        return $this->createResultSetFromSql($sql, 'tableName');

    }
    
    public function getTriggers($schema = null, $catalog = null) {}
    
    public function getViews($schema = null, $catalog = null) {}
    
    public function getColumns($table, $schema = null, $catalog = null)
    {
        $columnMapping = array(
            'TABLE_CATALOG' => 'catalogName',
            'TABLE_SCHEMA' => 'schemaName',
            'TABLE_NAME' => 'tableName',
            'COLUMN_NAME' => 'name',
            'ORDINAL_POSITION' => 'ordinalPosition',
        	'COLUMN_DEFAULT' => 'columnDefault',
        	'IS_NULLABLE' => 'isNullable',
        	'DATA_TYPE' => 'dataType',
            'CHARACTER_MAXIMUM_LENGTH' => 'characterMaximumLength',
            'CHARACTER_OCTET_LENGTH' => 'characterOctetLength',
            'NUMERIC_PRECISION' => 'numericPrecision',
            'NUMERIC_SCALE' => 'numericScale',
            'CHARACTER_SET_NAME' => 'characterSetName',
            'COLLATION_NAME' => 'collationName',
            );
        
        $sql = 'SELECT ' . $this->createColumnMappingSql($columnMapping) 
            . ' FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = "' . $table . '"';

        if ($schema != null) {
            $sql .= ' AND TABLE_SCHEMA = "' . $schema . '"';
        }
        
        return $this->createResultSetFromSql($sql);
    }
    
    public function getConstraints($table, $schema = null, $catalog = null)
    {
        $columnMapping = array(
            'CONSTRAINT_CATALOG' => 'catalogName',
            'CONSTRAINT_SCHEMA' => 'schemaName',
            'CONSTRAINT_NAME' => 'name',
            'TABLE_SCHEMA' => 'tableSchemaName',
            'TABLE_NAME' => 'tableName',
            'CONSTRAINT_TYPE' => 'constraintType'
            );

        $sql = 'SELECT ' . $this->createColumnMappingSql($columnMapping) 
            . ' FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE TABLE_NAME = "' . $table . '"';
        if ($schema != null) {
            $sql .= ' AND TABLE_SCHEMA = "' . $schema . '"';
        }

        return $this->createResultSetFromSql($sql);
    }
    
    public function getConstraintKeys($constraint, $table, $schema = null, $catalog = null)
    {
        $columnMapping = array(
            'CONSTRAINT_CATALOG' => 'catalogName',
            'CONSTRAINT_SCHEMA' => 'schemaName',
            'CONSTRAINT_NAME' => 'name',
            'TABLE_CATALOG' => 'tableCatalogName',
            'TABLE_SCHEMA' => 'tableSchemaName',
            'TABLE_NAME' => 'tableName',
            'COLUMN_NAME' => 'columnName',
            'ORDINAL_POSITION' => 'ordinalPosition',
            'POSITION_IN_UNIQUE_CONSTRAINT' => 'positionInUniqueConstraint',
            'REFERENCED_TABLE_SCHEMA' => 'referencedTableSchema',
            'REFERENCED_TABLE_NAME' => 'referencedTableName',
            'REFERENCED_COLUMN_NAME' => 'referencedColumnName'
            );
        	
        $sql = 'SELECT ' . $this->createColumnMappingSql($columnMapping)
            . ' FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE '
        	. 'CONSTRAINT_NAME = "' . $constraint . '" AND TABLE_SCHEMA = "' . $table . '"';

        if ($schema != null) {
            $sql .= ' AND TABLE_SCHEMA = "' . $schema . '"';
        }

        return $this->createResultSetFromSql($sql);
    }
    
    public function getReferentialConstraints($schema = null, $catalog = null)
    {
        $columnMapping = array(
            'CONSTRAINT_CATALOG' => 'catalogName',
            'CONSTRAINT_SCHEMA' => 'schemaName',
            'CONSTRAINT_NAME' => 'name',
            'UNIQUE_CONSTRAINT_CATALOG' => 'uniqueConstraintCatalogName',
            'UNIQUE_CONSTRAINT_SCHEMA' => 'uniqueConstraintSchemaName',
            'UNIQUE_CONSTRAINT_NAME' => 'uniqueConstraintName',
            'MATCH_OPTION' => 'matchOption',
            'UPDATE_RULE' => 'updateRule',
            'DELETE_RULE' => 'deleteRule'
            );

        $sql = 'SELECT ' . $this->createColumnMappingSql($columnMapping) 
            . ' FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS';

        if ($schema != null) {
            $sql .= ' WHERE CONSTRAINT_SCHEMA = "' . $schema . '"';
        }

        return $this->createResultSetFromSql($sql);
    }
    
    protected function createColumnMappingSql(Array $columnMapping)
    {
        $sqls = array();
        foreach ($columnMapping as $dbName => $asName) {
            $sqls[] = $dbName . ' as ' . $asName;
        }
        return implode(', ', $sqls);
    }
    
    protected function createResultSetFromSql($sql, $returnColumn = null)
    {
        if (!($resultSet = $this->adapter->query($sql, Adapter\Adapter::QUERY_EXECUTE))) {
            throw new \Exception('error in sql ' . $sql);
        }
        if ($returnColumn == null) {
            return $resultSet;
        } else {
            if (!is_string($returnColumn)) {
                throw new InvalidArgumentException('$returnColumns must be a string');
            }
            $returnResultSet = array();
            foreach ($resultSet as $resultRow) {
                $returnResultSet[] = $resultRow[$returnColumn];
            }
            return $returnResultSet;
        }
    }
    
}
