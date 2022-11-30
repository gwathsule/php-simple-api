<?php

namespace Src\Adapter\Controller;

use Klein\Request;
use Klein\Response;
use Rakit\Validation\Validator;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Contracts\Logger;
use Src\Domain\Repository\FairRepository;
use Src\Domain\UseCase\ImportFairs\ImportFairs;
use Src\Infra\Log\FileLogAdapter;
use Throwable;

class ImportFairsController implements Controller
{
    public function __construct(
        private Validator $validator = new Validator(),
        private Logger $logger = new FileLogAdapter(),
        private FairRepository $repository = new FairRepositorySqlite()
    ) {
    }

    public function handle(Request $request, Response $response): Response
    {
        try {
            $useCase = new ImportFairs($this->repository, $this->logger);
            $file = $request->files()->get('csv_file');

            $validation = $this->validator->make(['csv_file' => $file], [
                'csv_file'   => 'required|uploaded_file:0,1M,csv',
            ]);

            $validation->validate();
            if ($validation->fails()) {
                $errors = $validation->errors();
                return $response
                    ->code(400)
                    ->json([
                        'message' => 'Validation error',
                        'errors' => $errors->firstOfAll()
                    ]);
            }
            $results = $useCase->execute($file['tmp_name'], $this->logger);
            return $response->json($results->toArray());

        } catch (Throwable $exception) {
            $this->logger->logException($exception);
            return $response
                ->code(500)
                ->json(['message' => 'Internal server error.']);
        }
    }
}