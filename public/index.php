<?php

error_reporting(E_ERROR | E_PARSE);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

use Klein\Klein;
use Klein\Request;
use Klein\Response;
use Src\Adapter\Controller\CreateFairController;
use Src\Adapter\Controller\DeleteFairController;
use Src\Adapter\Controller\UpdateFairController;
use Src\Adapter\Controller\FilterFairController;
use Src\Adapter\Controller\ImportFairsController;

require_once '../vendor/autoload.php';

$server = new Klein();

$server->respond('GET', '/', function (Request $request, Response $response) {
    return 'Hello world';
});

$server->respond('POST', '/fair', function (Request $request, Response $response) {
    $controller = new CreateFairController();
    return $controller->handle($request, $response);
});

$server->respond('DELETE', '/fair/[i:id]', function (Request $request, Response $response) {
    $controller = new DeleteFairController();
    return $controller->handle($request, $response);
});

$server->respond('PUT', '/fair/[i:id]', function (Request $request, Response $response) {
    $controller = new UpdateFairController();
    return $controller->handle($request, $response);
});

$server->respond('GET', '/fair', function (Request $request, Response $response) {
    $controller = new FilterFairController();
    return $controller->handle($request, $response);
});

$server->respond('POST', '/fair/import', function (Request $request, Response $response) {
    $controller = new ImportFairsController();
    return $controller->handle($request, $response);
});

$server->dispatch();
