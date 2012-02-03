<div id="logo">
  <p><img src="http://wadmiraal.net/colibri/what.png" alt="404 - Page not found" /></p>
  
  <h1>Oups ! It seems that this URL does not exist !</h1>
  
  <?php if (!empty($controller)): ?>
    <h3>Controller: <?php echo $controller; ?></h3>
  <?php endif; ?>
  
  <?php if (!empty($method)): ?>
    <h3>Method: <?php echo $method; ?></h3>
  <?php endif; ?>
  
  <p><a href="<?php echo url(conf('default_controller')); ?>">Return to the home page</a>
</div>
