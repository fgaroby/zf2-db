<?php

namespace Zend\Db\ResultSet;

use Zend\Db\ResultSet\DataSource;

class ResultSet implements \Iterator, ResultSetInterface 
{
    const TYPE_OBJECT = 'object';
    const TYPE_ARRAY  = 'array';
    
    protected $_rowClass = '\Zend\Db\ResultSet\RowObject';
    protected $_returnType = self::TYPE_OBJECT;
    
    /**
     * @var \Zend\Db\ResultSet\DataSource\DataSourceInterface
     */
    protected $_dataSource = null;
    
    
    public function __construct(DataSource\DataSourceInterface $dataSource)
    {
    	$this->_dataSource = $dataSource;
    }
    
    public function getFieldCount() {}
    
    public function next()
    {
        $this->_dataSource->next();
    }
    
    public function rewind()
    {
        $this->_dataSource->rewind();
    }
    
    public function key()
    {
        return $this->_dataSource->key();
    }
    
    public function current()
    {
        return $this->_dataSource->current();
    }
    
    public function valid()
    {
        return $this->_dataSource->valid();
    }
    
    public function count()
    {
    	$this->_dataSource->count();
    }

    
    
    
}
