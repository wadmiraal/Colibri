<?php

/**
 *
 */

if (!defined('SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

function conf($name) {
  global $_conf;
  
  return isset($_conf[$name]) ? $_conf[$name] : NULL;
}

function url($controller, $method = 'index', $arguments = array()) {
  $url = conf('base_path') . $controller;
  
  if (empty($arguments) && $method == 'index') {
    return $url;
  }
  
  $url .= '/' . urlencode($method);
  
  if (!empty($arguments)) {
    foreach ($arguments as $arg) {
      $url .= '/' . urlencode($arg);
    }
  }
  
  return $url;
}
