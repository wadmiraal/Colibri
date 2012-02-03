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
 * @param bool $kill = FALSE
 * 				(optional) flag setting wether to kill the application. If TRUE, will
 * 				route to an HTTP 400 error page.
 */
function load_file($file, $kill = FALSE) {
  foreach (array(SYS_PATH, APP_PATH) as $path) {
		if (file_exists("$path/$file")) {
			include_once("$path/$file");
      
      return TRUE;
    }
	}
  
  sys_error("Could not load file: " . htmlentities($file), $kill);
	
	return FALSE;
}

/**
 * Log function for system errors.
 *
 * @param string $message
 * 				The error message.
 * @param bool $kill = FALSE
 * 				(optional) flag setting wether to kill the application. If TRUE, will
 * 				route to an HTTP 400 error page. 
 */
function sys_error($message, $kill = FALSE) {
  error_log($message);
	
	if ($kill) {
		try {
			// Prevent a redirection loop
			if (segment(0) != '400') {
				C_Router::kill();
			}
		}
		catch(ErrorException $e) {
			die("Colibri encountered an unrecoverable error !");
		}
	}
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
		if (conf('i18n_enabled')) {
			load_file('C_I18nRouter.php');

			$this->router = new C_I18nRouter();
		}
		else {
			$this->router = new C_Router();
		}
		
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
    if ($class == 'C_Error' || !load_file('controllers/' . $class . conf('class_extension'))) {
			// Get the error handler and generate a 404 error
			load_file('C_Error.php', TRUE);
			
			if ($class != 'C_Error') {				
				$method = 'error404';
			}
			
			$class = 'C_Error';
		}
		
    $controller = new $class();
    
    call_user_func_array(array($controller, $method), $args);
		
		echo $controller->render();
  }
}