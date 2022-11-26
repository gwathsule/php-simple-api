<?php

error_reporting(E_ALL ^ E_DEPRECATED);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

use Klein\Klein;
use Klein\Request;
use Klein\Response;
use Src\Adapter\Controller\CreateFairController;

require_once '../vendor/autoload.php';

$server = new Klein();

$server->respond('GET', '/', function (Request $request, Response $response) {
    return 'Hello world';
});

$server->respond('POST', '/fair', function (Request $request, Response $response) {
    $controller = new CreateFairController();
    return $controller->handle($request, $response);
});

$server->dispatch();
