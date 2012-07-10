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
if (!defined('COLIBRI_SYS_PATH')) {
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
 * If i18n enabled, will prepend the passed language, if available.
 *
 * @param string $controller
 *        The class name of the controller (CamelCased).
 * @param string $method = 'index'
 *        (optional) the method name.
 * @param array $arguments
 *        (optional) the arguments.
 * @param string $language
 *        (optional) the desired language. Only used if $_conf[i18n_enabled] = TRUE.
 *
 * @return string
 *        The properly formatted URI.
 */
function url($controller, $method = 'index', $arguments = array(), $language = NULL) {
  $url = conf('base_path');
  
  // Add the language
  if (conf('i18n_enabled') && !empty($language)) {
    $url .= urlencode($language) . '/';
  }
  
  // Add the controller
  $url .= C_Router::prepare_for_uri($controller);
  
  // Do we have a method ?
  if (empty($arguments) && $method == 'index') {
    return $url;
  }
  
  $url .= '/' . C_Router::prepare_for_uri($method);
  
  if (!empty($arguments)) {
    foreach ($arguments as $arg) {
      if (strlen($arg)) {
        $url .= '/' . urlencode($arg);
      }
    }
  }
  
  return $url;
}

/**
 * Redirects to the passed controller.
 * Exits the application and uses a 301 redirect to the correct URI.
 *
 * @see url() for more info about the function parameters
 */
function go_to($controller, $method = NULL, $arguments = NULL, $language = NULL) {
  $url = url($controller, $method, $arguments, $language);
  
  header('Location:' . $url);
  
  exit();
}

/**
 * Returns the requested URI segments.
 * In case of i18n enabled applications, the language parameter is omitted.
 * Use the language() function to retrieve the current language.
 * E.g.:
 * controller/method AND fr/controller/method
 * both map to:
 *  segment(0) => controller
 *  segment(1) => method
 *
 * @param int $index
 *        The index of the URI segment.
 *
 * @return string
 *        The value of the URI segment.
 */
function segment($index) {
  return C_Router::segment($index);
}

/**
 * Returns the current language.
 * Only usefull if $_conf[i18n_enabled] is TRUE. Will return NULL otherwise.
 *
 * @return string
 *        The current language.
 */
function language() {
  if (conf('i18n_enabled')) {
    return C_I18nRouter::language();
  }
  else {
    return NULL;
  }
}
