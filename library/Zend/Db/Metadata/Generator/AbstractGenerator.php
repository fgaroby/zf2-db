<?php

namespace Zend\Db\Metadata\Generator;

use Zend\Db\Metadata;

class AbstractGenerator
{
    const FILTER_NONE = null;
    
    protected $catalogFilter = self::FILTER_NONE;
    protected $schemaFilter  = self::FILTER_NONE;
    protected $tableFilter   = self::FILTER_NONE;
    
    protected $metadata = null;
    
    abstract public function getCatalogs($schema = null);
    abstract public function getSchemas($catalog = null);
    abstract public function getTables($schema = null, $catalog = null);
    abstract public function getColumns($table, $schema = null, $catalog = null);
    abstract public function getTriggers($schema = null, $catalog = null);
    abstract public function getConstraints($table, $schema = null, $catalog = null);
    abstract public function getConstraintKeys($constraint, $table, $schema = null, $catalog = null);
    abstract public function getReferentialConstraints($schema = null, $catalog = null);
    abstract public function getViews($schema = null, $catalog = null);
    
    /**
     * @return the $catalogFilter
     */
    public function getCatalogFilter()
    {
        return $this->catalogFilter;
    }

	/**
     * @param $catalogFilter the $catalogFilter to set
     */
    public function setCatalogFilter($catalogFilter)
    {
        $this->catalogFilter = $catalogFilter;
        return $this;
    }

	/**
     * @return the $schemaFilter
     */
    public function getSchemaFilter()
    {
        return $this->schemaFilter;
    }

	/**
     * @param $schemaFilter the $schemaFilter to set
     */
    public function setSchemaFilter($schemaFilter)
    {
        $this->schemaFilter = $schemaFilter;
        return $this;
    }

	/**
     * @return the $tableFilter
     */
    public function getTableFilter()
    {
        return $this->tableFilter;
    }

	/**
     * @param $tableFilter the $tableFilter to set
     */
    public function setTableFilter($tableFilter)
    {
        $this->tableFilter = $tableFilter;
        return $this;
    }

	public function setMetadata(\Zend\Db\Metadata\Metadata $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }
    
    public function createFromScanner(Scanner\ScannerInterface $scanner)
    {
        /** @var $metadata Zend\Db\Metadata\Metadata **/
        $metadata = ($this->metadata != null) ? $this->_metadata : new \Zend\Db\Metadata\Metadata;
        
        // @todo Catalog support
        
        // @todo Scehma support
        
        
        $tableCollection = $metadata->getTableCollection();
        $tableNames = $scanner->getTables($this->schemaFilter, $this->catalogFilter);
        
        foreach ($tableNames as $tableName) {
            // create & setup table metadata
            $tableMetadata = new \Zend\Db\Metadata\Table();
            $tableMetadata->setMetadata($metadata);
            $tableMetadata->setName($tableName);

            // append to table collection
            $tableCollection->append($tableMetadata);
            
            // create & setup column metadata
            $columnCollection = $tableMetadata->getColumnCollection();
            $columns = $scanner->getColumns($tableName, $this->schemaFilter, $this->catalogFilter);
            foreach ($columns as $columnInfo) {
                $columnMetadata = new \Zend\Db\Metadata\Column;
                $columnMetadata->setMetadata($metadata);
                $columnMetadata->setOptions($columnInfo);
                $columnCollection->append($columnMetadata);
            }
            
            // create & setup table constraints
            $constraintCollection = $tableMetadata->getConstraintCollection();
            $constraints = $scanner->getConstraints($tableName, $this->schemaFilter, $this->catalogFilter);
            foreach ($constraints as $constraintInfo) {
                $constraintMetadata = new \Zend\Db\Metadata\Constraint;
                $constraintMetadata->setMetadata($metadata);
                $constraintMetadata->setOptions($constraintInfo);
                $constraintCollection->append($constraintMetadata);
                
                $constraintKeyCollection = $constraintMetadata->getConstraintKeyCollection();
                $constraintKeys = $scanner->getConstraintKeys($constraintInfo['name'], $this->schemaFilter, $this->catalogFilter);
                foreach ($constraintKeys as $constraintKeyInfo) {
                    $constraintKeyMetadata = new \Zend\Db\Metadata\ConstraintKey();
                    $constraintKeyMetadata->setMetadata($metadata);
                    $constraintKeyMetadata->setOptions($constraintKeyInfo);
                    $constraintKeyCollection->append($constraintKeyMetadata);
                }
                
            }
            
            // create & setup referential constraints
            $refConstraintCollection = $metadata->getReferentialConstraintCollection();
            $refConstraints = $scanner->getReferentialConstraints($this->schemaFilter, $this->catalogFilter);

            foreach ($refConstraints as $refConstraint) {
                $refConstraintMetadata = new \Zend\Db\Metadata\ReferentialConstraint();
                $refConstraintMetadata->setMetadata($metadata);
                $refConstraintMetadata->setOptions($refConstraint);
                $refConstraintCollection->append($refConstraintMetadata);
            }
            
            // create & setup views
            
            // create & setup triggers
            
        }
                
        return $metadata;
    }

    public function createFromArray()
    {
        
    }
    
}
