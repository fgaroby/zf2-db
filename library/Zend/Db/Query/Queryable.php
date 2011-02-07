<?php

namespace Zend\Db\Query;

interface Queryable
{
    
    public function isValue();
    public function toSql();
    
}