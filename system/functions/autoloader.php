<?php

// this will autoload all system classes
foreach(glob($root."system/classes/*.php") as $filename)
{
  include_once $filename;
}


// This will make it possible to autoload all models (no sub directories yet)
foreach (glob($root."models/*.php") as $filename)
{
    include_once $filename;
}
