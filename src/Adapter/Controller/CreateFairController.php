<?php

namespace Src\Adapter\Controller;

use Klein\Request;
use Klein\Response;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Contracts\Logger;
use Src\Domain\Exception\DuplicatedRegisterException;
use Src\Domain\Repository\FairRepository;
use Src\Domain\UseCase\CreateFair\CreateFair;
use Src\Domain\UseCase\CreateFair\InputInputDto;
use Rakit\Validation\Validator;
use Rakit\Validation\Validation;
use Src\Infra\Log\FileLogAdapter;
use Throwable;

class CreateFairController implements Controller
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

            $useCase = new CreateFair($this->repository, $this->logger);
            $inputs = json_decode($request->body(), true);

            $validation = $this->buildValidator($inputs);
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

            $inputData = new InputInputDto(
                id: $inputs['id'],
                long: $inputs['long'],
                lat: $inputs['lat'],
                setcens: $inputs['setcens'],
                areap: $inputs['areap'],
                coddist: $inputs['coddist'],
                distrito: $inputs['distrito'],
                codsubpref: $inputs['codsubpref'],
                subprefe: $inputs['subprefe'],
                regiao5: $inputs['regiao5'],
                regiao8: $inputs['regiao8'],
                nome_feira: $inputs['nome_feira'],
                registro: $inputs['registro'],
                logradouro: $inputs['logradouro'],
                numero: $inputs['numero'] ?? null,
                bairro: $inputs['bairro'],
                referencia: $inputs['referencia'] ?? null,
            );

            $output = $useCase->execute($inputData);
            return $response->json($output->toArray());

        } catch (DuplicatedRegisterException $exception) {
            $this->logger->logException($exception);
            return $response
                ->code(409)
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
            'id'   => 'required|numeric',
            'long'   => 'required|numeric',
            'lat'   => 'required|numeric',
            'setcens'   => 'required',
            'areap'   => 'required',
            'coddist'   => 'required|numeric',
            'distrito'   => 'required',
            'codsubpref'   => 'required|numeric',
            'subprefe'   => 'required',
            'regiao5'   => 'required',
            'regiao8'   => 'required',
            'nome_feira'   => 'required',
            'registro'   => 'required',
            'logradouro'   => 'required',
            'bairro'   => 'required',
        ]);
    }
}