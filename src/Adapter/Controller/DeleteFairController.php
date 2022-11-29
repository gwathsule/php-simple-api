<?php

namespace Src\Adapter\Controller;

use Klein\Request;
use Klein\Response;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Exception\ItemNotFoundException;
use Src\Domain\UseCase\DeleteFair\DeleteFair;
use Throwable;

class DeleteFairController implements Controller
{
    public function handle(Request $request, Response $response): Response
    {
        $repository = new FairRepositorySqlite();
        $useCase = new DeleteFair($repository);
        try {
            $useCase->execute($request->paramsNamed()->get('id'));
            return $response->json(['deleted']);
        } catch (ItemNotFoundException $exception) {
            return $response
                ->code(404)
                ->json(['message' => $exception->getMessage()]);
        } catch (Throwable) {
            return $response
                ->code(500)
                ->json(['message' => 'Internal server error.']);
        }

    }
}