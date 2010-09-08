<?php

namespace Zend\Db\Metadata\Factory;

class Factory
{
    protected $metadata = null;
    
    public function setMetadata(\Zend\Db\Metadata\Metadata $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }
    
    public function createFromScanner(Scanner\ScannerInterface $scanner)
    {
        $metadata = ($this->metadata != null) ? $this->_metadata : new \Zend\Db\Metadata\Metadata;
        
        // skip catalog support
        
        //$schemas = $scanner->
        
        return $metadata;
    }

    public function createFromConfig()
    {
        
    }
    
}
