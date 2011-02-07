<?php

namespace Zend\Db\Metadata;

class Constraint extends AbstractMetadata
{
    protected $catalogName = null;
    protected $schemaName = null;
    protected $tableCatalogName = null;
    protected $tableSchemaName = null;
    protected $tableName = null;
    protected $constraintType = null;
    protected $constraintKeyCollection = null;
    
    public function __construct()
    {
        $this->constraintKeyCollection = new ConstraintKeyCollection();
    }
    
    public function getCatalogName()
    {
        return $this->catalogName;
    }
    
    public function setCatalogName($catalogName)
    {
        $this->catalogName = $catalogName;
        return $this;
    }
    
    public function getSchemaName()
    {
        return $this->schemaName;
    }
    
    public function setSchemaName($schemaName)
    {
        $this->schemaName = $schemaName;
        return $this;
    }
    
    
    public function getTableCatalogName()
    {
        return $this->tableCatalogName;
    }
    
    public function setTableCatalogName($tableCatalogName)
    {
        $this->tableCatalogName = $tableCatalogName;
        return $this;
    }
    
    public function getTableSchemaName()
    {
        return $this->tableSchemaName;
    }
    
    public function setTableSchemaName($tableSchemaName)
    {
        $this->tableSchemaName = $tableSchemaName;
        return $this;
    }
    
    public function getTableName()
    {
        return $this->tableName;
    }
    
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function setConstraintType($constraintType)
    {
        $this->constraintType = $constraintType;
    }
    
    public function getType()
    {
        return $this->constraintType;
    }
    
    public function getConstraintKeyCollection()
    {
        return $this->constraintKeyCollection;
    }
}