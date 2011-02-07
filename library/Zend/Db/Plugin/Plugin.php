<?php

namespace Zend\Db\Plugin;

interface Plugin
{
    public function initialize(\Zend\EventManager\EventManager $eventManager);
}