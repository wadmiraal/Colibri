<?php
/**
 * Colibri, the tiny PHP framework
 *
 * Copyright (c) 2012 Wouter Admiraal (http://github.com/wadmiraal)
 *  
 * Licensed under the MIT license: http://opensource.org/licenses/MIT
 */

/**
 * @file
 * Defines the paths for the sys and app folders.
 * Starts up Colibri.
 */

/**
 * The path to the Colibri sys folder. This contains the Colibri core
 */
define('SYS_PATH', '../sys');

/**
 * The path to the app folder. This contains the application logic and
 * configuration files.
 */
define('APP_PATH', '../app');

/**
 * Include Colibri
 */
require SYS_PATH . '/Colibri.php';

/**
 * And away we go !
 */
$colibri = new Colibri();
