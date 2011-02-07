<?php

namespace Zend\Db\Metadata;

class Metadata
{
    
    protected $catalogName = null;
    protected $schemaName = null;
    
    protected $tableCollection = null;
    protected $viewCollection = null;
    protected $referentialConstraintCollection = null;
    protected $triggerCollection = null;

    
    public function __construct()
    {
        $this->tableCollection = new TableCollection();
        $this->viewCollection = new ViewCollection();
        $this->referentialConstraintCollection = new ReferentialConstraintCollection();
        $this->triggerCollection = new TriggerCollection();
    }
    
    public function getTableCollection()
    {
        return $this->tableCollection;
    }
    
    public function getViewCollection()
    {
        return $this->viewCollection;
    }
    
    /**
	 * @return Zend\Db\Metadata\ReferentialConstraintCollection
     */
    public function getReferentialConstraintCollection()
    {
        return $this->referentialConstraintCollection;
    }
    
    public function getTriggerCollection()
    {
        return $this->triggerCollection;
    }
    
}
