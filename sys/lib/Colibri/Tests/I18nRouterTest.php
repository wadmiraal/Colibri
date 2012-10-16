<?php

if (!defined('PHPUnit_MAIN_METHOD')) {
  define('PHPUnit_MAIN_METHOD', "RouterTest::main");
}

require_once 'ColibriTestCase.php';
require_once 'RouterTest.php';

ColibriTestCase::load_dependencies(array('RouterInterface', 'Router', 'I18nRouter'));

/**
 *
 */
class I18nRouterTest extends RouterTest {

  protected $RouterClass = 'Colibri\I18nRouter';

  public function setUp() {
    $this->test_urls = array(
      array(
        'path' => '/fr-FR/dummy-controller/index/param1',
        'class' => 'Dummy_Controller',
        'method' => 'index',
        'params' => array('param1'),
        'language' => 'fr-FR',
      ),
      array(
        'path' => '/ITA/dummycontroller/test-method/param1/12/hi+all%2fthere',
        'class' => 'Dummycontroller',
        'method' => 'test_method',
        'params' => array('param1', 12, 'hi all/there'),
        'language' => 'ITA',
      ),
      array(
        'path' => '/pol___/dummycontroller/test-method/param1/12/hi+all%2fthere',
        'class' => 'Dummycontroller',
        'method' => 'test_method',
        'params' => array('param1', 12, 'hi all/there'),
        'language' => 'pol___',
      ),
      array(
        'path' => '/FR_be/dummycontroller/test-method/param1/12/hi+all%2fthere',
        'class' => 'Dummycontroller',
        'method' => 'test_method',
        'params' => array('param1', 12, 'hi all/there'),
        'language' => 'FR_be',
      ),
      array(
        'path' => '/en_US--/dummy-controller',
        'class' => 'Dummy_Controller',
        'method' => 'index',
        'params' => array(),
        'language' => 'en_US--',
      ),
      array(
        'path' => '/dummy-controller',
        'class' => 'Dummy_Controller',
        'method' => 'index',
        'params' => array(),
        'language' => 'default',
      ),
      array(
        'path' => '/dummy-controller/myMethod_ofDoom/123//asdsad/éèààéè',
        'class' => 'Dummy_Controller',
        'method' => 'myMethod_ofDoom',
        'params' => array(123, NULL, 'asdsad', 'éèààéè'),
        'language' => 'default',
      ),
    );
  }

  /**
   * Test URL locale parsing
   * Make sure the Router gets the correct language.
   */
  public function testURLLocaleParsing() {
    foreach($this->test_urls as $test) {
      $_SERVER['PATH_INFO'] = $test['path'];

      $router = new $this->RouterClass();

      $router->route();

      $this->assertEquals($test['language'],  $router->language(), "Find correct language for {$test['path']}");
    }
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
