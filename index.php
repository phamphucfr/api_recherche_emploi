<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    require ("classes/$class.php");
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

// header("Content-type:application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

if (count($parts) < 2) {
    http_response_code(404);
    exit;
}
else{
    $id= null; 

    var_dump($parts);

    if(count($parts) > 2){
        switch ($parts[2]) {
            case "id":
                $id = $parts[3] ?? null;
                break;           
            default:
                http_response_code(404);
                exit;
                break;
            }
    }
    
    if(count($parts) > 1){
        switch ($parts[1]) {
            case "company":
                $manager = new CompanyManager;
                $controller = new CompanyController($manager);            
                $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
                break;
            case "competence":
                $manager = new CompetenceManager;
                $controller = new CompetenceController($manager);            
                $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);         
                break; 
            case "experience":
                $manager = new ExperienceManager;
                $controller = new ExperienceController($manager);            
                $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);            
                break;   
            case "job":
                $manager = new JobManager;
                $controller = new JobController($manager);            
                $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);       
                break; 
            case "plateform":
                $manager = new PlateformManager;
                $controller = new PlateformController($manager);            
                $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);             
                break;                             
            default:
                http_response_code(404);
                exit;
                break;
            }
    }
    
}


?>