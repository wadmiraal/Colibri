<?php 

if (!defined('PHPUnit_MAIN_METHOD')) {
  define('PHPUnit_MAIN_METHOD', "RouterTest::main");
}

require_once 'ColibriTestCase.php';
require_once 'RouterTest.php';

ColibriTestCase::load_dependencies(array('C_Router', 'C_I18nRouter'));

/**
 * 
 */
class I18nRouterTest extends RouterTest {
  
  protected $RouterClass = 'C_I18nRouter';
  
  public function setUp() {
    $this->test_urls = array(
      array(
        'path' => '/fr-FR/dummy-controller/index/param1',
        'class' => 'Dummy_Controller',
        'method' => 'index',
        'params' => array('param1')
      ),
      array(
        'path' => '/ITA/dummycontroller/test-method/param1/12/hi+all%2fthere',
        'class' => 'Dummycontroller',
        'method' => 'test_method',
        'params' => array('param1', 12, 'hi all/there')
      ),
      array(
        'path' => '/pol___/dummycontroller/test-method/param1/12/hi+all%2fthere',
        'class' => 'Dummycontroller',
        'method' => 'test_method',
        'params' => array('param1', 12, 'hi all/there')
      ),
      array(
        'path' => '/FR_be/dummycontroller/test-method/param1/12/hi+all%2fthere',
        'class' => 'Dummycontroller',
        'method' => 'test_method',
        'params' => array('param1', 12, 'hi all/there')
      ),
      array(
        'path' => '/en_US--/dummy-controller',
        'class' => 'Dummy_Controller',
        'method' => 'index',
        'params' => array()
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
    $suite  = new PHPUnit_Framework_TestSuite('I18nRouterTest');
    
    $result = PHPUnit_TextUI_TestRunner::run($suite);
    
    return $suite;
  }
  
}

// Call MyClassTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'RouterTest::main') {
  RouterTest::main();
}