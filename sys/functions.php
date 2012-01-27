<?php

/**
 *
 */

if (!defined('SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

function conf($name) {
  global $_config;
  
  return isset($_config[$name]) ? $_config[$name] : NULL;
}
