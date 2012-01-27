<?php

class Home extends C_Controller {
  
  public function __construct() {
    // If you override the constructor, do not forget to call the parent
    // constructor as well !
    parent::__construct();
  }
  
  public function index() {
    // Could define another layout if needed. Defaults to 'default'. Do not
    // add the extension.
    $this->view->layout('default');
    
    // Could define another view. Defaults to 'default'. This is usually
    // different per controller. Do not add the extension.
    $this->view->view('default');
    
    // Define any variables you want for the views and layouts. These variables
    // are shared between the layout and the views, except for:
    //  - content: in the layout, will be the entire view.
    //  - stylesheets
    //  - scripts
    // You can set these variables for your views however. The values will just
    // be different for the layouts
    $this->view->set('my_head_title', 'Home page | my site');
    
    $this->view->set('my_title', 'Home page');
    
    $this->view->set('my_custom_var', 'This is some default text.');
    
    // This variable will be available in a view, but not in a layout
    $this->view->set('content', '<p><strong>This is some more text and <a href="' . url('Home', 'hello', array('world', '<script>alert("evil !")</script>')) . '">a link</a>.</strong></p>');
    
    // Can add stylesheets and scripts easily
    $this->view->add_js('js/my-file.js');
    $this->view->add_css('css/my-file.css');
  }
  
  public function hello($name, $xss_script_that_you_dont_want_in_your_content) {
    $this->view->set('my_head_title', 'Hello page | my site');
    
    $this->view->set('my_title', 'Hello page');
    
    $this->view->set('my_custom_var', $name);
    
    // Careful ! URL params are not sanitized ! That's your job !
    $this->view->set('content', $xss_script_that_you_dont_want_in_your_content);
  }
}