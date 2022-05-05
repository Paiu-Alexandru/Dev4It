<?php

spl_autoload_register('autoload');

function autoload($clasName)
{
   $path = $clasName.".php";
   if (!file_exists($path)) {
       return false;
   }
   include_once $path;
}


?>