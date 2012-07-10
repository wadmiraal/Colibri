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
if (!defined('COLIBRI_SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

class C_View {
  
  /**
   * The name of the layout, without the extension.
   */
  protected $layout;
  
  /**
   * The directory where the layout is located.
   */
  protected $layout_directory;
  
  /**
   * The name of the view, without the extension.
   */
  protected $view;
  
  /**
   * The directory where the view is located.
   */
  protected $view_directory;
  
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
    $this->layout = $layout . conf('template_extension');
    
    $this->layout_directory = conf('dir_layouts');
    
    $this->view = $view . conf('template_extension');
    
    $this->view_directory = conf('dir_views');
    
    $this->vars = array();
    
    $this->scripts = array();
    
    $this->stylesheets = array();
    
    $this->to_json = FALSE;
    
    $this->headers = array('Content-type' => 'text/html');
    
    // Add base path var
    $this->set('base_path', conf('base_path'));
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
   * @param string $directory = NULL
   *        (optional) the directory where the view is located. Defaults to
   *        COLIBRI_SYS_PATH . 'layouts/'
   * @param string $extension = NULL
   *        (optional) the extension of the view. Defaults to conf('template_extension')
   */
  public function layout($layout, $directory = NULL, $extension = NULL) {
    $layout .= isset($extension) ? $extension : conf('template_extension');
    
    $this->layout = $layout;
    
    if (!empty($directory)) {
      $this->layout_directory = $directory;
    }
  }
  
  /**
   * Sets the view.
   *
   * @param string $view
   *        The name of the view, without the file extension.
   * @param string $directory = NULL
   *        (optional) the directory where the view is located. Defaults to
   *        COLIBRI_SYS_PATH . 'views/'
   * @param string $extension = NULL
   *        (optional) the extension of the view. Defaults to conf('template_extension')
   */
  public function view($view, $directory = NULL, $extension = NULL) {
    $view .= isset($extension) ? $extension : conf('template_extension');
    
    $this->view = $view;
    
    if (!empty($directory)) {
      $this->view_directory = $directory;
    }
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
      try {
        // Get the vars
        $vars = $this->vars;
        
        // First render the view
        $view = $this->_render_template($vars, $this->view, $this->view_directory);
        
        // Make sure we get them all again: PHP 5.3 passes variables be reference
        $vars = $this->vars;
        
        // Add/change some defaults
        $vars['view']        = $view;
        $vars['stylesheets'] = $this->_render_stylesheets();
        $vars['scripts']     = $this->_render_scripts();
        
        // Second, render the layout
        $full = $this->_render_template($vars, $this->layout, $this->layout_directory);
        
        return $full;
      }
      catch (ErrorException $e) {
        sys_error("Could not parse the templates !", TRUE);
      }
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
    
    require_once($directory . $template);
    
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