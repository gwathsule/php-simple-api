<?php

namespace Src\Adapter\Controller;

use Klein\Request;
use Klein\Response;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Exception\DuplicatedRegisterException;
use Src\Domain\UseCase\CreateFair\CreateFair;
use Src\Domain\UseCase\CreateFair\InputInputDto;
use Rakit\Validation\Validator;
use Rakit\Validation\Validation;
use Throwable;

class CreateFairController implements Controller
{
    public function handle(Request $request, Response $response): Response
    {
        try {
            $repository = new FairRepositorySqlite();
            $useCase = new CreateFair($repository);

            $validation = $this->buildValidator($request);
            $validation->validate();

            if ($validation->fails()) {
                $errors = $validation->errors();
                return $response
                    ->code(400)
                    ->json([
                        'message' => 'Validation error',
                        'errors' => $errors
                    ]);
            }

            $inputData = new InputInputDto(
                id: $request->param('id'),
                long: $request->param('long'),
                lat: $request->param('lat'),
                setcens: $request->param('setcens'),
                areap: $request->param('areap'),
                coddist: $request->param('coddist'),
                distrito: $request->param('distrito'),
                codsubpref: $request->param('codsubpref'),
                subprefe: $request->param('subprefe'),
                regiao5: $request->param('regiao5'),
                regiao8: $request->param('regiao8'),
                nome_feira: $request->param('nome_feira'),
                registro: $request->param('registro'),
                logradouro: $request->param('logradouro'),
                numero: $request->param('numero'),
                bairro: $request->param('bairro'),
                referencia: $request->param('referencia'),
            );

            $output = $useCase->execute($inputData);
            return $response->json($output->toArray());

        } catch (DuplicatedRegisterException $exception) {
            return $response
                ->code(400)
                ->json(['message' => $exception->getMessage()]);
        } catch (Throwable $exception) {
            return $response
                ->code(500)
                ->json(['message' => 'Internal server error.']);
        }
    }

    private function buildValidator(Request $request): Validation
    {
        $validator = new Validator;
        return $validator->make(json_decode($request->body(), true), [
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
            'numero'   => 'required',
            'bairro'   => 'required',
            'referencia'   => 'required',
        ]);
    }
}