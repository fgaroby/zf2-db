<?php

namespace Zend\Db\Adapter\Driver\Mysqli;
use Zend\Db\Adapter\Driver;

class Result implements Driver\ResultInterface
{
	protected $_driver = null;
	protected $_resource = null;
	protected $_data = null;
	protected $_pointerPosition = 0;
	protected $_numberOfRows = -1;
	protected $_nextImpliedByCurrent = false;
	protected $_loadedRows = 0;
	
	public function __construct(Driver\AbstractDriver $driver, array $defaultOptions, \mysqli_result $mysqliResult = null)
	{
	   $this->_driver = $driver; 
	   $this->_resource = $mysqliResult;
	   $this->_numberOfRows = $mysqliResult->num_rows;
	}
	
	public function getResource()
	{
		return $this->_resource;
	}
	
	public function current()
	{
	    if ($this->_pointerPosition > ($this->_numberOfRows-1)) {
	        throw new \OutOfRangeException('Attempting to access a row that is outside of the number of rows in this result.');
	    }
	    
        $pointer = $this->_pointerPosition;
	    
		if (!array_key_exists($this->_pointerPosition, $this->_data[$this->_pointerPosition])) {
		    $this->_data[$this->_pointerPosition] = $this->_resource->fetch_array(\MYSQLI_ASSOC);
		    $this->_pointerPosition++;
		    $this->_nextImpliedByCurrent = true;
		    $this->_loadedRows++;
		    /** 
		     * @todo determine if this is a smart thing to do 
		    if ($this->_loadedRows == $this->_numberOfRows) {
		        $this->_resource->free(); // free result when we know theres nothing left to load
		    }
		    */
		}
		
		return $this->_data[$pointer];
	}
	
	public function next()
	{
	    if ($this->_nextImpliedByCurrent == false) {
	        $this->_pointerPosition++;
	    }
		$this->_nextImpliedByCurrent = false;
	}
	
	public function key()
	{
		return $this->_pointerPosition;
	}
	
	public function rewind()
	{
	    $this->_pointerPosition = 0;
		$this->_resource->data_seek(0);
	}
	
	public function valid()
	{
		return ($this->_pointerPosition < $this->_numberOfRows);
	}
	
	public function count()
	{
		return $this->_numberOfRows;
	}
	
}