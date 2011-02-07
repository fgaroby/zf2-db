<?php

namespace Zend\Db\Plugin;

class PluginManager
{
    protected $classPlugins = array();
    protected $plugins = array();
    protected $eventManager = null;
    
    public function setEventManager(\Zend\EventManager\EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }
    
    /**
     * @return \Zend\EventManager\EventManager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }
    
    public function getClassPlugin($pluginClass)
    {
        return $this->classPlugins[$pluginClass];
    }
    
    public function register($plugin)
    {
        if (is_string($plugin)) {
            if (!class_exists($plugin)) {
                throw new \Exception('This plugin class name does not exist');
            }
            if (array_key_exists($plugin, $this->classPlugins)) {
                throw new \Exception('This plugin class has already been registered');
            }
            $pluginClass = $plugin;
            $plugin = new $pluginClass;
        }
        
        if (in_array($plugin, $this->plugins)) {
            throw new \Exception('This plugin is already registered');
        }
        
        if (isset($pluginClass)) {
            $this->classPlugins[$pluginClass] = $plugin;
        }
        
        $this->plugins[] = $plugin;
        
        $plugin->initialize($this->eventManager);
    }
    
}