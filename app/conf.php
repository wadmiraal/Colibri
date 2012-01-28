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
 * Defines the global configuration for Colibri.
 * Configuration directives for custom app logic can also be defined here and
 * are globally accessible via the conf() function.
 */

/**
 * No direct access.
 */
if (!defined('SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

/**
 * Make sure we're instantiating a global variable.
 */
global $_conf;

$_conf = array();

/**
 * The default controller, called for the website root (www.example.com/)
 */
$_conf['default_controller'] = 'Home';

/**
 * The base path for your application. If at the root of the domain, just put
 * a single forward slash. Should always end with a slash !
 */
$_conf['base_path'] = '/Colibri/web/';

/**
 * The template file extension. Template files (views) are just HTML with PHP
 * code. You can use any extension you want.
 */
$_conf['template_extension'] = '.php';

/**
 * The class file extension. Defaults to .php, but can be anything you want.
 */
$_conf['class_extension'] = '.php';
