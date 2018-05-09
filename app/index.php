<?php
// Includes DONT TOUCH!
include_once("../system/config/config.php");
include_once($root."config/config.php");
include_once($root."system/functions/autoloader.php");
// ________________________________**CREATE YOU ROUTES HERE**___________________________
// Routes are create as the following:
// $route->add("route", "view", "page title", "controller", [styleSheet1, styleSheet2], [script1.js, script2.js], [data]);
// for a var in your route (can only be 1 and the last item) route => "[url parameter 1]/#[variable name]"
// This iniates the standard (home) page ($url = "/home")
$route->add(); // to catch the "home" url

// Start adding your routes here! :D









//______________________________________________________________________________________
// This beneath is the generated page
$page = $route->createPage($urlParams, $url);
$page = $route->check($page);
include_once($root."system/views/home.php");
