<?php

namespace Zend\Db\Metadata;

class Table
{
    protected $name = null;
    protected $columns = null;
    
    public function __construct()
    {
        $this->columns = new ColumnCollection();
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setColumn(Column $column)
    {
        $this->column[] = $column;
    }
    
}