<?php

/**
 *
 */

if (!defined('SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

class C_Router {
  
  protected $uri;
  
  protected $class_name;
  
  protected $method;
  
  protected $arguments;
  
  public function __construct() {
    $this->_get_uri();  
  }
  
  public function get_class() {
    return $this->class_name;
  }
  
  public function get_method() {
    return $this->method;
  }
  
  public function get_arguments() {
    return $this->arguments;
  }
  
  protected function _get_uri() {
    if (!empty($_SERVER['PATH_INFO'])) {
      $this->uri = $_SERVER['PATH_INFO'];
    }
    elseif (!empty($_SERVER['PHP_SELF']) && !empty($_SERVER['SCRIPT_NAME'])) {
      $this->uri = substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']));
    }
    else {
      $this->uri = '';
    }
    
    $this->_parse_uri();
  }
  
  protected function _parse_uri() {
    $uri = @explode('/', $this->uri);
    
    // Remove the first empty element
    array_shift($uri);
    
    $this->arguments = array();
    
    if (empty($this->uri) || empty($uri)) {
      // Get default class
      $this->class_name = conf('default_controller');
      
      // Default method
      $this->method = 'index';
    }
    else {      
      if (count($uri) == 1) {
        // Get class
        $this->class_name = $this->_class_name(array_shift($uri));
        
        // Default method
        $this->method = 'index';
      }
      else {
        // Get class
        $this->class_name = $this->_class_name(array_shift($uri));
        
        // Get method
        $method = array_shift($uri);
        if (empty($method)) {
          $this->method = 'index';
        }
        elseif (!$this->method = $this->_method_name($method)) {
          sys_error("Could not find method " . htmlentities($method) . " on class " . htmlentities($this->class_name));
        }
        
        // Arguments
        while ($arg = array_shift($uri)) {
          $this->arguments[] = urldecode($arg);
        }
      }
    }
  }
  
  protected function _class_name($string) {
    $parts = explode('-', $string);
    
    foreach ($parts as &$part) {
      $part = strtoupper(substr($part, 0, 1)) . substr($part, 1);
    }
    
    $class = implode('_', $parts);
    
    return $class;
  }
  
  protected function _method_name($string) {
    if (strpos($string, '_') === 0) {
      // Probably a private method.
      return FALSE;
    }
    
    // Include the class definition
    load_file('controllers/' . $this->class_name . conf('class_extension'));
    
    // Check if the method exists on the class
    $methods = (array) get_class_methods($this->class_name);
    
    if (!empty($methods) && in_array($string, $methods)) {
      return $string;
    }
    else {
      return FALSE;
    }
  }
}