<?php

namespace Zend\Db\Query;

class Query extends AbstractQuery
{

    public function ddl()
    {
        $q = new Ddl\Ddl();
        if ($this->db) {
            $this->db->prepareObject($q);
        }
        return $q;
    }
    
    public function insert()
    {
        $q = new Insert();

    }
    
    public function update()
    {
        $q = new Update();
    }
    
    public function delete()
    {
        $q = new Delete();
    }
    
    public function select()
    {
        $q = new Select();
    }

}
