<?php

session_start();

$root = __DIR__;
$root = $root."/../../";

include_once($root."system/functions/route.php");

// Setting the $url = $_GET[url]
if(1){ // container to fold all
  if(!isset($_GET['url']) || empty($_GET['url'])){
    $url = 'home';
    $urlParams = array('home');
  }else{
    $url = $_GET['url'];
    $urlParams = explode("/", trim($url, "/"));
  }
}


// Calling the route class
$route = new Route;
