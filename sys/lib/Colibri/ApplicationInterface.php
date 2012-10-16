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
 * Defines the Colibri application interface.
 */

namespace Colibri;

/**
 * No direct access.
 */
if (!defined('COLIBRI_SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

interface ApplicationInterface {

  /**
   * Initialize the application.
   */
  public function run();

  /**
   * Outputs the actual requested ressource
   */
  public function respond();

  /**
   * Get the router instance
   */
  public function get_router();

  /**
   * Get the response string
   */
  public function get_response();

  /**
   * Get the response headers
   */
  public function get_headers();
}
