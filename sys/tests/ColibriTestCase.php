<?php

require_once 'PHPUnit/Autoload.php';

define('COLIBRI_SYS_PATH', '../');

class ColibriTestCase extends PHPUnit_Framework_TestCase {
  
  /**
   *
   */
  public static function load_dependencies($files = array()) {
    require_once COLIBRI_SYS_PATH . 'Colibri.php';
    
    // Load conf file
    require_once COLIBRI_SYS_PATH . 'tests/ressources/conf.php';
    
    foreach ($files as $file) {
      require_once COLIBRI_SYS_PATH . $file . '.php';
    }
  }
  
}