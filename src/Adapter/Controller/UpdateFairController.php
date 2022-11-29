<?php

namespace Src\Adapter\Controller;

use Klein\Request;
use Klein\Response;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Exception\ItemNotFoundException;
use Src\Domain\UseCase\UpdateFair\UpdateFair;
use Throwable;

class UpdateFairController implements Controller
{
    public function handle(Request $request, Response $response): Response
    {
        try {
            $repository = new FairRepositorySqlite();
            $useCase = new UpdateFair($repository);
            $updateDate = json_decode($request->body(), true);

            $validation = $this->buildValidator($updateDate);
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
            $output = $useCase->execute($updateDate, $request->paramsNamed()->get('id'));
            return $response->json($output->toArray());

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

    private function buildValidator(array $inputs): Validation
    {
        $validator = new Validator;
        return $validator->make($inputs, [
            'long'   => 'nullable|numeric',
            'lat'   => 'nullable|numeric',
            'setcens'   => 'nullable',
            'areap'   => 'nullable',
            'coddist'   => 'nullable|numeric',
            'distrito'   => 'nullable',
            'codsubpref'   => 'nullable|numeric',
            'subprefe'   => 'nullable',
            'regiao5'   => 'nullable',
            'regiao8'   => 'nullable',
            'nome_feira'   => 'nullable',
            'registro'   => 'nullable',
            'logradouro'   => 'nullable',
            'bairro'   => 'nullable',
        ]);
    }
}