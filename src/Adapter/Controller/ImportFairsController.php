<?php

namespace Src\Adapter\Controller;

use Klein\Request;
use Klein\Response;
use Rakit\Validation\Validator;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\UseCase\ImportFairs\ImportFairs;
use Throwable;

class ImportFairsController implements Controller
{
    public function __construct(private Validator $validator)
    {
    }

    public function handle(Request $request, Response $response): Response
    {
        try {
            $repository = new FairRepositorySqlite();
            $useCase = new ImportFairs($repository);
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
            $results = $useCase->execute($file['tmp_name']);
            return $response->json($results->toArray());

        } catch (Throwable) {
            return $response
                ->code(500)
                ->json(['message' => 'Internal server error.']);
        }
    }
}