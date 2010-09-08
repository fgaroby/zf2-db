<?php

namespace Zend\Db\Metadata;

class Catalog
{
    protected $name = null;
    protected $schemas = null;
    
    public function __construct()
    {
        $this->tables = new SchemaCollection();
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setSchema(Table $table)
    {
        $this->schemas[] = $table;
    }
    
}