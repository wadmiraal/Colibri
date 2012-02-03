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
 * Defines the C_Error class, the default error controller. Will handle 400
 * and 404 HTTP errors, though 404 errors can be handled by the application.
 */

/**
 * No direct access.
 */
if (!defined('SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

class C_Error extends C_Controller {
  
  /**
   * @override
   */
  public function __construct() {
    parent::__construct();
    
    $this->view->layout('layout', SYS_PATH . '/errors/');
  }
  
  /**
   * Defines the 404 error page.
   */
  public function error404($class = '', $method = '') {
    $this->view->view('404', SYS_PATH . '/errors/');
    
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
    $this->view->view('400', SYS_PATH . '/errors/');
    
    $this->view->set('title', '400 - application error');
  }
}