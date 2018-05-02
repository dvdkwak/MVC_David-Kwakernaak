<?php
  if(isset($page['controller']) && !empty($page['controller']) && !isset($page['errors'])){
    if(is_array($page['controller'])){
      foreach($page['controller'] AS $controller){
        include_once($root."controllers/".$controller);
      }
    }else{
      include_once($root."controllers/".$page['controller']);
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
    <?php
      if(isset($page['style']) && is_array($page['style'])){
        foreach($page['style'] AS $stylesheet){
          echo "<link rel='stylesheet' href='/app/css/".$stylesheet."'>";
        }
      }
    ?>
    <title>
      <?php
        if(!isset($page['title']) && empty($page['title'])){
          echo end($urlParams);
        }else{
          echo $page['title'];
        }
      ?>
    </title>
  </head>
  <body>
    <?php include_once($root.'views/DOM/'.$page['view']) ?>
    <script src="/lib/jquery/jquery.min.js"></script>
    <script src="/lib/bootstrap/js/bootstrap.min.js"></script>
    <?php
      if(isset($page['script']) && is_array($page['script'])){
        foreach($page['script'] AS $script){
          echo "<script src='/app/js/".$script."'></script>";
        }
      }
    ?>
  </body>
</html>
