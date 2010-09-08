<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Registry
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * @namespace
 */
namespace Zend;

/**
 * Generic storage class helps to manage global data.
 *
 * @uses       ArrayObject
 * @uses       \Zend\Exception
 * @uses       \Zend\Loader
 * @category   Zend
 * @package    Zend_Registry
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Registry extends \ArrayObject
{
    const GLOBAL_REGISTRY_NAME = '\Zend\Registry';
    
    const USE_REGISTRY_CLASS_NAME = null;
    const USE_CALLED_CLASS = null;

    /**
     * Registry object provides storage for shared objects.
     * @var \Zend\Registry
     */
    protected static $_registryOfRegistries = array();

    public static function getGlobalRegistry()
    {
        if (!static::hasRegistry(self::GLOBAL_REGISTRY_NAME)) {
            $className = self::GLOBAL_REGISTRY_NAME;
            $registry = new $className;
            static::registerRegistry($registry);
        } else {
            $registry = self::getRegistry(self::GLOBAL_REGISTRY_NAME);
        }
        return $registry;
    }
    
    public static function registerRegistry($registry = self::USE_CALLED_CLASS, $name = self::USE_REGISTRY_CLASS_NAME)
    {
        if ($registry == null) {
            $class = '\\' . get_called_class();
            $registry = new $class();
        }
        
        if (!is_object($registry)) {
            throw new \InvalidArgumentException('Registered registry must minimally be an object');
        }
        
        if ($name == null) {
            $name = '\\' . get_class($registry);
        }
        
        if (array_key_exists($name, static::$_registryOfRegistries)) {
            throw new \Exception('Registry by name ' . $name . ' is already registered.');
        }
        
        static::$_registryOfRegistries[$name] = $registry;
    }
    
    public static function hasRegistry($name = self::USE_CALLED_CLASS)
    {
        if (is_null($name)) {
            $name = '\\' . get_called_class();
        }
        
        return isset(static::$_registryOfRegistries[$name]);
    }
    
    public static function getRegistry($name = self::USE_CALLED_CLASS)
    {
        if (is_null($name)) {
            $name = '\\' . get_called_class();
        }
        
        if (!static::hasRegistry($name)) {
            return false;
        }
        
        return static::$_registryOfRegistries[$name];
    }
    
    public static function unregisterRegistry($nameOrRegistry = self::USE_CALLED_CLASS)
    {
        if (is_null($nameOrRegistry)) {
            $nameOrRegistry = '\\' . get_called_class();
        }
        
        if (is_string($nameOrRegistry)) {
            unset(static::$_registryOfRegistries[$nameOrRegistry]);
        } elseif ($nameOrRegistry instanceof \Zend\Registry) {
            $key = array_search($nameOrRegistry, static::$_registryOfRegistries);
            if ($key) {
                unset(static::$_registryOfRegistries[$key]);
            }
        }
    }
    
    /**
     * Constructs a parent ArrayObject with default
     * ARRAY_AS_PROPS to allow acces as an object
     *
     * @param array $array data array
     * @param integer $flags ArrayObject flags
     */
    public function __construct($array = array(), $flags = parent::ARRAY_AS_PROPS)
    {
        parent::__construct($array, $flags);
    }
    
}
