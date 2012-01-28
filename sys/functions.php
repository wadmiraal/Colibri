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
 * Defines some global helper functions.
 */

/**
 * No direct access.
 */
if (!defined('SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

/**
 * Returns the requested configuration parameter.
 *
 * @param string $name
 *        The name of the parameter.
 *
 * @return mixed
 *        The value of the parameter.
 */
function conf($name) {
  global $_conf;
  
  return isset($_conf[$name]) ? $_conf[$name] : NULL;
}

/**
 * Helper function for preparing URIs for HTML links. Gets the class name, the
 * method name and the parameters and returns a usable URI.
 *
 * @param string $controller
 *        The class name of the controller (CamelCased).
 * @param string $method = 'index'
 *        (optional) the method name.
 * @param array $arguments
 *        (optional) the arguments.
 *
 * @return string
 *        The properly formatted URI.
 */
function url($controller, $method = 'index', $arguments = array()) {
  $url = conf('base_path') . C_Router::prepare_for_uri($controller);
  
  if (empty($arguments) && $method == 'index') {
    return $url;
  }
  
  $url .= '/' . C_Router::prepare_for_uri($method);
  
  if (!empty($arguments)) {
    foreach ($arguments as $arg) {
      $url .= '/' . urlencode($arg);
    }
  }
  
  return $url;
}
