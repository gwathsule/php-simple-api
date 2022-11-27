<?php

namespace Src\Adapter\Controller;

use Klein\Request;
use Klein\Response;

class CreateFairController implements Controller
{

    public function handle(Request $request, Response $response): Response
    {
        return $response->json(json_decode($request->body()));
    }
}