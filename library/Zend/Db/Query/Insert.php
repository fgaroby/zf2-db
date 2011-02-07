<?php

namespace Zend\Db\Query;

class Insert extends AbstractQuery
{
    const VALUES_MERGE = 'merge';
    const VALUES_SET   = 'set';
    
    protected $schema = null;
    protected $table = null;
    protected $columns = array();
    protected $values = array();
    
    
    public function into($table, $schema = null)
    {
        $this->table = $table;
        if ($schema) {
            $this->schema = $schema;
        }
        return $this;
    }
    
    public function columns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }
    
    public function values(array $values, $flag = self::VALUES_SET)
    {
        if ($values == null) {
            throw new \InvalidArgumentException('values() expects an array of values');
        }
        
        $keys = array_keys($values);
        $firstKey = array_shift($keys);
        
        if (is_string($firstKey)) {
            $this->columns($keys);
            $values = array_values($values);
        } elseif (is_int($firstKey)) {
            $values = array_values($values);
        }
        
        if ($flag == self::VALUES_MERGE) {
            $this->values = array_merge($this->values, $values);
        } else {
            $this->values = $values;
        }
        
        return $this;
    }
    
    /*
    public function __set($name, $value)
    {
        
        $this->set[$name] = $value;
        return $this;
    }
    
    public function __unset($name)
    {
        unset($this->set[$name]);
    }
    
    public function __isset($name)
    {
        return array_key_exists($name, $this->set);
    }
    
    public function __get($name)
    {
        return $this->set[$name];
    }
    */
    
    public function isValid($throwException = false)
    {
        if ($this->table == null || !is_string($this->table)) {
            if ($throwException) throw new \Exception('A valid table name is required');
            return false;
        }
        
        if (count($this->values) == 0) {
            if ($throwException) throw new \Exception('Values are required for this insert object to be valid');
            return false;
        }
        
        if (count($this->columns) > 0 && count($this->columns) != count($this->values)) {
            if ($throwException) throw new \Exception('When columns are present, there needs to be an equal number of columns and values');
            return false;
        }
        
        return true;
    }
    
    public function toSql()
    {
        $sql = 'INSERT INTO ' . $table
    }
    
}
