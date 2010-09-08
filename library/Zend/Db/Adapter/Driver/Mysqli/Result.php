<?php

namespace Zend\Db\Adapter\Driver\Mysqli;
use Zend\Db\Adapter\Driver;

class Result implements \Iterator, Driver\ResultInterface
{
    /**
     * @var Zend\Db\Adapter\Driver\AbstractDriver
     */
	protected $driver = null;
	
	/**
	 * @var \mysqli_result
	 */
	protected $resource = null;
	protected $data = array();
	protected $pointerPosition = 0;
	protected $numberOfRows = -1;
	protected $nextImpliedByCurrent = false;
	protected $loadedRows = 0;
	
	public function __construct(Driver\AbstractDriver $driver, array $defaultOptions, \mysqli_result $mysqliResult = null)
	{
	   $this->driver = $driver; 
	   $this->resource = $mysqliResult;
	   $this->numberOfRows = $mysqliResult->num_rows;
	}
	
	public function getResource()
	{
		return $this->resource;
	}
	
	public function current()
	{
	    if ($this->pointerPosition > ($this->numberOfRows-1)) {
	        throw new \OutOfRangeException('Attempting to access a row that is outside of the number of rows in this result.');
	    }
	    
        $pointer = $this->pointerPosition;
	    
		if (!array_key_exists($this->pointerPosition, $this->data)) {
		    $this->data[$this->pointerPosition] = $this->resource->fetch_array(\MYSQLI_ASSOC);
		    $this->pointerPosition++;
		    $this->nextImpliedByCurrent = true;
		    $this->loadedRows++;
		    /** 
		     * @todo determine if this is a smart thing to do 
		    if ($this->_loadedRows == $this->_numberOfRows) {
		        $this->_resource->free(); // free result when we know theres nothing left to load
		    }
		    */
		}
		
		return $this->data[$pointer];
	}
	
	public function next()
	{
	    if ($this->nextImpliedByCurrent == false) {
	        $this->pointerPosition++;
	    }
		$this->nextImpliedByCurrent = false;
	}
	
	public function key()
	{
		return $this->pointerPosition;
	}
	
	public function rewind()
	{
	    $this->pointerPosition = 0;
		$this->resource->data_seek(0);
	}
	
	public function valid()
	{
		return ($this->pointerPosition < $this->numberOfRows);
	}
	
	public function count()
	{
		return $this->numberOfRows;
	}
	
}