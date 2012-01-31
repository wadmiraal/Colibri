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
$_conf['base_path'] = '/';

/**
 * The template file extension. Template files (views) are just HTML with PHP
 * code. You can use any extension you want.
 */
$_conf['template_extension'] = '.php';

/**
 * The class file extension. Defaults to .php, but can be anything you want.
 */
$_conf['class_extension'] = '.php';

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
