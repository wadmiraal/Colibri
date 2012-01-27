<?php

class Hi extends C_Controller {
  public function all() {
    die('<pre>' . print_r(func_get_args(), 1));
  }
}