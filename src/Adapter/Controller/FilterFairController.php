<?php

namespace Src\Adapter\Controller;

use Klein\Request;
use Klein\Response;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\UseCase\FilterFair\FilterFair;
use Src\Domain\UseCase\FilterFair\InputDto;
use Throwable;

class FilterFairController implements Controller
{
    public function handle(Request $request, Response $response): Response
    {
        try {
            $repository = new FairRepositorySqlite();
            $useCase = new FilterFair($repository);
            $filters = $request->paramsGet()->all();

            $filtersDto = InputDto::buildFromArray($filters);
            $output = $useCase->execute($filtersDto);
            return $response->json($output);

        } catch (Throwable) {
            return $response
                ->code(500)
                ->json(['message' => 'Internal server error.']);
        }
    }
}