<?php

namespace Test\Helpers\Traits;

use Src\Adapter\Controller\Controller;
use Klein\Request;
use Klein\Response;

trait WebTestCase
{
    private function post(Controller $controller, array $dataPost): Response
    {
        $requestFake = new Request(body: json_encode($dataPost));
        $responseFake = new Response();

        return $controller->handle($requestFake, $responseFake);
    }

    private function delete(Controller $controller, int $id)
    {
        $requestFake = new Request();
        $requestFake->paramsNamed()->set('id', $id);
        $responseFake = new Response();

        return $controller->handle($requestFake, $responseFake);
    }

    private function put(Controller $controller, int $id, array $data)
    {
        $requestFake = new Request(body: json_encode($data));
        $requestFake->paramsNamed()->set('id', $id);
        $responseFake = new Response();

        return $controller->handle($requestFake, $responseFake);
    }
}