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

namespace Colibri;

/**
 * No direct access.
 */
if (!defined('COLIBRI_SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

/**
 * Helper function for quickly including files.
 *
 * @param string $file
 *        The name if the file to include.
 * @param bool $kill = FALSE
 *        (optional) flag setting wether to kill the application. If TRUE, will
 *        route to an HTTP 400 error page.
 */
function load_file($file, $kill = FALSE) {
  foreach (array(COLIBRI_SYS_PATH, '') as $path) {
    if (file_exists("$path$file")) {
      include_once("$path$file");

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
 *        The error message.
 * @param bool $kill = FALSE
 *        (optional) flag setting wether to kill the application. If TRUE, will
 *        route to an HTTP 400 error page.
 */
function sys_error($message, $kill = FALSE) {
  error_log($message);

  if ($kill) {
    try {
      // Prevent a redirection loop
      if (segment(0) != '400') {
        Router::kill();
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
load_file('functions.php');
load_file('Controller.php');
load_file('Router.php');
load_file('View.php');

class Colibri {

  /**
   * The Router instance.
   */
  protected $router;

  /**
   * Constructor...
   */
  public function __construct($conf_path) {
    // Include configuration file
    require_once($conf_path);

    // Autoload
    $autoload = (array) conf('autoload');

    foreach($autoload as $file) {
      load_file($file, TRUE);
    }

    if (conf('i18n_enabled')) {
      load_file('I18nRouter.php');

      $this->router = new I18nRouter();
    }
    else {
      $this->router = new Router();
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
    if ($class == 'Error' || !load_file(conf('dir_controllers') . $class . conf('class_extension'))) {
      // Get the error handler and generate a 404 error
      $error_class = conf('404_handler');

      if ($error_class && load_file(conf('dir_controllers') . $error_class . conf('class_extension'))) {
        $class = $error_class;

        $method = 'index';
      }
      else {
        load_file('Error.php', TRUE);

        if ($class != 'Error') {
          $method = 'error404';
        }

        $class = 'Error';
      }
    }

    $controller = new $class();

    call_user_func_array(array($controller, $method), $args);

    echo $controller->render();
  }
}
