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
 * Starts up Colibri.
 */

/**
 * The path to the Colibri sys folder. This contains the Colibri core. Must
 * end with a slash !
 */
define('COLIBRI_SYS_PATH', '../sys/');

/**
 * Include Colibri.
 */
require COLIBRI_SYS_PATH . 'Colibri.php';

/**
 * And away we go !
 */
$colibri = new Colibri\Colibri(COLIBRI_SYS_PATH . '../app/conf.php');
