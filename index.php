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
    $id= null; $name=null; $reference=null;

    if($parts[2]){
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
    
    if($part[1]){
        switch ($parts[1]) {
            case "company":
                $companyManager = new CompanyManager;

                $controller = new JobController($jobManager);
            
                $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
                break;
            case "competence":
                $name = $parts[3] ?? null;           
                break; 
            case "experience":
                $reference = $parts[3] ?? null;             
                break;   
            case "job":
                $jobManager = new JobManager;
                $controller = new JobController($jobManager);            
                $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);         
                break; 
            case "plateform":
                $reference = $parts[3] ?? null;             
                break;                             
            default:
                http_response_code(404);
                exit;
                break;
            }
    }
    
}


?>