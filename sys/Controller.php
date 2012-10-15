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
 * Defines the Controller base class.
 */

namespace Colibri;

/**
 * No direct access.
 */
if (!defined('COLIBRI_SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

class Controller {

  /**
   * A View object. Will render the views.
   */
  protected $view;

  /**
   * Constructor...
   */
  public function __construct() {
    $this->view = new View();
  }

  /**
   * Renders the HTML and returns it.
   *
   * @return string
   *        The rendered view as HTML.
   */
  public function render() {
    return $this->view->render();
  }
}
