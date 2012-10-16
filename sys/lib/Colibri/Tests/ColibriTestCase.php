<?php

define('COLIBRI_SYS_PATH', '../../../');

class ColibriTestCase extends PHPUnit_Framework_TestCase {

  /**
   *
   */
  public static function load_dependencies($files = array()) {
    require_once COLIBRI_SYS_PATH . 'lib/Colibri/Application.php';

    // Load conf file
    require_once COLIBRI_SYS_PATH . 'lib/Colibri/Tests/ressources/conf.php';

    foreach ($files as $file) {
      require_once COLIBRI_SYS_PATH . 'lib/Colibri/' . $file . '.php';
    }
  }

  static function assertEquals($first, $second, $message = '') {
    return parent::assertEquals($first, $second, $message . ' (' . print_r($first, 1) . ' == ' . print_r($second, 1) . ')');
  }

}
