<?php

namespace Zend\Db\Metadata;

class Schema
{
    protected $name = null;
    protected $tables = null;
    
    public function __construct()
    {
        $this->tables = new TableCollection();
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setTable(Table $table)
    {
        $this->tables[] = $table;
    }
    
}