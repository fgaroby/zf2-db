<?php

namespace Zend\Db\Adapter\Driver\Mysqli;

class Statement implements \Zend\Db\Adapter\DriverStatement
{
    protected $adapter = null;
    protected $driver = null;
    protected $sql = null;
    
    protected $boundParameterTypes = array();
    protected $boundParamValues = array();
    
    /**
     * @var \mysqli_stmt
     */
    protected $resource = null;
    
    public function __construct(\Zend\Db\Adapter\Driver $driver, array $defaultOptions, \mysqli_stmt $resource = null)
    {
        $this->driver = $driver;
        $this->resource = $resource;
    }
    
    public function setAdapter(\Zend\Db\Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
    
    public function bindParameter($nameOrPosition, $value, $bindType = self::BIND_TYPE_STRING)
    {
        // delayed bind
        $this->boundParameterTypes[$nameOrPosition] = $bindType;
        $this->boundParamValues[$nameOrPosition] = $value;
    }
    
    public function getResource()
    {
        return $this->resource;
    }
    
    public function setSQL($sql)
    {
        $this->sql = $sql;
    }
    
    public function getSQL()
    {
        return $this->sql;
    }
    
    public function execute()
    {
        $this->buildCombinedBindParamCall();

        $ret = $this->resource->execute();
        return $ret;
    }
    
    protected function buildCombinedBindParamCall()
    {
        if (!$this->boundParamValues) {
            return;
        }
        
        $type = '';
        $args = array();

        foreach ($this->boundParamValues as $position => &$value) {
            switch ($this->boundParameterTypes[$position]) {
                case self::BIND_TYPE_DOUBLE:
                    $type .= 'd';
                    break;
                case self::BIND_TYPE_NULL:
                    $value = null; // as per @see http://www.php.net/manual/en/mysqli-stmt.bind-param.php#96148
                case self::BIND_TYPE_INTEGER:
                    $type .= 'i';
                    break;
                case self::BIND_TYPE_STRING:
                default:
                    $type .= 's';
                    break;
            }
            array_push($args, &$value);
        }
        array_unshift($args, $type);
        
        call_user_func_array(array($this->resource, 'bind_param'), $args);
    }
}
