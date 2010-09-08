<?php

namespace Zend\Db\Metadata;

class Column
{
    protected $catalog = null;
    protected $schema = null;
    protected $table = null;
    protected $name = null;
    protected $ordinalPostion = null;
    protected $columnDefault = null;
    protected $isNullable = null;
    protected $dataType = null;
    protected $characterMaximumLength = null;
    protected $characterOctetLength = null;
    protected $numericPrevision = null;
    protected $numericScale = null;
    protected $characterSetName = null;
    protected $collationName = null;
    protected $errata = array();
    
	/**
     * @return the $catalog
     */
    public function getCatalog()
    {
        return $this->catalog;
    }

	/**
     * @param $catalog the $catalog to set
     */
    public function setCatalog($catalog)
    {
        $this->catalog = $catalog;
        return $this;
    }

	/**
     * @return the $schema
     */
    public function getSchema()
    {
        return $this->schema;
    }

	/**
     * @param $schema the $schema to set
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;
        return $this;
    }

	/**
     * @return the $table
     */
    public function getTable()
    {
        return $this->table;
    }

	/**
     * @param $table the $table to set
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @param $name the $name to set
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

	/**
     * @return the $ordinalPostion
     */
    public function getOrdinalPostion()
    {
        return $this->ordinalPostion;
    }

	/**
     * @param $ordinalPostion the $ordinalPostion to set
     */
    public function setOrdinalPostion($ordinalPostion)
    {
        $this->ordinalPostion = $ordinalPostion;
        return $this;
    }

	/**
     * @return the $columnDefault
     */
    public function getColumnDefault()
    {
        return $this->columnDefault;
    }

	/**
     * @param $columnDefault the $columnDefault to set
     */
    public function setColumnDefault($columnDefault)
    {
        $this->columnDefault = $columnDefault;
        return $this;
    }

	/**
     * @return the $isNullable
     */
    public function getIsNullable()
    {
        return $this->isNullable;
    }

	/**
     * @param $isNullable the $isNullable to set
     */
    public function setIsNullable($isNullable)
    {
        $this->isNullable = $isNullable;
        return $this;
    }

	/**
     * @return the $dataType
     */
    public function getDataType()
    {
        return $this->dataType;
    }

	/**
     * @param $dataType the $dataType to set
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
        return $this;
    }

	/**
     * @return the $characterMaximumLength
     */
    public function getCharacterMaximumLength()
    {
        return $this->characterMaximumLength;
    }

	/**
     * @param $characterMaximumLength the $characterMaximumLength to set
     */
    public function setCharacterMaximumLength($characterMaximumLength)
    {
        $this->characterMaximumLength = $characterMaximumLength;
        return $this;
    }

	/**
     * @return the $characterOctetLength
     */
    public function getCharacterOctetLength()
    {
        return $this->characterOctetLength;
    }

	/**
     * @param $characterOctetLength the $characterOctetLength to set
     */
    public function setCharacterOctetLength($characterOctetLength)
    {
        $this->characterOctetLength = $characterOctetLength;
        return $this;
    }

	/**
     * @return the $numericPrevision
     */
    public function getNumericPrevision()
    {
        return $this->numericPrevision;
    }

	/**
     * @param $numericPrevision the $numericPrevision to set
     */
    public function setNumericPrevision($numericPrevision)
    {
        $this->numericPrevision = $numericPrevision;
        return $this;
    }

	/**
     * @return the $numericScale
     */
    public function getNumericScale()
    {
        return $this->numericScale;
    }

	/**
     * @param $numericScale the $numericScale to set
     */
    public function setNumericScale($numericScale)
    {
        $this->numericScale = $numericScale;
        return $this;
    }

	/**
     * @return the $characterSetName
     */
    public function getCharacterSetName()
    {
        return $this->characterSetName;
    }

	/**
     * @param $characterSetName the $characterSetName to set
     */
    public function setCharacterSetName($characterSetName)
    {
        $this->characterSetName = $characterSetName;
        return $this;
    }

	/**
     * @return the $collationName
     */
    public function getCollationName()
    {
        return $this->collationName;
    }

	/**
     * @param $collationName the $collationName to set
     */
    public function setCollationName($collationName)
    {
        $this->collationName = $collationName;
        return $this;
    }

	/**
     * @return the $errata
     */
    public function getErrata()
    {
        return $this->errata;
    }

	/**
     * @param $errata the $errata to set
     */
    public function setErrata($errata)
    {
        $this->errata = $errata;
        return $this;
    }



}