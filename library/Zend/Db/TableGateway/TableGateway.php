<?php

namespace Zend\Db\TableGateway;

class TableGateway implements \Zend\Db\DbPreparable
{
    protected $db = null;
    
    public function __construct($options = array())
    {
        
    }
    
    public function setDb(\Zend\Db\Db $db)
    {
        $this->db = $db;
    }
    
    public function select($where)
    {
        $eventManager = $this->eventManager();
        
        if ($eventManager) {
            $eventManager->trigger(__CLASS__, $this, array());
        }
    }
    
    public function insert($values)
    {
    }
    
    public function update($values, $where)
    {
    }
    
    public function delete($where)
    {
    }
    
    /**
	 * @return \Zend\EventManager\EventManager
     */
    protected function eventManager()
    {
        if (!isset($this->db)) {
            return false;
        }
        return $this->db->registry()->getPluginManager()->getEventManager();
    }
}