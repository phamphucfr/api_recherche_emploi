<?php

spl_autoload_register('classes_autoloader');
function classes_autoloader($class) {
    require_once 'classes/'.$class.'.php';
}

$cnx = null;

switch($_SERVER['REQUEST_METHOD'])
{
case 'GET': echo("Mon nom est ".$_GET['name']." . J'ai ".$_GET['age']." ans.");
            break;
case 'POST': echo($_POST); 
            break;
default: $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            echo($actual_link);
            break;
}


?>