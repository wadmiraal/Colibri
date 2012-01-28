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
 * Defines the C_Router class, responsible for routing the requests to the
 * correct controllers.
 */

/**
 * No direct access.
 */
if (!defined('SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

class C_Router {
  
  /**
   * The current, requested uri.
   */
  protected $uri;
  
  /**
   * The class name of the requested controller.
   */
  protected $class_name;
  
  /**
   * The method on the requested controller.
   */
  protected $method;
  
  /**
   * The arguments to pass to the requested controller.
   */
  protected $arguments;
  
  /**
   * Constructor...
   */
  public function __construct() {
    $this->_get_uri();  
  }
  
  /**
   * Returns the requested class name.
   *
   * @return string
   *        The class name.
   */
  public function get_class() {
    return $this->class_name;
  }
  
  /**
   * Returns the requested method.
   *
   * @return string
   *        The method name.
   */
  public function get_method() {
    return $this->method;
  }
  
  /**
   * Returns the passes arguments.
   *
   * @return array
   *        The arguments.
   */
  public function get_arguments() {
    return $this->arguments;
  }
  
  /**
   * Parses a string for the URI and returns it.
   *
   * @param string $string
   *        The class name or method.
   *
   * @return string
   *        The element, ready for the URI.
   */
  public static function prepare_for_uri($string) {
    return str_replace('_', '-', strtolower($string));
  }
  
  /**
   * Gets the current uri and parses it.
   * @see _parse_uri()
   */
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
  
  /**
   * Parses the current uri and stores the class name, the method and the
   * arguments.
   */
  protected function _parse_uri() {
    $uri = @explode('/', $this->uri);
    
    // Remove the first empty element
    array_shift($uri);
    
    $this->arguments = array();
    
    // URI is empty
    if (empty($this->uri) || empty($uri)) {
      // Get default class
      $this->class_name = conf('default_controller');
      
      // Default method
      $this->method = 'index';
    }
    else {
      // Only one segment
      if (count($uri) == 1) {
        // Get class
        $this->class_name = $this->_class_name(array_shift($uri));
        
        // Default method
        $this->method = 'index';
      }
      // More than one segment
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
        
        // Get arguments and decode them from the url
        while ($arg = array_shift($uri)) {
          $this->arguments[] = urldecode($arg);
        }
      }
    }
  }
  
  /**
   * Parses a class name and returns it.
   *
   * @param string $string
   *        The class name from the URI.
   *
   * @return string
   *        The class name, CamelCased, with - replaced by _
   */
  protected function _class_name($string) {
    $parts = explode('-', $string);
    
    foreach ($parts as &$part) {
      $part = strtoupper(substr($part, 0, 1)) . substr($part, 1);
    }
    
    $class = implode('_', $parts);
    
    return $class;
  }
  
  /**
   * Parses the method name and checks if it exists on the class.
   *
   * @param string $string
   *        The method name.
   *
   * @return string|false
   *        The method name, with - replaced by _. If the method was not found
   *        on the class, returns FALSE
   */
  protected function _method_name($string) {
    // Replace - with _
    $string = str_replace('-', '_', $string);
    
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