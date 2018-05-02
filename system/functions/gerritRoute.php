<?php

  function match($urlParams){ // all pramaeters in the url given by the user
    foreach($this-routes AS $route){

      $uri_path = explode($route['route']);// wat je de route meegeeft als url

      if(count($uri_path) === count($urlParams)){ // Grootte controleren
        $values = array();
        foreach($urlParams AS $key => $val){
          if(preg_match('/{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)}/', $val)){
            $this->parameters[] = $basePath[$key];
            $values[] = $basePath[$key];
          }else{
            $values[] = $val;
          }
        }
        echo implode("/", $values);
      }
      return false;
    }
  }

?>

private function match(Route $route)
{
   $uri = explode('/', trim($route->uri, '/')); // Route gegeven in systeem
   $basePath = explode('/', trim($this->basePath, '/')); // Route van adresbalk

   // page/article/2  page/#title/#id

   // array(page, #title, #id)
   // array(page, article, 2) page/article/2


   if (count($uri) === count($basePath)) { // Check grootte
       $values = array();
       foreach ($uri as $key => $value) { // Loop door route array
           $values[] = preg_match('/{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)}/', $value)
               ? $this->parameters[] = $basePath[$key]
               : $value;
       }

       if ('/' . implode('/', $values) === $this->basePath) {
           return true;
       }
   }
   return false;
}
