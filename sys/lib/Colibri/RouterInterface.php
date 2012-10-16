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
 * Defines the Router interface.
 */

namespace Colibri;

/**
 * No direct access.
 */
if (!defined('COLIBRI_SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

interface RouterInterface {

  /**
   * Returns the requested class name.
   *
   * @return string
   *        The class name.
   */
  public function get_class();

  /**
   * Returns the requested method.
   *
   * @return string
   *        The method name.
   */
  public function get_method();

  /**
   * Returns the passes arguments.
   *
   * @return array
   *        The arguments.
   */
  public function get_arguments();

  /**
   * Parses a string for the URI and returns it.
   *
   * @param string $string
   *        The class name or method.
   *
   * @return string
   *        The element, ready for the URI.
   */
  public function prepare_for_uri($string);
}
