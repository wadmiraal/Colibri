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
 * Defines the I18nRouter class, responsible for routing the requests to the
 * correct controllers when i18n is enabled.
 */

namespace Colibri;

/**
 * No direct access.
 */
if (!defined('COLIBRI_SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

class I18nRouter extends Router {

  /**
   * The current, requested "language".
   */
  protected $language;

  /**
   * Returns the current language.
   */
  public static function language() {
    return $this->language;
  }

  /**
   * @override
   */
  protected function _parse_uri() {
    $uri = @explode('/', $this->uri);

    // Remove the first empty element
    array_shift($uri);

    // The next element is the language parameter.
    $lan = array_shift($uri);

    // If the file exists, we're dealing with a controller. Use the default
    // language.
    if (file_exists(conf('dir_controllers') . $this->_class_name($lan) . conf('class_extension'))) {
      $this->language = conf('i18n_default_language');
    }
    else {
      $this->language = $lan;

      // We must modify the $this->uri, so the parent class can route normally
      $this->uri = '/' . implode('/', $uri);
    }

    parent::_parse_uri();
  }

}
