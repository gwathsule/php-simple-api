<?php

namespace Src\Adapter\Controller;

use Klein\Request;
use Klein\Response;
use Rakit\Validation\Validator;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Contracts\Logger;
use Src\Domain\Exception\ItemNotFoundException;
use Src\Domain\Repository\FairRepository;
use Src\Domain\UseCase\DeleteFair\DeleteFair;
use Src\Infra\Log\FileLogAdapter;
use Throwable;

class DeleteFairController implements Controller
{
    public function __construct(
        private Logger $logger = new FileLogAdapter(),
        private FairRepository $repository = new FairRepositorySqlite()
    ) {
    }

    public function handle(Request $request, Response $response): Response
    {
        try {
            $useCase = new DeleteFair($this->repository);
            $useCase->execute($request->paramsNamed()->get('id'));
            return $response->json(['deleted']);
        } catch (ItemNotFoundException $exception) {
            $this->logger->logException($exception);
            return $response
                ->code(404)
                ->json(['message' => $exception->getMessage()]);
        } catch (Throwable $exception) {
            $this->logger->logException($exception);
            return $response
                ->code(500)
                ->json(['message' => 'Internal server error.']);
        }

    }
}