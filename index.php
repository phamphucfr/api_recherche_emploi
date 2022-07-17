<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    require ("classes/$class.php");
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

if ($parts[1] != "products") {
    http_response_code(404);
    exit;
}

$id = $parts[2] ?? null;

$jobManager = new JobManager;

$controller = new JobController($jobManager);

$controller->processRequest($_SERVER["REQUEST_METHOD"], $id);

?>