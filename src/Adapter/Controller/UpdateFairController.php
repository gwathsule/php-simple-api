<?php

namespace Src\Adapter\Controller;

use Klein\Request;
use Klein\Response;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Contracts\Logger;
use Src\Domain\Exception\ItemNotFoundException;
use Src\Domain\Repository\FairRepository;
use Src\Domain\UseCase\UpdateFair\UpdateFair;
use Src\Infra\Log\FileLogAdapter;
use Throwable;

class UpdateFairController implements Controller
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
            $useCase = new UpdateFair($this->repository);
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

    private function buildValidator(array $inputs): Validation
    {
        return $this->validator->make($inputs, [
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