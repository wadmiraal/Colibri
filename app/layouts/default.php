<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
  <title><?php echo $my_head_title; ?></title>
  
  <?php echo $stylesheets; // not required, can be ignored ?>
  
  <?php echo $scripts; // not required, can be ignored ?>
</head>
<body>
  <div id="main">
    <h1><?php echo $my_title; ?></h1>
    
    <?php echo $content; // required ?>
  </div>
</body>
</html>