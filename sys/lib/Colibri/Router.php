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
 * Defines the Router class, responsible for routing the requests to the
 * correct controllers.
 */

namespace Colibri;

/**
 * No direct access.
 */
if (!defined('COLIBRI_SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

require_once(COLIBRI_SYS_PATH . 'lib/Colibri/RouterInterface.php');


class Router implements RouterInterface {

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
   * The segments of the URL.
   */
  protected $segments;


  public function __construct() {
    $this->_get_uri();
  }

  /**
   * @inheritDoc
   */
  public function get_class() {
    return $this->class_name;
  }

  /**
   * @inheritDoc
   */
  public function get_method() {
    return $this->method;
  }

  /**
   * @inheritDoc
   */
  public function get_arguments() {
    return $this->arguments;
  }

  /**
   * @inheritDoc
   */
  public function prepare_for_uri($string) {
    return str_replace('_', '-', strtolower($string));
  }

  /**
   * @inheritDoc
   */
  public function segment($index) {
    return isset($this->segments[$index]) ? $this->segments[$index] : NULL;
  }

  /**
   * @inheritDoc
   */
  public function route() {
    $uri = (array) @explode('/', $this->uri);

    // Remove the first empty element
    array_shift($uri);

    // Store them
    $this->segments = $uri;

    $this->arguments = array();

    // URI is empty
    if (empty($this->uri) || empty($uri)) {
      // Get default class
      $this->class_name = conf('default_controller');

      // Default method
      $this->method = 'index';
    }
    else {
      // Get class
      $this->class_name = $this->_class_name(array_shift($uri));

      // Only one segment
      if (empty($uri)) {
        $this->method = 'index';
      }
      // More than one segment
      else {
        // Get method
        $method = $this->_method_name(array_shift($uri));

        if (empty($method)) {
          $this->method = 'index';
        }
        else {
          $this->method = $method;
        }

        // Get arguments and decode them from the url
        foreach ($uri as $arg) {
          $this->arguments[] = urldecode($arg);
        }
      }
    }
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
   *        The method name, with - replaced by _. If the method is private, returns FALSE
   */
  protected function _method_name($string) {
    // Replace - with _
    $string = str_replace('-', '_', $string);

    if (strpos($string, '_') === 0) {
      // Probably a private method.
      return FALSE;
    }

    return $string;
  }
}
