<?php

set_include_path('.:/Users/ralphschindler/.phplib/');

require_once 'PHPUnit/Util/Filter.php';
PHPUnit_Util_Filter::addFileToFilter(__FILE__, 'PHPUNIT');
require 'PHPUnit/TextUI/Command.php';
define('PHPUnit_MAIN_METHOD', 'PHPUnit_TextUI_Command::main');

//$_SERVER['argv'] = array(
//    $_SERVER['PHP_SELF'],
//    '--filter',
//    'testInit',
//    'Zend/Controller/ActionTest.php'
//    );

PHPUnit_TextUI_Command::main();
