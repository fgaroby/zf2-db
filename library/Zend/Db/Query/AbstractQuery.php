<?php

namespace Zend\Db\Query;

abstract class AbstractQuery implements Queryable
{
    /**
     * @var \Zend\Db\Db
     */
    protected $db = null;
    
    public function setDb(\Zend\Db\Db $db)
    {
        $this->db = $db;
        return $this;
    }

    public function getDb()
    {
        if ($this->db == null) {
            
        }
    }
}
