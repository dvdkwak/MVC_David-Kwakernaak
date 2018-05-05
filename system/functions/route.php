<?php

// This class returns an array with data needed to built a page
class Route
{

  // **PROPERTIES**

  private $routes = []; // All routes will be stored here


  // **METHODS**

  // add($route, $view, $controller, $style, $data) => boolean
  // This function will add the route, title, view, controller and if needed style, script and data to the routes.
  public function add($route = "home", $view = "standard.php", $title = "Welcome!", $controller = NULL,
  $style = ['standard/UC.css'],
  $script = ['functions/center.function.js', 'functions/scrollDownToTarget.function.js', 'standard/UC_base.js'],
  $data = NULL){
    $this->routes[] = array(
      'route' => $route,
      'title' => $title,
      'view' => $view,
      'controller' => $controller,
      'style' => $style,
      'script' => $script,
      'data' => $data
    );
    return true;
  } // End of add();


  // createPage($urlParams) => $data[] (the right route to return)
  // This function will match the user input with existing ROUTES
  public function createPage($urlParams, $url){
    foreach($this->routes AS $key => $route){ // For each route
      $uri_path = explode("/", $route['route']);// explode the route path
      if(count($uri_path) === count($urlParams)){ // check if this one has the same number of items as $urlParams
        $values = array(); // Array which need to be the same as the requested $url in the end
        foreach($uri_path AS $keyURI => $val){ // Foreach uri_path item controle if it can be a variable
          if(preg_match('/{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)}/', $val)){
            $values[] = $urlParams[$keyURI]; // set the var the same value as given by user input
            $varKey = str_replace("{", "", $val);
            $varKey = str_replace("}", "", $varKey);
            $this->routes[$key][$varKey] = $urlParams[$keyURI];
          }else{
            $values[] = $val;
          }
        }
        $checkUrl = implode("/", $values);
        if($checkUrl === $url){
          $data = $this->routes[$key];
          return $data;
        }
      }
    }
    // When no key is set, give standard 404 information
    $data = array( // Set the data to the 404
      'route' => '404',
      'model' => '404.php',
      'view' => '404.php',
      'controller' => '',
      'style' => ['standard/404.css'],
      'script' => ['functions/center.function.js','standard/404.js'],
      'data' => ''
    );
    return $data;
  }


  // allRoutes() => Returns all current routes
  public function allRoutes(){
    return $this->routes;
  } // End of allRoutes();


