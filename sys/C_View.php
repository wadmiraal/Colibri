<?php

/**
 *
 */

if (!defined('SYS_PATH')) {
  die("You are not allowed to access this script directly !");
}

class C_View {
  
  protected $layout;
  
  protected $view;
  
  protected $vars;
  
  protected $scripts;
  
  protected $stylesheets;
  
  public function __construct($layout = 'default', $view = 'default') {
    $this->layout = $layout;
    
    $this->view = $view;
    
    $this->vars = array();
    
    $this->scripts = array();
    
    $this->stylesheets = array();
  }
  
  public function add_js($file) {
    $this->scripts[] = $file;
  }
  
  public function add_css($file) {
    $this->stylesheets[] = $file;
  }
  
  public function layout($layout) {
    $this->layout = $layout;
  }
  
  public function view($view) {
    $this->view = $view;
  }
  
  public function set($name, $value) {
    $this->vars[$name] = $value;
  }
  
  public function get($name) {
    return isset($this->vars[$name]) ? $this->vars[$name] : NULL;
  }
  
  public function render() {
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
  
  protected function _render_template($vars, $template, $directory) {
    extract($vars, EXTR_SKIP);
    
    ob_start();
    
    require_once(APP_PATH . '/' . $directory . '/' . $template . conf('template_extension'));
    
    $html = ob_get_contents();
    
    ob_end_clean();
    
    return $html;
  }
  
  protected function _render_stylesheets() {
    $html = '';
    
    $base_path = conf('base_path');
    
    foreach ($this->stylesheets as $stylesheet) {
      $html .= '<link href="' . $base_path . $stylesheet . '" type="text/css" rel="stylesheet" />' . "\n";
    }
    
    return $html;
  }
  
  protected function _render_scripts() {
    $html = '';
    
    $base_path = conf('base_path');
    
    foreach ($this->scripts as $script) {
      $html .= '<script src="' . $base_path . $script . '"></script>' . "\n";
    }
    
    return $html;
  }
}