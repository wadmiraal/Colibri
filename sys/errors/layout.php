<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
  <title><?php echo $title; ?></title>
  
  <style>
  body {
    margin: 0;
    padding: 0;
    background: url(http://wadmiraal.net/colibri/background.png) center top repeat-y #dbd2c6;
  }
  
  #main {
    width: 374px;
    margin: 50px auto;
  }
  
  a img { border: 0; }
  
  #logo {
    text-align: center;
  }
  
  #message {
    margin-top: 20px;
    height: 192px;
    background: url(http://wadmiraal.net/colibri/message.png) left top no-repeat;
  }
  </style>
</head>
<body>
  <div id="main">    
    <?php echo $content; // required ?>
  </div>
</body>
</html>