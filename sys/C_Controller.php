<?php

/**
 *
 */

if (!defined('SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

class C_Controller {
  
  protected $view;
  
  public function __construct() {
    $this->view = new C_View();
  }
  
  public function render() {
    return $this->view->render();
  }
}