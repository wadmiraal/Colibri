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
 * Defines the C_Controller base class. All controller classes must extend
 * the C_Controller class.
 */

/**
 * No direct access.
 */
if (!defined('SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

class C_Controller {
  
  /**
   * A C_View object. Will render the views.
   */
  protected $view;
  
  /**
   * Constructor...
   */
  public function __construct() {
    $this->view = new C_View();
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