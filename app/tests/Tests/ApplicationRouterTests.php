<?php

if (!defined('PHPUnit_MAIN_METHOD')) {
  define('PHPUnit_MAIN_METHOD', "ApplicationRouterTests::main");
}

// Include app configuration
require_once('conf.php');

// Get the application core class
require_once(COLIBRI_SYS_PATH . 'lib/Colibri/Application.php');

global $colibri;

$colibri = new Colibri\Application(COLIBRI_CONF_PATH);

/**
 *
 */
class ApplicationRouterTests extends PHPUnit_Framework_TestCase {

  protected $controllers;

  public function setUp() {
    $this->controllers = array();

    $controller_extension = Colibri\conf('class_extension');

    $controller_dir = opendir(Colibri\conf('dir_controllers'));

    while ($file = readdir($controller_dir)) {
      if (strpos($file, $controller_extension)) {
        $this->controllers[] = substr($file, 0, -strlen($controller_extension));
      }
    }

    closedir($controller_dir);

    // Include the core files here, as we need them before running the application
    require_once(COLIBRI_SYS_PATH . 'lib/Colibri/Router.php');
    require_once(COLIBRI_SYS_PATH . 'lib/Colibri/Controller.php');
    require_once(COLIBRI_SYS_PATH . 'lib/Colibri/View.php');

    // Include all autoloads before running the application
    foreach (Colibri\conf('autoload', array()) as $file) {
      require_once(COLIBRI_WEB_PATH . $file);
    }

    // Include all controllers, else we cannot access their method definitions
    foreach ($this->controllers as $file) {
      require_once(Colibri\conf('dir_controllers') . $file . Colibri\conf('class_extension'));
    }
  }

  public static function main() {
    $suite  = new PHPUnit_Framework_TestSuite('ApplicationRouterTests');

    $result = PHPUnit_TextUI_TestRunner::run($suite);

    return $suite;
  }

  /**
   * Test application URLs
   */
  public function testURLs() {
    global $colibri;

    $router = new Colibri\Router();

    foreach($this->controllers as $controller) {
      $methods = get_class_methods($controller);

      foreach ($methods as $method) {
        // Private method ?
        if (strpos($method, '_') !== 0 && $method !== 'render') {
          $path = $router->prepare_for_uri("/$controller/$method/param1/param2");

          $_SERVER['PATH_INFO'] = $path;

          $colibri->run();

          $this->assertEquals($controller, $colibri->get_router()->get_class(), "Found correct class name for $path.");
          $this->assertEquals($method, $colibri->get_router()->get_method(), "Find correct method name for $path.");
          $this->assertTrue(!!strlen($colibri->get_response()), "Got response string for $path.");
          $this->assertContains('Content-type', array_keys($colibri->get_headers()), "Found 'Content-type' header for $path.");
        }
      }
    }
  }
}

// Call MyClassTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'ApplicationRouterTests::main') {
  RouterTest::main();
}