  // check() => Will correct the page data (will give the right error page)
  public function check($page){

    // List of the possible errors with their codes:
    // 1: "No view set"
    // 2: "Empty view given"
    // 3: "View seems not to exist"
    // 4: "Controller seems not to exist"
    // 5: "Style is no array"
    // 6: ["sheet1 does not exist", "sheet2 does not exist"]
    // 7: "Script is no array"
    // 8: ["script1 doesnt exist", "script2 doesnt exists"]
    // 9: Title is an array
    // 10: view is given as array

    if($page['route'] !== "home"){

      // view check => this will check wether view exists
      if(1){ // container to make it possible to collapse all if statements as one (Atom only)
        if($page['view'] == "standard.php"){
          // Start code response
          $codeResponse = "
          <span style=\"color:#757575\">// Your current route:</span><br>
          <span style='color:rgb(255,99,71)'>\$route</span>-><span style='color:rgb(89,152,255)'>add</span>(
          <span style=\"color:#f4e755\">\"".$page['route']."\"</span>
          );<br>
          <br>
          <span style=\"color:#757575\">// Here is what it should look like:</span><br>
          <span style='color:rgb(255,99,71)'>\$route</span>-><span style='color:rgb(89,152,255)'>add</span>(
          <span style=\"color:#f4e755\">\"".$page['route']."\"</span>,
          <u><span style=\"color:#f4e755\">\"yourView.php\"</span></u>
          );
          ";
          // End of code respond
          $textResponse = "You did not define a <b>view</b>!<br>
          <br>
          Make sure to give a string to specify which view you want to use for this route.";
          $page['errors'][1] = array(
            "name"=> "No view set",
            "codeResponse" => $codeResponse,
            "textResponse" => $textResponse
          );
        }else
        if(!is_array($page['view']) && empty($page['view'])){
          // Start of codeResponse
          $codeResponse = "
          <span style=\"color:#757575\">// Your current route:</span><br>
          <span style='color:rgb(255,99,71)'>\$route</span>-><span style='color:rgb(89,152,255)'>add</span>(
          <span style=\"color:#f4e755\">\"".$page['route']."\"</span>,
          <u><span style=\"color:#f4e755\">\"\"</span></u>
          ";
          if($page['title'] !== "Welcome!"){
            if(is_array($page['title'])){
              $codeResponse .= ", [";
              foreach($page['title'] AS $title){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$title."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }else{
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['title']."\"</span>";
            }
          }
          if($page['controller'] !== NULL){
            if(!is_array($page['controller'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['controller']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['controller'] AS $controller){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$controller."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['style'] !== ['standard/UC.css']){
            if(!is_array($page['style'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['style']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['style'] AS $style){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$style."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['script'] !== ['functions/center.function.js', 'functions/scrollDownToTarget.function.js', 'standard/UC_base.js']){
            if(!is_array($page['script'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['script']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['script'] AS $script){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$script."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['data'] !== NULL){
            if(!is_array($page['data'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['data']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['data'] AS $data){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$data."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          $codeResponse .= ");";
          // End of codeResponse
          $textResponse = "You gave an empty <b>view.</b><br>
          Make sure to <b>give</b> a view to use for this route.";
          $page['errors'][2] = array(
            "name"=> "Empty view given",
            "codeResponse" => $codeResponse,
            "textResponse" => $textResponse
          );
        }else
        if(is_array($page['view'])){
          // Start of code response
          $codeResponse = "
          <span style=\"color:#757575\">// Your current route:</span><br>
          <span style='color:rgb(255,99,71)'>\$route</span>-><span style='color:rgb(89,152,255)'>add</span>(
          <span style=\"color:#f4e755\">\"".$page['route']."\"</span>,
          [<u>";
          foreach($page['view'] AS $view){
            $codeResponse .= "<span style=\"color:#f4e755\">\"".$view."\"</span>, ";
          }
          $codeResponse = substr($codeResponse, 0, -2);
          $codeResponse .= "</u>]
          ";
          if($page['title'] !== "Welcome!"){
            if(!is_array($page['title'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['title']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['title'] AS $title){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$title."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['controller'] !== NULL){
            if(!is_array($page['controller'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['controller']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['controller'] AS $controller){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$controller."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['style'] !== ['standard/UC.css']){
            if(!is_array($page['style'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['style']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['style'] AS $style){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$style."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['script'] !== ['functions/center.function.js', 'functions/scrollDownToTarget.function.js', 'standard/UC_base.js']){
            if(!is_array($page['script'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['script']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['script'] AS $script){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$script."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['data'] !== NULL){
            if(!is_array($page['data'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['data']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['data'] AS $data){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$data."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          $codeResponse .= ");";
          // End codeResponse
          $textResponse = "The title you gave,
          seems to be an array.<br>
          <br>
          Make sure to change this to a string.";
          $page['errors'][10] = array(
            "name"=> "View is an array",
            "codeResponse" => $codeResponse,
            "textResponse" => $textResponse
          );
        }
        if(!is_array($page['view']) && !file_exists(__DIR__."/../../views/DOM/".$page['view'])){
          // Start codeResponse
          $codeResponse = "
          <span style=\"color:#757575\">// Your current route:</span><br>
          <span style='color:rgb(255,99,71)'>\$route</span>-><span style='color:rgb(89,152,255)'>add</span>(
          <span style=\"color:#f4e755\">\"".$page['route']."\"</span>,
          <u><span style=\"color:#f4e755\">\"".$page['view']."\"</span></u>
          ";
          if($page['title'] !== "Welcome!"){
            if(!is_array($page['title'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['title']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['title'] AS $title){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$title."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['controller'] !== NULL){
            if(!is_array($page['controller'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['controller']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['controller'] AS $controller){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$controller."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['style'] !== ['standard/UC.css']){
            if(!is_array($page['style'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['style']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['style'] AS $style){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$style."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['script'] !== ['functions/center.function.js', 'functions/scrollDownToTarget.function.js', 'standard/UC_base.js']){
            if(!is_array($page['script'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['script']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['script'] AS $script){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$script."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['data'] !== NULL){
            if(!is_array($page['data'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['data']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['data'] AS $data){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$data."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          $codeResponse .= ");";
          // End codeResponse
          $textResponse = "The view \"".$page['view']."\" you gave,
          seems not to exist.<br>
          <br>
          Check the filename of your view and make sure it is the same as the given view in the route.";
          $page['errors'][3] = array(
            "name"=> "View seems not to exist",
            "codeResponse" => $codeResponse,
            "textResponse" => $textResponse
          );
        } // End of view check
      } // End if container

      // title check => is it an array? => ERROR!
      if(isset($page['title']) && is_array($page['title'])){
        // Start of code response
        $codeResponse = "
        <span style=\"color:#757575\">// Your current route:</span><br>
        <span style='color:rgb(255,99,71)'>\$route</span>-><span style='color:rgb(89,152,255)'>add</span>(
        <span style=\"color:#f4e755\">\"".$page['route']."\"</span>,
        ";
        if(!is_array($page['view'])){
          $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['view']."\"</span>";
        }else{
          $codeResponse .= ", [";
          foreach($page['view'] AS $view){
            $codeResponse .= "<span style=\"color:#f4e755\">\"".$view."\"</span>, ";
          }
          $codeResponse = substr($codeResponse, 0, -2);
          $codeResponse .= "]
          ";
        }
        if($page['title'] !== "Welcome!"){
          if(!is_array($page['title'])){
            $codeResponse .= ", <u><span style=\"color:#f4e755\">\"".$page['title']."\"</span></u>";
          }else{
            $codeResponse .= ", <u>[";
            foreach($page['title'] AS $title){
              $codeResponse .= "<span style=\"color:#f4e755\">\"".$title."\"</span>, ";
            }
            $codeResponse = substr($codeResponse, 0, -2);
            $codeResponse .= "]</u>";
          }
        }
        if($page['controller'] !== NULL){
          if(!is_array($page['controller'])){
            $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['controller']."\"</span>";
          }else{
            $codeResponse .= ", [";
            foreach($page['controller'] AS $controller){
              $codeResponse .= "<span style=\"color:#f4e755\">\"".$controller."\"</span>, ";
            }
            $codeResponse = substr($codeResponse, 0, -2);
            $codeResponse .= "]";
          }
        }
        if($page['style'] !== ['standard/UC.css']){
          if(!is_array($page['style'])){
            $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['style']."\"</span>";
          }else{
            $codeResponse .= ", [";
            foreach($page['style'] AS $style){
              $codeResponse .= "<span style=\"color:#f4e755\">\"".$style."\"</span>, ";
            }
            $codeResponse = substr($codeResponse, 0, -2);
            $codeResponse .= "]";
          }
        }
        if($page['script'] !== ['functions/center.function.js', 'functions/scrollDownToTarget.function.js', 'standard/UC_base.js']){
          if(!is_array($page['script'])){
            $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['script']."\"</span>";
          }else{
            $codeResponse .= ", [";
            foreach($page['script'] AS $script){
              $codeResponse .= "<span style=\"color:#f4e755\">\"".$script."\"</span>, ";
            }
            $codeResponse = substr($codeResponse, 0, -2);
            $codeResponse .= "]";
          }
        }
        if($page['data'] !== NULL){
          if(!is_array($page['data'])){
            $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['data']."\"</span>";
          }else{
            $codeResponse .= ", [";
            foreach($page['data'] AS $data){
              $codeResponse .= "<span style=\"color:#f4e755\">\"".$data."\"</span>, ";
            }
            $codeResponse = substr($codeResponse, 0, -2);
            $codeResponse .= "]";
          }
        }
        $codeResponse .= ");";
        // End codeResponse
        $textResponse = "The title you gave,
        seems to be an array.<br>
        <br>
        Make sure to change this to a string.";
        $page['errors'][9] = array(
          "name"=> "Title is an array",
          "codeResponse" => $codeResponse,
          "textResponse" => $textResponse
        );
      }

      // controller check => this will check wether a controller file_exists
      if(!empty($page['controller'])){
        $controllerError = false;
        if(is_array($page['controller'])){
          foreach($page['controller'] AS $controller){
            if(!file_exists(__DIR__."/../../controllers/".$controller)){
              $controllerError = true;
            }
          }
          if($controllerError){
            $nameResponse = "Controllers don't exists";
            $textResponse = "The Controllers you gave,
            seem not to exist.<br>
            <br>
            Make sure to check the filename or create a controller with the name you give";
          }
        }else{
          if(!file_exists(__DIR__."/../../controllers/".$page['controller'])){
            $controllerError = true;
            $nameResponse = "Controller doesn't exists";
            $textResponse = "The Controller you gave,
            seems not to exist.<br>
            <br>
            Make sure to check the filenames or create a controller with the name you give.";
          }
        }
        // Start of code response
        $codeResponse = "
        <span style=\"color:#757575\">// Your current route:</span><br>
        <span style='color:rgb(255,99,71)'>\$route</span>-><span style='color:rgb(89,152,255)'>add</span>(
        <span style=\"color:#f4e755\">\"".$page['route']."\"</span>,
        ";
        if(!is_array($page['view'])){
          $codeResponse .= "<span style=\"color:#f4e755\">\"".$page['view']."\"</span>";
        }else{
          $codeResponse .= "[";
          foreach($page['view'] AS $view){
            $codeResponse .= "<span style=\"color:#f4e755\">\"".$view."\"</span>, ";
          }
          $codeResponse = substr($codeResponse, 0, -2);
          $codeResponse .= "]
          ";
        }
        if($page['title'] !== "Welcome!"){
          if(!is_array($page['title'])){
            $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['title']."\"</span>";
          }else{
            $codeResponse .= ", [";
            foreach($page['title'] AS $title){
              $codeResponse .= "<span style=\"color:#f4e755\">\"".$title."\"</span>, ";
            }
            $codeResponse = substr($codeResponse, 0, -2);
            $codeResponse .= "]";
          }
        }
        if($page['controller'] !== NULL){
          if(!is_array($page['controller'])){
            $codeResponse .= ", <u><span style=\"color:#f4e755\">\"".$page['controller']."\"</span></u>";
          }else{
            $codeResponse .= ", <u>[";
            foreach($page['controller'] AS $controller){
              $codeResponse .= "<span style=\"color:#f4e755\">\"".$controller."\"</span>, ";
            }
            $codeResponse = substr($codeResponse, 0, -2);
            $codeResponse .= "]</u>";
          }
        }
        if($page['style'] !== ['standard/UC.css']){
          if(!is_array($page['style'])){
            $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['style']."\"</span>";
          }else{
            $codeResponse .= ", [";
            foreach($page['style'] AS $style){
              $codeResponse .= "<span style=\"color:#f4e755\">\"".$style."\"</span>, ";
            }
            $codeResponse = substr($codeResponse, 0, -2);
            $codeResponse .= "]";
          }
        }
        if($page['script'] !== ['functions/center.function.js', 'functions/scrollDownToTarget.function.js', 'standard/UC_base.js']){
          if(!is_array($page['script'])){
            $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['script']."\"</span>";
          }else{
            $codeResponse .= ", [";
            foreach($page['script'] AS $script){
              $codeResponse .= "<span style=\"color:#f4e755\">\"".$script."\"</span>, ";
            }
            $codeResponse = substr($codeResponse, 0, -2);
            $codeResponse .= "]";
          }
        }
        if($page['data'] !== NULL){
          if(!is_array($page['data'])){
            $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['data']."\"</span>";
          }else{
            $codeResponse .= ", [";
            foreach($page['data'] AS $data){
              $codeResponse .= "<span style=\"color:#f4e755\">\"".$data."\"</span>, ";
            }
            $codeResponse = substr($codeResponse, 0, -2);
            $codeResponse .= "]";
          }
        }
        $codeResponse .= ");";
        // End codeResponse
        if($controllerError){
          $page['errors'][4] = array(
            "name"=> $nameResponse,
            "codeResponse" => $codeResponse,
            "textResponse" => $textResponse
          );
        }
      } // End of controller check

      // style check => this will check wether a style exists
      if(!empty($page['style'])){
        if(!is_array($page['style'])){
          // Start of code response
          $codeResponse = "
          <span style=\"color:#757575\">// Your current route:</span><br>
          <span style='color:rgb(255,99,71)'>\$route</span>-><span style='color:rgb(89,152,255)'>add</span>(
          <span style=\"color:#f4e755\">\"".$page['route']."\"</span>,
          ";
          if(!is_array($page['view'])){
            $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['view']."\"</span>";
          }else{
            $codeResponse .= ", [";
            foreach($page['view'] AS $view){
              $codeResponse .= "<span style=\"color:#f4e755\">\"".$view."\"</span>, ";
            }
            $codeResponse = substr($codeResponse, 0, -2);
            $codeResponse .= "]
            ";
          }
          if($page['title'] !== "Welcome!"){
            if(!is_array($page['title'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['title']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['title'] AS $title){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$title."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['controller'] !== NULL){
            if(!is_array($page['controller'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['controller']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['controller'] AS $controller){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$controller."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['style'] !== ['standard/UC.css']){
            if(!is_array($page['style'])){
              $codeResponse .= ", <u><span style=\"color:#f4e755\">\"".$page['style']."\"</span></u>";
            }else{
              $codeResponse .= ", <u>[";
              foreach($page['style'] AS $style){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$style."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]</u>";
            }
          }
          if($page['script'] !== ['functions/center.function.js', 'functions/scrollDownToTarget.function.js', 'standard/UC_base.js']){
            if(!is_array($page['script'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['script']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['script'] AS $script){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$script."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['data'] !== NULL){
            if(!is_array($page['data'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['data']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['data'] AS $data){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$data."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          $codeResponse .= ");";
          // End codeResponse
          $textResponse = "Stylesheets should be given in an Array,
          Not a string like you did here.<br>
          <br>
          Maybe you should place brackets around the string";
          $nameResponse = "Styles is no Array";
          $page['errors'][6] = array(
            "name"=> $nameResponse,
            "codeResponse" => $codeResponse,
            "textResponse" => $textResponse
          );
        }else
        foreach($page['style'] AS $stylesheet){
          $stylesError = false;
          if(!file_exists(__DIR__."/../../app/css/".$stylesheet)){
            $stylesError = true;
          }
          if($stylesError){
            // Start of code response
            $codeResponse = "
            <span style=\"color:#757575\">// Your current route:</span><br>
            <span style='color:rgb(255,99,71)'>\$route</span>-><span style='color:rgb(89,152,255)'>add</span>(
            <span style=\"color:#f4e755\">\"".$page['route']."\"</span>,
            ";
            if(!is_array($page['view'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['view']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['view'] AS $view){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$view."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]
              ";
            }
            if($page['title'] !== "Welcome!"){
              if(!is_array($page['title'])){
                $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['title']."\"</span>";
              }else{
                $codeResponse .= ", [";
                foreach($page['title'] AS $title){
                  $codeResponse .= "<span style=\"color:#f4e755\">\"".$title."\"</span>, ";
                }
                $codeResponse = substr($codeResponse, 0, -2);
                $codeResponse .= "]";
              }
            }
            if($page['controller'] !== NULL){
              if(!is_array($page['controller'])){
                $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['controller']."\"</span>";
              }else{
                $codeResponse .= ", [";
                foreach($page['controller'] AS $controller){
                  $codeResponse .= "<span style=\"color:#f4e755\">\"".$controller."\"</span>, ";
                }
                $codeResponse = substr($codeResponse, 0, -2);
                $codeResponse .= "]";
              }
            }
            if($page['style'] !== ['standard/UC.css']){
              if(!is_array($page['style'])){
                $codeResponse .= ", <u><span style=\"color:#f4e755\">\"".$page['style']."\"</span></u>";
              }else{
                $codeResponse .= ", <u>[";
                foreach($page['style'] AS $style){
                  $codeResponse .= "<span style=\"color:#f4e755\">\"".$style."\"</span>, ";
                }
                $codeResponse = substr($codeResponse, 0, -2);
                $codeResponse .= "]</u>";
              }
            }
            if($page['script'] !== ['functions/center.function.js', 'functions/scrollDownToTarget.function.js', 'standard/UC_base.js']){
              if(!is_array($page['script'])){
                $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['script']."\"</span>";
              }else{
                $codeResponse .= ", [";
                foreach($page['script'] AS $script){
                  $codeResponse .= "<span style=\"color:#f4e755\">\"".$script."\"</span>, ";
                }
                $codeResponse = substr($codeResponse, 0, -2);
                $codeResponse .= "]";
              }
            }
            if($page['data'] !== NULL){
              if(!is_array($page['data'])){
                $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['data']."\"</span>";
              }else{
                $codeResponse .= ", [";
                foreach($page['data'] AS $data){
                  $codeResponse .= "<span style=\"color:#f4e755\">\"".$data."\"</span>, ";
                }
                $codeResponse = substr($codeResponse, 0, -2);
                $codeResponse .= "]";
              }
            }
            $codeResponse .= ");";
            // End codeResponse
            $textResponse = "The stylesheet you gave doesn't seem to exist.<br>
            <br>
            Make sure to check the filename and extensions or create a file with the given name";
            $nameResponse = "Stylesheet doesn't exist";
            $page['errors'][6] = array(
              "name"=> $nameResponse,
              "codeResponse" => $codeResponse,
              "textResponse" => $textResponse
            );
          }
        }
      } // End of style check

      // scripts check
      if(!empty($page['script'])){
        if(!is_array($page['script'])){
          // Start of code response
          $codeResponse = "
          <span style=\"color:#757575\">// Your current route:</span><br>
          <span style='color:rgb(255,99,71)'>\$route</span>-><span style='color:rgb(89,152,255)'>add</span>(
          <span style=\"color:#f4e755\">\"".$page['route']."\"</span>,
          ";
          if(!is_array($page['view'])){
            $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['view']."\"</span>";
          }else{
            $codeResponse .= ", [";
            foreach($page['view'] AS $view){
              $codeResponse .= "<span style=\"color:#f4e755\">\"".$view."\"</span>, ";
            }
            $codeResponse = substr($codeResponse, 0, -2);
            $codeResponse .= "]
            ";
          }
          if($page['title'] !== "Welcome!"){
            if(!is_array($page['title'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['title']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['title'] AS $title){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$title."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['controller'] !== NULL){
            if(!is_array($page['controller'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['controller']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['controller'] AS $controller){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$controller."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['style'] !== ['standard/UC.css']){
            if(!is_array($page['style'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['style']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['style'] AS $style){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$style."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          if($page['script'] !== ['functions/center.function.js', 'functions/scrollDownToTarget.function.js', 'standard/UC_base.js']){
            if(!is_array($page['script'])){
              $codeResponse .= ", <u><span style=\"color:#f4e755\">\"".$page['script']."\"</span></u>";
            }else{
              $codeResponse .= ", <u>[";
              foreach($page['script'] AS $script){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$script."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]</u>";
            }
          }
          if($page['data'] !== NULL){
            if(!is_array($page['data'])){
              $codeResponse .= ", <span style=\"color:#f4e755\">\"".$page['data']."\"</span>";
            }else{
              $codeResponse .= ", [";
              foreach($page['data'] AS $data){
                $codeResponse .= "<span style=\"color:#f4e755\">\"".$data."\"</span>, ";
              }
              $codeResponse = substr($codeResponse, 0, -2);
              $codeResponse .= "]";
            }
          }
          $codeResponse .= ");";
          // End codeResponse
          $textResponse = "Scripts should be given in an Array,
          Not a string like you did here.<br>
          <br>
          Maybe you should place brackets around the string";
          $nameResponse = "Script is no array";
          $page['errors'][7] = array(
            "name"=> $nameResponse,
            "codeResponse" => $codeResponse,
            "textResponse" => $textResponse
          );
        }else{
          $scriptError = false;
          foreach($page['script'] AS $script){
            if(!file_exists(__DIR__."/../../app/js/".$script)){
              $scriptError = true;
            }
          }
          if($scriptError){
            $page['errors'][8] = array(
              "name" => $nameResponse,
              "codeResponse" => $codeResponse,
              "textResponse" => $textResponse
            );
          }
        }
      }

    } // End if

    // When there is an error set the page to the error page
    if(isset($page['errors'])){
      $page['title'] = "Uh oh...";
      $page['view'] = "../../system/views/error.php";
      $page['style'] = ["../../system/styles/error.css"];
      $page['script'] = ["../../system/js/functions/center.function.js", "../../system/js/functions/scrollDownToTarget.function.js", "../../system/js/error.js"];
    }

    return $page;
  } // End of check();

} // End of class
