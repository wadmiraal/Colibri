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
 * The directories where all controllers, views and layouts are stored. Musr
 * end with a slash !
 */
$_conf['dir_controllers'] = '../app/controllers/';
$_conf['dir_views']       = '../app/views/';
$_conf['dir_layouts']     = '../app/layouts/';

/**
 * The base path for your application. Defaults to the path to the index.php file.
 * Can be overriden. If at the root of the domain, just put a single forward slash.
 * Should always start and end with a slash ! For performance, it's better to
 * hard code a value here instead of the default str_replace() method.
 */
$_conf['base_path'] = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);

/**
 * The template file extension. Template files (views and layouts) are just HTML
 * with PHP code. You can use any extension you want.
 */
$_conf['template_extension'] = '.phtml';

/**
 * The class file extension. Defaults to .php, but can be anything you want.
 */
$_conf['class_extension'] = '.php';

/**
 * Autoload all files from this array at every request.
 */
#$_conf['autoload'] = array('path/to/my/File.php');

/**
 * 404 controller. By default, handled by Colibri itself.
 */
#$_conf['404_handler'] = 'My_Error_404';

/**
 * I18n settings
 * Colibri provides built-in routing for multilingual applications. If enabled,
 * the first parameter in the URL will be treated as the language parameter.
 * E.g.:
 * fr/controller/method/param1
 * en-US/controller/method/param1
 * 
 * This parameter can be anything you want: Colibri enforces no standards.
 * E.g.:
 * en/controller/method/param1
 * ENG/controller/method/param1
 */
#$_conf['i18n_enabled'] = TRUE;

/**
 * You may set a default language parameter: in case the language is absent, the
 * default one will be used.
 */
#$_conf['i18n_default_language'] = 'en-GB';
