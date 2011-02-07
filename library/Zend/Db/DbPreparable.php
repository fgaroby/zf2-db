<?php

namespace Zend\Db;

interface DbPreparable
{
    public function setDb(\Zend\Db\Db $db);
    public function getDb();
}