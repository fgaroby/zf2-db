<?php

namespace Zend\Db\Metadata;

class Metadata
{
    protected $defaultCatalog = null;
    protected $defaultSchema = null;
    
    protected $catalogs = array();
    protected $schemas = array();
    protected $tables = array();
    
    public function getTable($tableName, $schemaName = null, $catalogName = null)
    {
        
    }
    
    public function getTrigger($triggerName, $schemaName = null, $catalogName = null)
    {
        
    }
    
    public function getView($viewName, $schemaName = null, $catalogName = null)
    {
        
    }
    
}
