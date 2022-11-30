<?php

namespace Src\Adapter\Controller;

use Klein\Request;
use Klein\Response;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Contracts\Logger;
use Src\Domain\Repository\FairRepository;
use Src\Domain\UseCase\FilterFair\FilterFair;
use Src\Domain\UseCase\FilterFair\InputDto;
use Src\Infra\Log\FileLogAdapter;
use Throwable;

class FilterFairController implements Controller
{
    public function __construct(
        private Logger $logger = new FileLogAdapter(),
        private FairRepository $repository = new FairRepositorySqlite()
    ) {
    }

    public function handle(Request $request, Response $response): Response
    {
        try {
            $useCase = new FilterFair($this->repository);
            $filters = $request->paramsGet()->all();

            $filtersDto = InputDto::buildFromArray($filters);
            $output = $useCase->execute($filtersDto);
            return $response->json($output);

        } catch (Throwable $exception) {
            $this->logger->logException($exception);
            return $response
                ->code(500)
                ->json(['message' => 'Internal server error.']);
        }
    }
}