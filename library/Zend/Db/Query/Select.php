<?php

namespace Zend\Db\Query;

class Select implements Queryable
{
    public function from($name, $cols = '*', $schema = null)
    {
        
    }
    
    public function columns($cols = '*', $correlationName = null)
    {
        
    }
    
    public function union($select = array(), $type = self::SQL_UNION)
    {
        
    }
    
    public function join($name, $cond, $cols = self::SQL_WILDCARD, $schema = null, $type = null)
    {
        
    }
    
    public function where($cond, $value = null, $type = null)
    {
        
    }
    
    
}