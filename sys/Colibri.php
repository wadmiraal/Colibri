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
 * Defines the Colibri core class. Bootstraps the entire application.
 */

/**
 * No direct access.
 */
if (!defined('SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

/**
 * Helper function for quickly including files.
 *
 * @param string $file
 * 				The name if the file to include.
 */
function load_file($file) {
  foreach (array(SYS_PATH, APP_PATH) as $path) {
		if (file_exists("$path/$file")) {
			include_once("$path/$file");
      
      return;
    }
	}
  
  sys_error("Could not load file: " . htmlentities($file));
}

/**
 * Log function for system errors.
 *
 * @param string $message
 * 				The error message.
 */
function sys_error($message) {
  die($message);
}

/**
 * Load the core files.
 */
load_file('conf.php');
load_file('functions.php');
load_file('C_Controller.php');
load_file('C_Router.php');
load_file('C_View.php');

class Colibri {
  
	/**
	 * The C_Router instance.
	 */
  protected $router;
  
	/**
	 * Constructor...
	 */
  public function __construct() {    
    $this->router = new C_Router();
    
    $this->_init();
  }
  
	/**
	 * Initialize the application.
	 */
  protected function _init() {
    $class  = $this->router->get_class();
    $method = $this->router->get_method();
    $args   = $this->router->get_arguments();
		
		// Include the class definition
    load_file('controllers/' . $class . conf('class_extension'));
		
    $controller = new $class();
    
    call_user_func_array(array($controller, $method), $args);
		
		echo $controller->render();
  }
}