<?php

/**
 *
 */

if (!defined('SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

function load_file($file) {
  foreach (array(SYS_PATH, APP_PATH) as $path) {
		if (file_exists("$path/$file")) {
			require_once "$path/$file";
      
      return;
    }
	}
  
  sys_error("Could not load file: " . htmlentities($file));
}

function sys_error($message) {
  die($message);
}

/**
 *
 */
class Colibri {
  
  protected $router;
  
  protected $template;
  
  public function __construct() {
    load_file('conf.php');
    load_file('functions.php');
    load_file('C_Controller.php');
    load_file('C_Router.php');
    load_file('C_Template.php');
    
    $this->router = new C_Router();
    
    $this->template = new C_Template();
    
    $this->_init();
  }
  
  protected function _init() {
    $class = $this->router->get_class();
    $method = $this->router->get_method();
    $args = $this->router->get_arguments();
    
    $controller = new $class();
    
    call_user_func_array(array($controller, $method), $args);
  }
}