<?php

namespace Zend\Db\Query\Ddl;
use \Zend\Db\Query\AbstractQuery;

class Ddl extends AbstractQuery
{
    
    public function create()
    {
        $q = new Create();
        if ($this->db) {
            $this->db->prepareObject($q);
        }
        return $q;
    }
    
    public function alter()
    {
        
    }
    
    public function drop()
    {
        
    }
    
    public function truncate()
    {
        
    }
    
    public function rename()
    {
        
    }
    
}