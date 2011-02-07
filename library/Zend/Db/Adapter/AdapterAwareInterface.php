<?php

namespace Zend\Db\Adapter;

interface AdapterAwareInterface
{
    public function setAdapter(\Zend\Db\Adapter\Adapter $adapter);
}
