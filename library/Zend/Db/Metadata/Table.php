<?php

namespace Zend\Db\Metadata;

class Table extends AbstractMetadata
{
    protected $catalogName = null;
    protected $schemaName = null;
    protected $type = null;
    
    protected $columnCollection = null;
    protected $constraintCollection = null;
    
    public function __construct()
    {
        $this->columnCollection = new ColumnCollection();
        $this->constraintCollection = new ConstraintCollection();
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
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    
    public function getColumnCollection()
    {
        return $this->columnCollection;
    }
    
    public function getConstraintCollection()
    {
        return $this->constraintCollection;
    }
    
}