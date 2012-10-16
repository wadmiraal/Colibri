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
 * Defines the Error class, the default error controller. Will handle 400
 * and 404 HTTP errors, though 404 errors can be handled by the application.
 */

namespace Colibri;

class Error extends Controller {

  /**
   * @override
   */
  public function __construct() {
    parent::__construct();

    $this->view->layout('layout', COLIBRI_SYS_PATH . 'errors/', '.php');
  }

  /**
   * Defines the 404 error page.
   */
  public function error404($class = '', $method = '') {
    $this->view->view('404', COLIBRI_SYS_PATH . 'errors/', '.php');

    $this->view->set('title', '404 - page not found');

    if (!empty($class)) {
      $this->view->set('controller', htmlentities($class));
    }

    if (!empty($method)) {
      $this->view->set('method', htmlentities($method));
    }
  }

  /**
   * Defines the 400 error page.
   */
  public function error400() {
    $this->view->view('400', COLIBRI_SYS_PATH . 'errors/', '.php');

    $this->view->set('title', '400 - application error');
  }
}
