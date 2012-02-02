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
 * Defines the C_View class. Stores variables and passes them during rendering
 * to the template files.
 */

/**
 * No direct access.
 */
if (!defined('SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

class C_View {
  
  /**
   * The name of the layout, without the extension.
   */
  protected $layout;
  
  /**
   * The name of the view, without the extension.
   */
  protected $view;
  
  /**
   * The variables that will be passed to the templates.
   */
  protected $vars;
  
  /**
   * An array of javascript files to add to the layout.
   */
  protected $scripts;
  
  /**
   * An array of stylesheets to add to the layout.
   */
  protected $stylesheets;
  
  /**
   * A flag telling the C_View to render the vars to a JSON string.
   */
  protected $to_json;
  
  /**
   * An array of headers to send to the browser.
   */
  protected $headers;
  
  /**
   * Constructor...
   *
   * @param string $layout = 'default'
   *        (optional ) the name of the layout, without the extension.
   *        Defaults to 'default'.
   * @param string $view = 'default'.
   *        (optional) the name of the view, without the extension.
   *        Defaults to 'default'.
   */
  public function __construct($layout = 'default', $view = 'default') {
    $this->layout = $layout;
    
    $this->view = $view;
    
    $this->vars = array();
    
    $this->scripts = array();
    
    $this->stylesheets = array();
    
    $this->to_json = FALSE;
    
    $this->headers = array('Content-type' => 'text/html');
  }
  
  /**
   * Adds a javascript file to the list.
   *
   * @param string $file
   *        The path of the javascript file.
   */
  public function add_js($file) {
    $this->scripts[] = $file;
  }
  
  /**
   * Adds a stylesheet to the list.
   *
   * @param string $file
   *        The path of the stylesheet.
   */
  public function add_css($file) {
    $this->stylesheets[] = $file;
  }
  
  /**
   * Sets the layout.
   *
   * @param string $layout
   *        The name of the layout, without the file extension.
   */
  public function layout($layout) {
    $this->layout = $layout;
  }
  
  /**
   * Sets the view.
   *
   * @param string $view
   *        The name of the view, without the file extension.
   */
  public function view($view) {
    $this->view = $view;
  }
  
  /**
   * Sets a variable value, usable in the layouts and views.
   *
   * @param string $name
   *        The name of the variable.
   * @param mixed $value
   *        The value if the variable
   */
  public function set($name, $value) {
    $this->vars[$name] = $value;
  }
  
  /**
   * Gets a variable.
   *
   * @param string $name
   *        The name of the variable.
   */
  public function get($name) {
    return isset($this->vars[$name]) ? $this->vars[$name] : NULL;
  }
  
  /**
   * Sets the render mode to JSON.
   */
  public function json() {
    $this->set_header('Content-type', 'application/json');
    
    $this->to_json = TRUE;
  }
  
  /**
   * Sets a header.
   *
   * @param string $header
   *        The header (e.g.: 'Content-type').
   * @param string $value
   *        The header value (e.g.: 'text/html').
   */
  public function set_header($header, $value) {
    $this->headers[$header] = $value;
  }
  
  /**
   * Gets all the headers set for this view.
   *
   * @return array
   *        The array of headers.
   */
  public function get_headers() {
    return $this->headers;
  }
  
  /**
   * Renders the view and the layout and returns the HTML.
   *
   * @return string
   *        The rendered HTML.
   */
  public function render() {
    foreach ($this->headers as $header => $value) {
      header("$header: $value");
    }
    
    if ($this->to_json) {      
      return json_encode($this->vars);
    }
    else {      
      // Get the vars
      $vars = $this->vars;
      
      // First render the view
      $view = $this->_render_template($vars, $this->view, 'views');
      
      // Make sure we get them all again: PHP 5.3 passes variables be reference
      $vars = $this->vars;
      
      // Add/change some defaults
      $vars['content']     = $view;
      $vars['stylesheets'] = $this->_render_stylesheets();
      $vars['scripts']     = $this->_render_scripts();
      
      // Second, render the layout
      $full = $this->_render_template($vars, $this->layout, 'layouts');
      
      return $full;
    }
  }
  
  /**
   * Renders the requested template file and extracts the variables.
   *
   * @param array $vars
   *        The variables to be extracted.
   * @param string $template
   *        The name of the template file, without the extension.
   * @param string $directory
   *        The directory where the template is located (layouts or views).
   *
   * @return string
   *        The rendered HTML.
   */
  protected function _render_template($vars, $template, $directory) {
    extract($vars, EXTR_SKIP);
    
    ob_start();
    
    require_once(APP_PATH . '/' . $directory . '/' . $template . conf('template_extension'));
    
    $html = ob_get_contents();
    
    ob_end_clean();
    
    return $html;
  }
  
  /**
   * Renders the stylesheet list as HTML <link>s.
   *
   * @return string
   *        The rendered HTML.
   */
  protected function _render_stylesheets() {
    $html = '';
    
    $base_path = conf('base_path');
    
    foreach ($this->stylesheets as $stylesheet) {
      $html .= '<link href="' . $base_path . $stylesheet . '" type="text/css" rel="stylesheet" />' . "\n";
    }
    
    return $html;
  }
  
  /**
   * Renders the javascript files list as HTML <script>s.
   *
   * @return string
   *        The rendered HTML.
   */
  protected function _render_scripts() {
    $html = '';
    
    $base_path = conf('base_path');
    
    foreach ($this->scripts as $script) {
      $html .= '<script src="' . $base_path . $script . '"></script>' . "\n";
    }
    
    return $html;
  }
}