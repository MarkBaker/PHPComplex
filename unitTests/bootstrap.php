<?php
/**
 * $Id: bootstrap.php 2892 2011-08-14 15:11:50Z markbaker@phpexcel.net $
 *
 * @copyright   Copyright (C) 2012 Mark Baker. All rights reserved.
 * @package     Complex
 * @subpackage  Complex Unit Tests
 * @author      Mark Baker
 */

// PHP 5.3 Compatibility
date_default_timezone_set('Europe/Amsterdam');

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../classes'));

// Define path to application tests directory
defined('APPLICATION_TESTS_PATH')
    || define('APPLICATION_TESTS_PATH', realpath(dirname(__FILE__)));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', 'ci');

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH),
    './',
    get_include_path(),
)));

/**
 * @todo Sort out xdebug in vagrant so that this works in all sandboxes
 * For now, it is safer to test for it rather then remove it.
 */
echo "Complex tests beginning\n";

if (extension_loaded('xdebug')) {
    echo "Xdebug extension loaded and running\n";
    xdebug_enable();
} else {
    echo 'Xdebug not found, you should run the following at the command line:',
        'echo "zend_extension=/usr/lib64/php/modules/xdebug.so" > /etc/php.d/xdebug.ini',
        "\n";
}


require_once(APPLICATION_TESTS_PATH . '/../vendor/autoload.php');

// Load abstract base function test class.
require_once APPLICATION_TESTS_PATH . '/BaseTestAbstract.php';
require_once APPLICATION_TESTS_PATH . '/BaseFunctionTestAbstract.php';
require_once APPLICATION_TESTS_PATH . '/BaseOperationTestAbstract.php';
