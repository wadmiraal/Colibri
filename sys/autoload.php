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
 * Defines the autoloader
 */

spl_autoload_register(function($class) {
  $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);

  require_once(COLIBRI_SYS_PATH . 'lib' . DIRECTORY_SEPARATOR . $path . '.php');
});
