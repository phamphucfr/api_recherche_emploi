<?php

spl_autoload_register('classes_autoloader');
function classes_autoloader($class) {
    require_once 'classes/'.$class.'.php';
}

switch($_SERVER['REQUEST_METHOD'])
{
case 'GET': if(count($_GET) === 0) echo("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
            else echo("Mon nom est ".$_GET['name']." . J'ai ".$_GET['age']." ans.");
            break;
case 'POST': echo($_POST); 
            break;
default:    break;
}


?>