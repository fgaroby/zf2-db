<?php

namespace ZendTest\TestAsset;

class TestAutoloader
{
    function autoload($class) 
    {
        $class = ltrim($class, '\\');
    
        if (!preg_match('#^(Zend(Test)?|PHPUnit)(\\\\|_)#', $class)) {
            return false;
        }
    
        // $segments = explode('\\', $class); // preg_split('#\\\\|_#', $class);//
        $segments = preg_split('#[\\\\_]#', $class); // preg_split('#\\\\|_#', $class);//
        $ns       = array_shift($segments);
    
        switch ($ns) {
            case 'Zend':
                $file = __DIR__ . '/../../../library/Zend/';
                break;
            case 'ZendTest':
                // temporary fix for ZendTest namespace until we can migrate files 
                // into ZendTest dir
                $file = __DIR__ . '/../../ZendTest/';
                break;
            default:
                $file = false;
                break;
        }
    
        if ($file) {
            $file .= implode('/', $segments) . '.php';
            if (file_exists($file)) {
                return include_once $file;
            }
        }
    
        $segments = explode('_', $class);
        $ns       = array_shift($segments);
    
        switch ($ns) {
            case 'PHPUnit':
                return include_once str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
            case 'Zend':
                $file = __DIR__ . '/../../../library/Zend/';
                break;
            default:
                return false;
        }
        $file .= implode('/', $segments) . '.php';
        if (file_exists($file)) {
            return include_once $file;
        }
    
        return false;
    }
}