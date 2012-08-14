<?php 

if (!defined('PHPUnit_MAIN_METHOD')) {
  define('PHPUnit_MAIN_METHOD', "RouterTest::main");
}

require_once 'ColibriTestCase.php';

ColibriTestCase::load_dependencies(array('C_Router'));

/**
 * 
 */
class RouterTest extends ColibriTestCase {
  
  protected $test_urls;
  
  protected $RouterClass = 'C_Router';
  
  public function setUp() {
    $this->test_urls = array(
      array(
        'path' => '/dummy-controller/index/param1',
        'class' => 'Dummy_Controller',
        'method' => 'index',
        'params' => array('param1')
      ),
      array(
        'path' => '/dummycontroller/test-method/param1/12/hi+all%2fthere',
        'class' => 'Dummycontroller',
        'method' => 'test_method',
        'params' => array('param1', 12, 'hi all/there')
      ),
      array(
        'path' => '/dummy-controller',
        'class' => 'Dummy_Controller',
        'method' => 'index',
        'params' => array()
      ),
      array(
        'path' => '/dummycontroller/testmethod/',
        'class' => 'C_Error',
        'method' => 'error404',
        'params' => array()
      ),
      array(
        'path' => '/faulty-controller/index',
        'class' => 'C_Error',
        'method' => 'error404',
        'params' => array()
      ),
    );
  }
  
  public static function main() {    
    $suite  = new PHPUnit_Framework_TestSuite('RouterTest');
    
    $result = PHPUnit_TextUI_TestRunner::run($suite);
    
    return $suite;
  }

  /**
   * Test URL parsing
   * Make sure the Router gets the correct controllers, methods and params.
   * If class or method does not exist, should trigger the C_Error class.
   */
  public function testURLParsing() {
    foreach($this->test_urls as $test) {
      $_SERVER['PATH_INFO'] = $test['path'];
      
      $router = new $this->RouterClass();
      
      $this->assertEquals($test['class'], $router->get_class(), "Find correct class name for {$test['path']}");
      
      $this->assertEquals($test['method'], $router->get_method(), "Find correct method name for {$test['path']}");
      
      $this->assertEquals($test['params'], $router->get_arguments(), "Find correct parameters for {$test['path']}");
      
      unset($router);
    }
  }
}

// Call MyClassTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'RouterTest::main') {
  RouterTest::main();
}